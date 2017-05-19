<?php

namespace backend\components\bootstrap;

use yii\helpers\Html;

class DateInput extends Widget
{
    public $dateFormat;

    public $format;

    public $label;

    public function init()
    {
        parent::init();
        if ($this->dateFormat === null) {
            $this->dateFormat = strtoupper(\Yii::$app->formatter->dateFormat);
        }

        if ($this->name === null && $this->model !== null && $this->attribute != null) {
            $this->name = $this->model->formName().'['.$this->attribute.']';
        }

        if ($this->label === null && $this->model !== null && $this->attribute != null) {
            $this->label = $this->model->getAttributeLabel($this->attribute);
        }
    }

    public function run()
    {
        echo $this->renderWidget();
        $this->registerClientScript();
    }

    protected function renderWidget()
    {
        if ($this->hasModel()) {
            $value = Html::getAttributeValue($this->model, $this->attribute);
        } else {
            $value = $this->value;
        }

        $content = '<div class="form-group">
                      <div class="input-group date">
                        <input type="text" name="'.$this->name.'" value="'.$value.'" data-date-format="'.$this->dateFormat.'" class="form-control">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                        </span></div>
                    </div>';

        return $content;
    }

    protected function registerClientScript()
    {
        $view = $this->getView();

        $view->registerJsFile(
          '@web/plugin/bootstrap-datetimepicker/js/moment.js',
          ['depends' => [\backend\assets\AppAsset::className()]]
        );
        $view->registerJsFile(
          '@web/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
          ['depends' => [\backend\assets\AppAsset::className()]]
        );
        $view->registerJs("
          $('.date').datetimepicker({
              pickTime: false
          });
        ");
        $view->registerCssFile(
          '@web/plugin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
          ['depends' => [\backend\assets\AppAsset::className()]]
        );
    }
}
