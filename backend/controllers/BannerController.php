<?php

namespace backend\controllers;

use common\models\BannerImage;
use yii\base\Model;
use Yii;

class BannerController extends BaseController
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $models = [new BannerImage()];

        if ($request->isPost) {
            $post = $request->post('BannerImage');
            $count = count(Yii::$app->request->post('BannerImage', []));

            for ($i = 1; $i < $count; ++$i) {
                $models[] = new BannerImage();
            }

            if (Model::loadMultiple($models, $request->post()) && Model::validateMultiple($models)) {
                $models[0]::deleteAll();
                foreach ($models as $model) {
                    $model->save(false);
                }
                Yii::$app->session->setFlash('success', 'You have modified banners!');

                return $this->redirect('index');
            }
        } else {
            $data = BannerImage::find()->orderBy(['sort_order' => SORT_ASC])->all();
            if ($data) {
                $models = $data;
            }
        }

        return $this->render('index', [
            'models' => $models,
        ]);
    }
}
