<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use backend\components\widgets\PageForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = [
  'href' => Url::toRoute('index'),
  'text' => $this->title,
];

PageForm::begin([
  'title' => $this->title,
  'headerButton' => 'backend\components\grid\headerButton',
  'model' => $model,
  'panelTitle' => <?= $generator->generateString('Create '.Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>,
]);
?>

<?= '<?= ' ?>$this->render('_form', [
    'model' => $model,
]) ?>

<?= "<?php\n PageForm::end();\n ?>";
?>
