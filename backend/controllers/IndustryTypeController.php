<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use common\models\IndustryType;
use common\models\IndustryTypeDescription;
use backend\models\IndustryTypeSearch;
use yii\web\NotFoundHttpException;

/**
 * IndustryTypeController implements the CRUD actions for IndustryType model.
 */
class IndustryTypeController extends BaseController
{
    /**
     * Lists all IndustryType models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IndustryTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new IndustryType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IndustryType();
        $industry_type_description = [];
        $languages = Yii::$app->languageManager->getLanguages();

        foreach ($languages as $key => $language) {
            $industry_type_description[$language->language_id] = new IndustryTypeDescription();
        }

        $post = Yii::$app->request->post();
        if ($model->load($post) && Model::loadMultiple($industry_type_description, $post)) {
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($industry_type_description) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $industry_type_description, $post);

                Yii::$app->session->setFlash('success', 'You have modified industry type!');
                return $this->redirect('index');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'industry_type_description' => $industry_type_description,
            'languages' => $languages,
        ]);
    }

    /**
     * Updates an existing IndustryType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $industry_type_description = [];
        $languages = Yii::$app->languageManager->getLanguages();
        $description = IndustryTypeDescription::find()->where(['industry_type_id' => $id])->indexBy('language_id')->all();

        foreach ($languages as $key => $language) {
            $industry_type_description[$language->language_id] = new IndustryTypeDescription();
            $industry_type_description[$language->language_id]->name = isset($description[$language->language_id]->name) ? $description[$language->language_id]->name : '';
        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && Model::loadMultiple($industry_type_description, $post)) {
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($industry_type_description) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $industry_type_description, $post, $id);
                Yii::$app->session->setFlash('success', 'You have modified industry type!');
                return $this->redirect('index');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'industry_type_description' => $industry_type_description,
            'languages' => $languages,
        ]);
    }

    /**
     * Deletes an existing IndustryType model.
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
                IndustryTypeDescription::deleteAll('industry_type_id = '.(int) $id);
            }
            Yii::$app->session->setFlash('success', 'You have delete industry types!');
        }
    }

    protected function updateDescription($model, $industry_type_description, $post, $id = null)
    {
        $languages = Yii::$app->languageManager->getLanguages();
        if($id){
            IndustryTypeDescription::deleteAll(['industry_type_id' => $id]);
        }
        foreach ($languages as $key => $language) {
            $industry_type_description[$language->language_id]->industry_type_id = $model->industry_type_id;
            $industry_type_description[$language->language_id]->name = $post['IndustryTypeDescription'][$language->language_id]['name'];
            $industry_type_description[$language->language_id]->language_id = $language->language_id;
            $industry_type_description[$language->language_id]->save(false);
        }
    }

    /**
     * Finds the IndustryType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return IndustryType the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IndustryType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
