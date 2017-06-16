<?php

namespace backend\components\bootstrap;

use yii\helpers\Html;

class DateInput extends Widget
{
    public $label;

    public function init()
    {
        parent::init();

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
}
