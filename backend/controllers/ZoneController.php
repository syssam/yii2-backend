<?php

namespace backend\controllers;

use Yii;
use yii\base\model;
use common\models\Zone;
use common\models\ZoneDescription;
use backend\models\ZoneSearch;
use yii\web\NotFoundHttpException;

/**
 * ZoneController implements the CRUD actions for Zone model.
 */
class ZoneController extends BaseController
{
    /**
     * Lists all Zone models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZoneSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Zone model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Zone();
        $zone_description = [];
        $languages = Yii::$app->languageManager->getLanguages();

        foreach ($languages as $key => $language) {
            $zone_description[$language->language_id] = new ZoneDescription();
        }

        $post = Yii::$app->request->post();
        if ($model->load($post) && Model::loadMultiple($zone_description, $post)) {
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($zone_description) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $zone_description, $post);
                Yii::$app->session->setFlash('success', 'You have modified zone!');

                return $this->redirect('index');
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'zone_description' => $zone_description,
                    'languages' => $languages,
                ]);
    }

    /**
     * Updates an existing Zone model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $languages = Yii::$app->languageManager->getLanguages();
        $description = ZoneDescription::find()->where(['zone_id' => $id])->indexBy('language_id')->all();
        $zone_description = [];

        foreach ($languages as $key => $language) {
            $zone_description[$language->language_id] = new ZoneDescription();
            $zone_description[$language->language_id]->name = isset($description[$language->language_id]->name) ? $description[$language->language_id]->name : '';
        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && Model::loadMultiple($zone_description, $post)) {
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($zone_description) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $zone_description, $post, $id);
                Yii::$app->session->setFlash('success', 'You have modified zone!');

                return $this->redirect('index');
            }
        }

        return $this->render('update', [
                  'model' => $model,
                  'zone_description' => $zone_description,
                  'languages' => $languages,
               ]);
    }

    /**
     * Deletes an existing ParkType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        if ($request->getIsAjax()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $selection = $request->post('selection');

            foreach ($selection as $id) {
                $this->findModel($id)->delete();
                ZoneDescription::deleteAll('zone_id = '.(int) $id);
            }
            Yii::$app->session->setFlash('success', 'You have delete zones!');
        }
    }

    protected function updateDescription($model, $description, $post, $id = null)
    {
        $languages = Yii::$app->languageManager->getLanguages();
        if ($id) {
            ZoneDescription::deleteAll(['zone_id' => $id]);
        }
        foreach ($languages as $key => $language) {
            $description[$language->language_id]->zone_id = $model->zone_id;
            $description[$language->language_id]->name = $post['ZoneDescription'][$language->language_id]['name'];
            $description[$language->language_id]->language_id = $language->language_id;
            $description[$language->language_id]->save(false);
        }
    }

    /**
     * Finds the Zone model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Zone the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Zone::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
