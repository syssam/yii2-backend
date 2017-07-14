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
            [
                'attribute' => 'name',
                'value' => 'parkDescription.name',
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'park_type_id',
                'value' => function ($model, $key, $index, $column) {
                    return isset($column->filter[$model->park_type_id]) ? $column->filter[$model->park_type_id] : '';
                },
                'filter' => $park_types,
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'manufacturer_id',
                'value' => function ($model, $key, $index, $column) {
                    return isset($column->filter[$model->manufacturer_id]) ? $column->filter[$model->manufacturer_id] : '';
                },
                'filter' => $manufacturers,
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == $model::STATUS_ACTIVE ? 'Enabled' : 'Disabled';
                },
                'filter' => array($searchModel::STATUS_ACTIVE => 'Enabled', $searchModel::STATUS_DELETED => 'Disabled'),
            ],
            ['class' => 'backend\components\grid\ActionColumn'],
        ],
    ]); ?>
<?php PageSearch::end(); ?><?php Pjax::end(); ?>
