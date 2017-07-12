<?php

use yii\helpers\Url;
use backend\components\grid\GridView;
use backend\components\widgets\PageSearch;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\IndustryTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Industry Types');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('industry-type/index'),
  'text' => $this->title,
];
?>
<?php Pjax::begin(); ?>
<?php
PageSearch::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $searchModel,
  'panelTitle' => Yii::t('app', 'Industry Type List'),
]);
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'class' => 'yii\grid\CheckboxColumn',
              'checkboxOptions' => function ($model, $key, $index, $column) {
                  return ['value' => $model->industry_type_id];
              },
            ],
            [
              'attribute' => 'name',
              'value' => 'industryTypeDescription.name',
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
