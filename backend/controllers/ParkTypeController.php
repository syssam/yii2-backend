<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use common\models\ParkType;
use common\models\ParkTypeDescription;
use backend\models\ParkTypeSearch;
use yii\web\NotFoundHttpException;

/**
 * ParkTypeController implements the CRUD actions for ParkType model.
 */
class ParkTypeController extends BaseController
{
    /**
     * Lists all ParkType models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParkTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ParkType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ParkType();
        $park_type_description = [];
        $languages = Yii::$app->languageManager->getLanguages();

        foreach ($languages as $key => $language) {
            $park_type_description[$language->language_id] = new ParkTypeDescription();
        }

        $post = Yii::$app->request->post();
        if ($model->load($post) && Model::loadMultiple($park_type_description, $post)) {
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($park_type_description) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $park_type_description, $post);
                Yii::$app->session->setFlash('success', 'You have modified park type!');

                return $this->redirect('index');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'park_type_description' => $park_type_description,
            'languages' => $languages,
        ]);
    }

    /**
     * Updates an existing ParkType model.
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
        $description = ParkTypeDescription::find()->where(['park_type_id' => $id])->indexBy('language_id')->all();
        $park_type_description = [];
        foreach ($languages as $key => $language) {
            $park_type_description[$language->language_id] = new ParkTypeDescription();
            $park_type_description[$language->language_id]->name = isset($description[$language->language_id]->name) ? $description[$language->language_id]->name : '';
        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && Model::loadMultiple($park_type_description, $post)) {
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($park_type_description) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $park_type_description, $post, $id);
                Yii::$app->session->setFlash('success', 'You have modified park type!');

                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'park_type_description' => $park_type_description,
                'languages' => $languages,
            ]);
        }
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
                ParkTypeDescription::deleteAll('park_type_id = '.(int) $id);
            }
            Yii::$app->session->setFlash('success', 'You have delete park types!');
        }
    }

    protected function updateDescription($model, $description, $post, $id = null)
    {
        $languages = Yii::$app->languageManager->getLanguages();
        if ($id) {
            ParkTypeDescription::deleteAll(['park_type_id' => $id]);
        }
        foreach ($languages as $key => $language) {
            $description[$language->language_id]->park_type_id = $model->park_type_id;
            $description[$language->language_id]->name = $post['ParkTypeDescription'][$language->language_id]['name'];
            $description[$language->language_id]->language_id = $language->language_id;
            $description[$language->language_id]->save(false);
        }
    }

    /**
     * Finds the ParkType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return ParkType the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParkType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
