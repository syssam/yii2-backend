<?php
namespace backend\actions;

use yii;
use yii\base\Action;

class AccessControlAction extends Action
{
    public function run()
    {
        if (Yii::$app->getRequest()->getIsAjax()) {
            return $this->renderAjaxResponse();
        }
        
        return $this->renderHtmlResponse();
    }

    protected function renderAjaxResponse()
    {
        return 'not found';
    }

    protected function denyAccess()
    {
        return $this->controller->render('/common/index');
    }
}
?>
