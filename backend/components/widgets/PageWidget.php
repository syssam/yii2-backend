<?php

namespace backend\components\widgets;

use yii;
use yii\helpers\Url;

abstract class PageWidget extends \yii\base\Widget
{
    public $title;
    public $headerButton;
    public $headerButtonOption;
    public $model;
    public $content;
    public $panelTitle;

    public function init()
    {
        parent::init();

        ob_start();
    }

    public function run()
    {
        $this->content = ob_get_clean();
        echo $this->renderPageHeader();
        echo $this->renderContainer();
    }

    abstract protected function renderHeaderButton();

    protected function renderPageHeader()
    {
        $breadcrumbs[] = [
          'href' => Url::toRoute('common/index'),
          'text' => 'Home',
        ];
        $breadcrumbs = array_merge($breadcrumbs, Yii::$app->view->params['breadcrumbs']);
        $breadcrumbHtml = '';
        foreach ($breadcrumbs as $breadcrumb) {
            $breadcrumbHtml .= '<li><a href="'.$breadcrumb['href'].'">'.$breadcrumb['text'].'</a></li>';
        }

        return '<div class="page-header">
                  <div class="container-fluid">
                    <div class="pull-right">
                      '.$this->renderHeaderButton().'
                    </div>
                    <h1>'.$this->title.'</h1>
                    <ul class="breadcrumb">
                      '.$breadcrumbHtml.'
                    </ul>
                  </div>
                </div>';
    }

    protected function renderPanel()
    {
        return '<div class="panel panel-default">'.$this->renderPanelHeader().$this->renderPanelBody().'<div>';
    }

    protected function renderPanelHeader()
    {
        $panelTitle = $this->model->isNewRecord ? 'Create' : 'Edit';

        return '<div class="panel-heading">
                 <h3 class="panel-title"><i class="fa fa-list"></i> '.$panelTitle.$this->title.'</h3>
                </div>';
    }

    protected function renderPanelBody()
    {
        return '<div class=\"panel-body\">'.$this->content.'</div>';
    }

    protected function renderContainer()
    {
        return '<div class="container-fluid">'.$this->renderMessage().$this->renderPanel().'</div>';
    }

    protected function renderMessage()
    {
        $messageHtml = '';

        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            switch ($key) {
              case 'success':
                $icon = 'fa fa-check-circle';
                $text = 'Success: ';
                break;
              case 'danger':
                $icon = 'fa-exclamation-circle';
                $text = 'Warning: ';
                break;
              default:
                $icon = '';
                break;
            }
            $messageHtml .= '<div class="alert alert-'.$key.'"><i class="'.$icon.'"></i> '.$text.$message.'<button type="button" class="close" data-dismiss="alert">×</button></div>';
        }

        return $messageHtml;
    }
}
