<?php

use yii\helpers\Url;
use common\models\Tag;
use backend\components\grid\GridView;
use backend\components\widgets\PageSearch;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tags');
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('tag/index'),
  'text' => $this->title,
];
?>
<?php Pjax::begin(); ?>
<?php
PageSearch::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $searchModel,
  'panelTitle' => 'Tag List',
]);
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'class' => 'yii\grid\CheckboxColumn',
              'checkboxOptions' => function ($model, $key, $index, $column) {
                  return ['value' => $model->tag_id];
              },
            ],
            [
              'attribute' => 'name',
              'value' => 'tagDescription.name',
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == Tag::STATUS_ACTIVE ? 'Enabled' : 'Disabled';
                },
                'filter' => array(Tag::STATUS_ACTIVE => 'Enabled', Tag::STATUS_DELETED => 'Disabled'),
            ],
            'sort_order',
            ['class' => 'backend\components\grid\ActionColumn'],
        ],
    ]); ?>
<?php PageSearch::end(); ?><?php Pjax::end(); ?>
