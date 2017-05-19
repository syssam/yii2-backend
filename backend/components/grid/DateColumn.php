<?php

namespace backend\components\grid;

use yii\grid\DataColumn;
use yii\helpers\Html;
use backend\components\bootstrap\DateInput;

class DateColumn extends DataColumn
{
    protected function renderFilterCellContent()
    {
        $model = $this->grid->filterModel;

        if ($this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' '.Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }

            return DateInput::Widget([
                'model' => $model,
                'attribute' => $this->attribute,
                'format' => $this->format,
            ]).$error;
        }
    }
}
