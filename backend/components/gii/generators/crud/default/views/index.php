<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Url;
use backend\components\grid\GridView;
use backend\components\widgets\PageSearch;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? '/* @var $searchModel '.ltrim($generator->searchModelClass, '\\')." */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>/index'),
  'text' => $this->title,
];
?>
<?= $generator->enablePjax ? '<?php Pjax::begin(); ?>' : '' ?>
<?="\n<?php\n"; ?>
PageSearch::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $searchModel,
  'panelTitle' => <?=$generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass)) . ' List')?>,
]);
?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= '<?= ' ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            [
              'class' => 'yii\grid\CheckboxColumn',
              'checkboxOptions' => function ($model, $key, $index, $column) {
                  return ['value' => $model-><?=$generator->getTableSchema()->primaryKey[0] ?>];
              },
            ],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '".$name."',\n";
        } else {
            echo "            // '".$name."',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '".$column->name.($format === 'text' ? '' : ':'.$format)."',\n";
        } else {
            echo "            // '".$column->name.($format === 'text' ? '' : ':'.$format)."',\n";
        }
    }
}
?>

            ['class' => 'backend\components\grid\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
    <?= '<?= ' ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>
<?= '<?php PageSearch::end(); ?>' ?>
<?= $generator->enablePjax ? '<?php Pjax::end(); ?>' : '' ?>
