<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\filters\AccessControlFilter;
/**
 * Site controller
 */
class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'access-control' => [
                'class' => AccessControlFilter::className(),
            ],
        ];
    }
}
