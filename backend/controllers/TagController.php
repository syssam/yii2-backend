<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use common\models\Tag;
use common\models\TagDescription;
use backend\models\TagSearch;
use yii\web\NotFoundHttpException;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends BaseController
{
    /**
     * Lists all Tag models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tag();

        $tag_description = [];
        $languages = Yii::$app->languageManager->getLanguages();

        foreach ($languages as $key => $language) {
            $tag_description[$language->language_id] = new TagDescription();
        }

        $post = Yii::$app->request->post();
        if ($model->load($post) && Model::loadMultiple($tag_description, $post)) {
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($tag_description) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $tag_description, $post);
                Yii::$app->session->setFlash('success', 'You have modified tag!');

                return $this->redirect('index');
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'tag_description' => $tag_description,
                ]);
    }

    /**
     * Updates an existing Tag model.
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
        $description = TagDescription::find()->where(['tag_id' => $id])->indexBy('language_id')->all();

        foreach ($languages as $key => $language) {
            $park_type_description[$language->language_id] = new TagDescription();
            $park_type_description[$language->language_id]->name = isset($description[$language->language_id]->name) ? $description[$language->language_id]->name : '';
        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && Model::loadMultiple($tag_description, $post)) {
            $isValid = $model->validate();
            $isValid = Model::validateMultiple($tag_description) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $tag_description, $post, $id);
                Yii::$app->session->setFlash('success', 'You have modified tag!');

                return $this->redirect('index');
            }
        }

        return $this->render('update', [
                  'model' => $model,
                  'tag_description' => $tag_description,
                ]);
    }

    /**
     * Deletes an existing Tag model.
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
                TagDescription::deleteAll('tag_id = '.(int) $id);
            }
            Yii::$app->session->setFlash('success', 'You have delete attributes!');
        }
    }

    protected function updateDescription($model, $description, $post, $id = null)
    {
        $languages = Yii::$app->languageManager->getLanguages();
        if ($id) {
            TagDescription::deleteAll(['tag_id' => $id]);
        }
        foreach ($languages as $key => $language) {
            $description[$language->language_id]->tag_id = $model->tag_id;
            $description[$language->language_id]->name = $post['TagDescription'][$language->language_id]['name'];
            $description[$language->language_id]->language_id = $language->language_id;
            $description[$language->language_id]->save(false);
        }
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Tag the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
