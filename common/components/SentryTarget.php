<?php

namespace app\common\components;

use yii\helpers\ArrayHelper;
use yii\log\Logger;
use yii\log\Target;

/**
 * SentryTarget records log messages in a Sentry.
 *
 * @see https://sentry.io
 *
 * @property string $contextMessage
 */
class SentryTarget extends Target
{
    /**
     * @var string Sentry client key.
     */
    public $dsn;
    /**
     * @var array Options of the \Raven_Client.
     */
    public $clientOptions = [];
    /**
     * @var bool Write the context information. The default implementation will dump user information, system variables, etc.
     */
    public $context = true;
    /**
     * @var callable Callback function that can modify extra's array
     */
    public $extraCallback;
    /**
     * @var \Raven_Client
     */
    protected $client;

    /**
     * @inheritdoc
     */
    public function collect($messages, $final)
    {
//        $composer = file_get_contents('../../composer.json');
//        $composer = json_decode($composer, true);

        if (!isset($this->client)) {
            $this->client = new \Raven_Client($this->dsn, $this->clientOptions);
            $this->client->extra_context([
                'version' => '2.0.0'// $composer['version']
            ]);
        }
        parent::collect($messages, $final);
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp, $traces) = $message;
            $data = [
                'level' => static::getLevelName($level),
                'timestamp' => $timestamp,
                'tags' => ['category' => $category]
            ];
            if ($text instanceof \Throwable || $text instanceof \Exception) {
                $this->client->captureException($text, $data);
                return;
            } elseif (is_array($text)) {
                if (isset($text['msg'])) {
                    $data['message'] = $text['msg'];
                    unset($text['msg']);
                }

                if (isset($text['tags'])) {
                    $data['tags'] = ArrayHelper::merge($data['tags'], $text['tags']);
                    unset($text['tags']);
                }

                $data['extra'] = $text;
            } else {
                $data['message'] = $text;
            }
            if ($this->context) {
                $data['extra']['context'] = parent::getContextMessage();
            }
            if (is_callable($this->extraCallback) && isset($data['extra'])) {
                $data['extra'] = call_user_func($this->extraCallback, $text, $data['extra']);
            }

            $this->client->capture($data, $traces);
        }
    }

    /**
     * Returns the text display of the specified level for the Sentry.
     *
     * @param integer $level The message level, e.g. [[LEVEL_ERROR]], [[LEVEL_WARNING]].
     * @return string
     */
    public static function getLevelName($level)
    {
        static $levels = [
            Logger::LEVEL_ERROR => 'error',
            Logger::LEVEL_WARNING => 'warning',
            Logger::LEVEL_INFO => 'info',
            Logger::LEVEL_TRACE => 'debug',
            Logger::LEVEL_PROFILE_BEGIN => 'debug',
            Logger::LEVEL_PROFILE_END => 'debug',
        ];
        return isset($levels[$level]) ? $levels[$level] : 'error';
    }

    /**
     * @inheritdoc
     */
    protected function getContextMessage()
    {
        return '';
    }
}