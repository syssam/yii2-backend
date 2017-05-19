<?php

namespace backend\components\widgets;

class PageForm extends PageWidget
{
    protected function renderHeaderButton()
    {
        return $this->headerButton::widget([
          'model' => $this->model,
          'visibleButtons' => ['save', 'cancel'],
        ]);
    }
}
