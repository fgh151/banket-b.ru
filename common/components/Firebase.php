<?php

declare(strict_types=1);

namespace app\common\components;

use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;
use yii\base\Component;

/**
 * Конпонент подключения к бд Firebase
 */
class Firebase extends Component
{
    /**
     * Uri бд
     */
    public $databaseUri;

    /**
     * Тип БД.
     */
    public $type;

    /**
     * Идентификатор проекта.
     */
    public $projectId;

    /**
     * Идентификатор приватного ключа.
     */
    public $privateKeyId;

    /**
     * Приватный ключ.
     */
    public $privateKey;

    /**
     * Адрес электронной почты клиента.
     */
    public $clientEmail;

    /**
     * Идентификатор клиента.
     */
    public $clientId;

    /**
     * URI авторизации.
     */
    public $authUri;

    /**
     * URI Токена
     */
    public $tokenUri;

    /**
     * URL сертификата провайдера.
     */
    public $authProviderCertUrl;

    /**
     * Клиентский сертификат.
     */
    public $clientCertUrl;

    /**
     * Фабрика работы с firebase
     */
    private $factory;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        $privateKey = str_replace('\n', "\n", $this->privateKey);
        $this->factory = new Factory();
        $this->factory->withServiceAccount([
            'type' => $this->type,
            'project_id' => $this->projectId,
            'private_key_id' => $this->privateKeyId,
            'private_key' => $privateKey,
            'client_email' => $this->clientEmail,
            'client_id' => $this->clientId,
            'auth_uri' => $this->authUri,
            'token_uri' => $this->tokenUri,
            'auth_provider_x509_cert_url' => $this->authProviderCertUrl,
            'client_x509_cert_url' => $this->clientCertUrl,
        ]);
    }

    /**
     * Возвращает инстанс бд
     */
    public function getDatabase(): Database
    {
        return $this->factory->withDatabaseUri($this->getDataBaseUri())->createDatabase();
    }

    /**
     * Возвращает URI бд
     */
    public function getDataBaseUri(): string
    {
        return $this->databaseUri;
    }
}
