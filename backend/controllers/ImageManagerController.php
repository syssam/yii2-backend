<?php

namespace backend\controllers;

use common\models\ImageManager;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class ImageManagerController extends BaseController
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $data['directory'] = $request->get('directory', null);
        $data['filter_name'] = $request->get('filter_name', null);
        $data['target'] = $request->get('target', null);
        $data['thumb'] = $request->get('thumb', null);
        $data['refresh'] = Url::current();

        $directory = null;
        if ($data['directory']) {
            $pos = strrpos(rtrim($data['directory'], DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR);
            if ($pos) {
                $directory = substr($data['directory'], 0, $pos);
            }
        }
        $data['parent'] = Url::toRoute([
                            'image-manager/index',
                            'directory' => $directory,
                            'filter_name' => $data['filter_name'],
                            'target' => $data['target'],
                            'thumb' => $data['thumb'],
                          ]);

        $provider = new ArrayDataProvider([
            'allModels' => ImageManager::find($data['directory'], $data['filter_name']),
            'pagination' => [
                'pageSize' => 16,
            ],
        ]);
        $data['pages'] = new Pagination([
            'totalCount' => $provider->totalCount,
            'params' => [
              'directory' => $data['directory'],
              'filter_name' => $data['filter_name'],
            ],
            'page' => $request->get('page', 1) - 1,
        ]);
        $data['images'] = $provider->getModels();

        return $this->renderPartial('/common/image_manager', $data);
    }

    public function actionUpload()
    {
        $model = new ImageManager();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model->files = UploadedFile::getInstances($model, 'files');
            $directory = $request->get('directory', null);
            if ($model->upload($directory)) {
                Yii::$app->response->data = ['success' => '成功：您的檔案已上傳！'];
            } else {
                Yii::$app->response->data = ['error' => '警告：不正確的檔案類型！'];
            }
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function actionDelete()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $paths = $request->post('path', []);
            if (ImageManager::remove($paths)) {
                Yii::$app->response->data = ['success' => '成功：檔案/目錄已被刪除！'];
            } else {
                Yii::$app->response->data = ['error' => '警告：檔案名稱或目錄名稱已存在！'];
            }
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function actionFolder()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $directory = $request->get('directory', null);
            $folder = $request->post('folder', null);
            if (ImageManager::createDirectory($directory, $folder)) {
                Yii::$app->response->data = ['success' => '成功：目錄已新增！'];
            } else {
                Yii::$app->response->data = ['error' => '警告：檔案名稱或目錄名稱已存在！'];
            }
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }
}
