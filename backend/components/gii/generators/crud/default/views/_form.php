<?php


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form backend\components\widgets\ActiveForm */
?>
    <?= '<?php ' ?>$form = ActiveForm::begin([
      'id' => $model->formName(),
    ]); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo '    <?= '.$generator->generateActiveField($attribute)." ?>\n\n";
    }
} ?>

    <?= '<?php ' ?>ActiveForm::end(); ?>
