<?php

namespace backend\filters;

use yii;
use yii\base\ActionFilter;
use yii\di\Instance;
use yii\web\User;

class AccessControlFilter extends ActionFilter
{
    public $user = 'user';

    public function init()
    {
        parent::init();
        $this->user = Instance::ensure($this->user, User::className());
    }

    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * You may override this method to do last-minute preparation for the action.
     *
     * @param Action $action the action to be executed
     *
     * @return bool whether the action should continue to be executed
     */
    public function beforeAction($action)
    {
        $user = $this->user;
        $route = Yii::$app->controller->route;

        if ($route == 'common/login') {
            return true;
        } else {
            if ($this->denyAccess($user)) {
                return true;
            }
        }

        return false;
    }

    protected function denyAccess($user)
    {
        $request = Yii::$app->getRequest();

        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            return true;
            /*
            if ($request->getIsAjax()) {
                echo $this->renderAjaxResponse();
            }else{
                echo $this->renderHtmlResponse();
            }*/
            //throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    protected function renderAjaxResponse()
    {
        return $this->getExceptionName().': '.$this->getExceptionMessage();
    }

    protected function renderHtmlResponse()
    {
        return Yii::$app->controller->render('/common/index');
    }
}
