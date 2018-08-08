<?php
/**
 * @author : Fedor B Gorsky
 */

namespace app\common\components;


use Yii;
use yii\base\ExitException;
use yii\web\View;

class NotPayException extends ExitException
{
    private $_view;
    public $layout = '@app/views/layouts/main';

    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $view           = $this->getView();
        $response       = yii::$app->getResponse();
        $response->data = $this->renderContent($view->render('@app/views/not-paid-exception.php', [
            'message' => $message,
        ]));

        $response->setStatusCode(403);

        parent::__construct(403, $message, $code, $previous);
    }

    /**
     * Рендер контента шаблона
     *
     * @param $content
     *
     * @return string
     */
    public function renderContent($content)
    {
        $layoutFile = $this->findLayoutFile();
        if ($layoutFile !== false) {
            return $this->getView()->renderFile($layoutFile, ['content' => $content], $this);
        }

        return $content;
    }

    /**
     * Returns the view object that can be used to render views or view files.
     * The [[render()]], [[renderPartial()]] and [[renderFile()]] methods will use
     * this view object to implement the actual view rendering.
     * If not set, it will default to the "view" application component.
     * @return View|\yii\web\View the view object that can be used to render views or view files.
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = Yii::$app->getView();
        }

        return $this->_view;
    }

    /**
     * Рендер шаблона
     * @return string
     */
    public function findLayoutFile()
    {
        return Yii::getAlias($this->layout) . '.php';

    }
}