<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use common\models\Manufacturer;
use common\models\ManufacturerSearch;
use common\models\ManufacturerDescription;
use yii\web\NotFoundHttpException;

/**
 * ManufacturerController implements the CRUD actions for Manufacturer model.
 */
class ManufacturerController extends BaseController
{
    /**
     * Lists all Manufacturer models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ManufacturerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Manufacturer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Manufacturer();
        $manufacturer_description = [];
        $languages = Yii::$app->languageManager->getLanguages();

        foreach ($languages as $key => $language) {
            $manufacturer_description[$language->language_id] = new ManufacturerDescription();
        }

        $post = Yii::$app->request->post();
        if ($model->load($post) && Model::loadMultiple($manufacturer_description, $post)) {
            $model->save();
            foreach ($languages as $key => $language) {
                $manufacturer_description[$language->language_id]->manufacturer_id = $model->manufacturer_id;
                $manufacturer_description[$language->language_id]->name = $post['ManufacturerDescription'][$language->language_id]['name'];
                $manufacturer_description[$language->language_id]->description = $post['ManufacturerDescription'][$language->language_id]['description'];
                $manufacturer_description[$language->language_id]->language_id = $language->language_id;
                $manufacturer_description[$language->language_id]->save();
            }

            Yii::$app->session->setFlash('success', 'You have modified users!');

            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
                'manufacturer_description' => $manufacturer_description,
                'languages' => $languages,
            ]);
        }
    }

    /**
     * Updates an existing Manufacturer model.
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

        foreach ($languages as $key => $language) {
            $manufacturer_description[$language->language_id] = ManufacturerDescription::find()->where([
                                                                  'manufacturer_id' => $id,
                                                                  'language_id' => $language->language_id,
                                                                ])->one();
        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && Model::loadMultiple($manufacturer_description, $post)) {
            $model->save();
            foreach ($languages as $key => $language) {
                $manufacturer_description[$language->language_id]->name = $post['ManufacturerDescription'][$language->language_id]['name'];
                $manufacturer_description[$language->language_id]->description = $post['ManufacturerDescription'][$language->language_id]['description'];
                $manufacturer_description[$language->language_id]->save();
            }

            Yii::$app->session->setFlash('success', 'You have modified users!');

            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
                'manufacturer_description' => $manufacturer_description,
                'languages' => $languages,
            ]);
        }
    }

    /**
     * Deletes an existing Manufacturer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete()
    {
        $request = Yii::$app->request;
        if ($request->getIsAjax()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $selection = $request->post('selection');

            foreach ($selection as $id) {
                $this->findModel($id)->delete();
                ManufacturerDescription::deleteAll('manufacturer_id = '.(int) $id);
            }
            Yii::$app->session->setFlash('success', 'You have delete manufacturers!');
        }
    }

    /**
     * Finds the Manufacturer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Manufacturer the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manufacturer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
