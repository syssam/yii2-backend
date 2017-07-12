<?php

use yii\helpers\Url;
use common\models\ParkType;
use backend\components\grid\GridView;
use backend\components\widgets\PageSearch;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ParkTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Park Types');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('park-type/index'),
  'text' => $this->title,
];
?>
<?php Pjax::begin(); ?>
<?php
PageSearch::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $searchModel,
  'panelTitle' => Yii::t('app', 'Park Type List'),
]);
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'class' => 'yii\grid\CheckboxColumn',
              'checkboxOptions' => function ($model, $key, $index, $column) {
                  return ['value' => $model->park_type_id];
              },
            ],
            [
              'attribute' => 'name',
              'value' => 'parkTypeDescription.name',
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == $model::STATUS_ACTIVE ? 'Enabled' : 'Disabled';
                },
                'filter' => array($searchModel::STATUS_ACTIVE => 'Enabled', $searchModel::STATUS_DELETED => 'Disabled'),
            ],
            'sort_order',
            ['class' => 'backend\components\grid\ActionColumn'],
        ],
    ]); ?>
<?php PageSearch::end(); ?><?php Pjax::end(); ?>
