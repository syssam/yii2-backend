<?php

namespace backend\models;

use yii\base\Model;
use common\models\Admin;

/**
 * Signup form.
 */
class AdminForm extends Admin
{
    public $password;
    public $comfirm;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            //['username', 'unique', 'targetClass' => '\common\models\Admin', 'message' => 'This username has already been taken.'],
            ['username', 'unique', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => '\common\models\Admin', 'message' => 'This email address has already been taken.'],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],

            ['password', 'string', 'min' => 6],

            ['comfirm', 'required', 'when' => function ($model) {
                return mb_strlen($model->password) > 0;
            }, 'whenClient' => "function (attribute, value) {
                return $('#adminform-password').length > 0;
            }"],

            ['comfirm', 'string', 'min' => 6],
            ['comfirm', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $data = \Yii::$app->request->post('AdminForm');
        $this->setAttribute('username', $data['username']);
        $this->setAttribute('email', $data['email']);
        $this->setAttribute('status', $data['status']);
        $this->generateAuthKey();
        $this->setPassword($data['password']);
        if ($this->getIsNewRecord()) {
            return $this->insert($runValidation, $attributeNames);
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
}
