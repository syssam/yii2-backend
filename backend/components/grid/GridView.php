<?php

namespace backend\components\grid;

class GridView extends \yii\grid\GridView
{
    public $tableOptions = ['class' => 'table table-bordered table-hover'];

    public $tableTitle;

    public $title;

    public function run()
    {
        $this->layout = $this->renderPanelBody();
        parent::run();
    }

    protected function renderPanelBody()
    {
        return "<div class=\"table-responsive\">{items}\n</div>".$this->renderPanelFooter();
    }

    protected function renderPanelFooter()
    {
        return '<div class="row">
                  <div class="col-sm-6 text-left">{pager}</div>
                  <div class="col-sm-6 text-right">{summary}</div>
                </div>';
    }
}
