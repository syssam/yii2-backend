<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use common\models\Attribute;
use common\models\AttributeDescription;
use backend\models\AttributeSearch;

/**
 * AttributeController implements the CRUD actions for Attribute model.
 */
class AttributeController extends BaseController
{
    /**
     * Lists all Attribute models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttributeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Attribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Attribute();

        $attribute_description = [];
        $languages = Yii::$app->languageManager->getLanguages();

        foreach ($languages as $key => $language) {
            $attribute_description[$language->language_id] = new AttributeDescription();
        }

        $post = Yii::$app->request->post();
        if ($model->load($post) && Model::loadMultiple($attribute_description, $post)) {
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($attribute_description) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $attribute_description, $post);

                Yii::$app->session->setFlash('success', 'You have modified attribute!');

                return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'attribute_description' => $attribute_description,
            ]);
        }
    }

    /**
     * Updates an existing Attribute model.
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
        $attribute_description = [];
        $description = AttributeDescription::find()->where(['attribute_id' => $id])->indexBy('language_id')->all();

        foreach ($languages as $key => $language) {
            $attribute_description[$language->language_id] = new AttributeDescription();
            $attribute_description[$language->language_id]->name = isset($description[$language->language_id]->name) ? $description[$language->language_id]->name : '';
            $attribute_description[$language->language_id]->value = isset($description[$language->language_id]->value) ? $description[$language->language_id]->value : '';
        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && Model::loadMultiple($attribute_description, $post)) {
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($attribute_description) && $isValid;
            if ($isValid) {
                $model->save();
                $this->updateDescription($model, $attribute_description, $post, $id);
                Yii::$app->session->setFlash('success', 'You have modified attribute!');

                return $this->redirect('index');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'attribute_description' => $attribute_description,
        ]);
    }

    /**
     * Deletes an existing Attribute model.
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
                AttributeDescription::deleteAll('attribute_id = '.(int) $id);
            }
            Yii::$app->session->setFlash('success', 'You have delete attributes!');
        }
    }

    protected function updateDescription($model, $description, $post, $id = null)
    {
        $languages = Yii::$app->languageManager->getLanguages();
        if ($id) {
            AttributeDescription::deleteAll(['attribute_id' => $id]);
        }
        foreach ($languages as $key => $language) {
            $description[$language->language_id]->attribute_id = $model->attribute_id;
            $description[$language->language_id]->name = $post['AttributeDescription'][$language->language_id]['name'];
            $description[$language->language_id]->value = $post['AttributeDescription'][$language->language_id]['value'];
            $description[$language->language_id]->language_id = $language->language_id;
            $description[$language->language_id]->save(false);
        }
    }

    /**
     * Finds the Attribute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Attribute the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attribute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
