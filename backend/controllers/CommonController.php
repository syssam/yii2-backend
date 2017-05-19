<?php

namespace backend\controllers;

use Yii;
use backend\models\LoginForm;
use backend\models\SignupForm;

class CommonController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionMem()
    {
        /*
        $model = new SignupForm();
        $data['SignupForm']['username'] = 'admin';
        $data['SignupForm']['email'] = 'info@fang.com';
        $data['SignupForm']['password'] = '123456';
        if ($model->load($data)) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }*/
    }
}
