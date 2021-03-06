<?php

namespace backend\components\widgets;

class PageSearch extends PageWidget
{
    protected function renderHeaderButton()
    {
        return call_user_func(
            [
              $this->headerButton,
              'widget',
            ],
            [
              'model' => $this->model,
              'visibleButtons' => ['create', 'delete'],
            ]
        );
    }
}
