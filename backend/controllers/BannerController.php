<?php

namespace backend\controllers;

use common\models\BannerImage;

class BannerController extends BaseController
{
    public function actionIndex()
    {
        $model = new BannerImage();

        $post = \Yii::$app->request->post('BannerImage');
        if ($post) {
            if ($this->validate($model, $post)) {
                $model::deleteAll();
                $save = true;
                foreach ($post as $key => $data) {
                    $model->title = $data['title'];
                    $model->link = $data['link'];
                    $model->image = $data['image'];
                    $model->sort_order = $data['sort_order'];
                    $save = $model->insert() && $save ? true : false;
                }
                if ($save) {
                    \Yii::$app->session->setFlash('success', 'You have modified banners!');
                } else {
                    \Yii::$app->session->setFlash('danger', 'Something is wrong!');
                }

                return $this->redirect(['index']);
            }
            $datas = $post;
        } else {
            $datas = $model::find()->orderBy(['sort_order' => SORT_ASC])->all();
        }

        return $this->render('index', [
            'model' => $model,
            'datas' => $datas,
            'errors' => $model->getErrors(),
        ]);
    }

    private function validate($model, $data)
    {
        $errors = [];

        foreach ($data as $index => $value) {
            $model->title = $value['title'];
            $model->link = $value['link'];
            $model->image = $value['image'];
            $model->sort_order = $value['sort_order'];
            if (!$model->validate()) {
                foreach ($model->getErrors() as $key => $value) {
                    $model->addError($index.'.'.$key, $value);
                }
            }
        }

        return !$model->hasErrors();
    }
}
