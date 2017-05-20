<?php

namespace backend\components\grid;

use yii\base\Widget;
use yii;
use yii\helpers\Html;
use yii\helpers\Url;

class HeaderButton extends Widget
{
    public $template = '{create}\n{delete}\n{save}\n{cancel}';

    public $buttons = [];

    public $visibleButtons = ['create', 'delete', 'save', 'cancel'];

    public $buttonOptions = [];

    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->initDefaultButtons();
    }

    protected function initDefaultButtons()
    {
        return
        $this->initDefaultButton('create', 'fa fa-plus').
        $this->initDefaultButton('delete', 'fa fa-trash-o').
        $this->initDefaultButton('save', 'fa fa-save').
        $this->initDefaultButton('cancel', 'fa fa-reply');
    }

    protected function initDefaultButton($name, $iconName)
    {
        $this->buttonOptions = [];

        if (!isset($this->buttons[$name]) && strpos($this->template, '{'.$name.'}') !== false && in_array($name, $this->visibleButtons)) {
            switch ($name) {
                case 'create':
                  $title = Yii::t('yii', 'Create');
                  $url = $this->createUrl('create');
                  break;
                case 'delete':
                  $title = Yii::t('yii', 'Delete');
                  $this->buttonOptions['class'] = 'btn btn-danger';
                  $this->buttonOptions['data-url'] = $this->createUrl('delete');
                  $this->buttonOptions['id'] = 'delete-button';
                  $this->registerClientScript();
                  break;
                case 'save':
                  $title = $this->model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Save');
                  $this->buttonOptions['data-form'] = $this->model->formName();
                  break;
                case 'cancel':
                  $title = Yii::t('yii', 'Cancel');
                  $url = $this->createUrl('index');
                  $this->buttonOptions['class'] = 'btn btn-default';
                  break;
                default:
                  $title = ucfirst($name);
                  break;
            }

            $options = array_merge([
                  'title' => $title,
                  'aria-label' => $title,
                  'class' => 'btn btn-primary',
                  'data-toggle' => 'tooltip',
                  'data-original-title' => $title,
              ], $this->buttonOptions);

            $icon = Html::tag('span', '', ['class' => $iconName]);

            if ($name != 'delete' && $name != 'save') {
                $this->buttons[$name] = Html::a($icon, $url, $options);
            } else {
                $this->buttons[$name] = Html::button($icon, $options);
            }

            return $this->buttons[$name]."\n";
        }
    }

    protected function createUrl($action)
    {
        $url = Yii::$app->controller->id.'/'.$action;

        return Url::toRoute($url);
    }

    protected function registerClientScript()
    {
        $js = "
        $('#delete-button').on('click', function() {
          var sure = confirm('Are you sure?');
          if(sure) {
            var data = $('input[name*=\'selection\']');
            $.ajax({
              type: 'POST',
              url: $(this).data('url'),
              data:data,
              success:function(data){
                if(data.message !== 'undefined') {
                  alert(data.message);
                }else{
                  location.reload();
                };
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('ERROR:' + errorThrown);
              },
            });
          }
        });";
        Yii::$app->getView()->registerJs($js);
    }
}
