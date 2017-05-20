<?php

use yii\helpers\Url;
use backend\components\grid\GridView;
use backend\components\widgets\PageSearch;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admins');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('admin/index'),
  'text' => $this->title,
];
?>
<?php
Pjax::begin();
PageSearch::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $searchModel,
  'panelTitle' => 'Admin List',
]); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'class' => 'yii\grid\CheckboxColumn',
              'checkboxOptions' => function ($model, $key, $index, $column) {
                  return ['value' => $model->id];
              },
            ],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == 10 ? 'Enabled' : 'Disabled';
                },
                'filter' => array('10' => 'Enabled', '0' => 'Disabled'),
            ],
            [
              'class' => 'backend\components\grid\DateColumn',
              'attribute' => 'created_at',
              'format' => 'date',
            ],
            [
              'class' => 'backend\components\grid\DateColumn',
              'attribute' => 'updated_at',
              'format' => 'date',
            ],
            ['class' => 'backend\components\grid\ActionColumn'],
        ],
    ]); ?>
<?php
PageSearch::end();
Pjax::end(); ?>
