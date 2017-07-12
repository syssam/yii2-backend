<?php

namespace backend\controllers;

use Yii;
use backend\models\AdminSearch;
use backend\models\AdminForm;
use yii\web\NotFoundHttpException;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends BaseController
{
    /**
     * Lists all Admin models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdminForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'You have modified users!');

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'You have modified users!');

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete()
    {
        $request = Yii::$app->request;
        Yii::$app->session->setFlash('success', 'You have delete users!');
        if ($request->getIsAjax()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $selection = $request->post('selection');

            if ($this->validateDelete()) {
                foreach ($selection as $id) {
                    $this->findModel($id)->delete();
                }
                Yii::$app->session->setFlash('success', 'You have delete users!');
            }
        }
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Admin the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function validateDelete()
    {
        if (in_array(Yii::$app->user->getId(), Yii::$app->request->post('selection'))) {
            Yii::$app->response->data = ['message' => 'Warning: You can not delete your own account!'];
        }

        return !Yii::$app->response->data;
    }
}
