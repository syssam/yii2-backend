<?php

use yii\helpers\Url;
use backend\components\grid\GridView;
use backend\components\widgets\PageSearch;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ManufacturerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/manufacturer', 'Manufacturers');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('manufacturer/index'),
  'text' => $this->title,
];
?>
<?php
Pjax::begin();
PageSearch::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $searchModel,
  'panelTitle' => 'Manufacturer List',
]); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'class' => 'yii\grid\CheckboxColumn',
              'checkboxOptions' => function ($model, $key, $index, $column) {
                  return ['value' => $model->manufacturer_id];
              },
            ],
            [
              'attribute' => 'name',
              'value' => 'manufacturerDescription.name',
            ],
            'sort_order',
            ['class' => 'backend\components\grid\ActionColumn'],
        ],
    ]); ?>
<?php
PageSearch::end();
Pjax::end(); ?>
