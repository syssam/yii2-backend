<?php
/**
 * @see http://www.yiiframework.com/
 *
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components\bootstrap;

use yii\base\Model;

class Widget extends \yii\base\Widget
{
    /**
     * @var Model the data model that this widget is associated with
     */
    public $model;
    /**
     * @var string the model attribute that this widget is associated with
     */
    public $attribute;
    /**
     * @var string the input name. This must be set if [[model]] and [[attribute]] are not set.
     */
    public $name;
    /**
     * @var string the input value
     */
    public $value;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return bool whether this widget is associated with a data model
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }
}
