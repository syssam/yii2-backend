<?php

use yii\helpers\Url;
use backend\components\grid\GridView;
use backend\components\widgets\PageSearch;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ParkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Parks');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('park/index'),
  'text' => $this->title,
];
?>
<?php Pjax::begin(); ?>
<?php
PageSearch::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $searchModel,
  'panelTitle' => Yii::t('app', 'Park List'),
]);
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'class' => 'yii\grid\CheckboxColumn',
              'checkboxOptions' => function ($model, $key, $index, $column) {
                  return ['value' => $model->park_id];
              },
            ],

            'park_id',
            'location_id',
            'park_type_id',
            'manufacturer_id',
            'telephone',
            // 'status',
            // 'sort_order',
            // 'created_at',
            // 'updated_at',

            ['class' => 'backend\components\grid\ActionColumn'],
        ],
    ]); ?>
<?php PageSearch::end(); ?><?php Pjax::end(); ?>