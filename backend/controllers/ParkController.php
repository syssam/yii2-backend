<?php

namespace backend\controllers;

use Yii;
use common\models\Park;
use common\models\ParkDescription;
use common\models\ParkAttribute;
use common\models\Zone;
use common\models\ParkType;
use common\models\Manufacturer;
use common\models\IndustryType;
use common\models\Attribute;
use common\models\ParkToIndustryType;
use backend\models\ParkSearch;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

/**
 * ParkController implements the CRUD actions for Park model.
 */
class ParkController extends BaseController
{
    /**
     * Lists all Park models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Park model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $zones = ArrayHelper::map(Zone::find(['status' => Zone::STATUS_ACTIVE])->joinWith('zoneDescription')->all(), 'zone_id', 'zoneDescription.name');
      $park_types = ArrayHelper::map(ParkType::find(['status' => ParkType::STATUS_ACTIVE])->joinWith('parkTypeDescription')->all(), 'park_type_id', 'parkTypeDescription.name');
      $manufacturers = ArrayHelper::map(Manufacturer::find()->joinWith('manufacturerDescription')->all(), 'manufacturer_id', 'manufacturerDescription.name');
      $industry_types =  ArrayHelper::map(IndustryType::find(['status' => IndustryType::STATUS_ACTIVE])->joinWith('industryTypeDescription')->all(), 'industry_type_id', 'industryTypeDescription.name');
      $attributes = Attribute::find(['status' => Attribute::STATUS_ACTIVE, 'type' => 1])->indexBy('attribute_id')->joinWith('attributeDescription')->all();
      $languages = Yii::$app->languageManager->getLanguages();

      $model = new Park();
      $park_to_industry_type = new ParkToIndustryType();
      $park_description = [];
      $park_attributes = [];

      foreach ($attributes as $index => $attribute) {
          foreach ($languages as $key => $language) {
              $park_attribute = new ParkAttribute();
              $park_attribute->text = $attribute->attributeDescription->value;
              $park_attributes[$index][$language->language_id] = $park_attribute;
          }
      }

      foreach ($languages as $key => $language) {
          $park_description[$language->language_id] = new ParkDescription();
      }

      $post = Yii::$app->request->post();
      if ($model->load($post) && Model::loadMultiple($park_description, $post) && $park_to_industry_type->load($post) && Model::loadMultiple($park_attributes, $post)) {
          $isValid = $model->validate();
          $isValid = Model::validateMultiple($park_description) && $isValid;
          $isValid = $park_to_industry_type->validate() && $isValid;
          $isValid = Model::validateMultiple($park_attributes) && $isValid;
          if($isValid) {
              $model->save(false);
              foreach ($languages as $key => $language) {
                  $park_description[$language->language_id]->park_id = $model->park_id;
                  $park_description[$language->language_id]->name = $post['ParkDescription'][$language->language_id]['name'];
                  $park_description[$language->language_id]->description = $post['ParkDescription'][$language->language_id]['description'];
                  $park_description[$language->language_id]->language_id = $language->language_id;
                  $park_description[$language->language_id]->save(false);
              }

              foreach ($post['ParkToIndustryType']['industry_type_id'] as $industry_type_id) {
                  $park_to_industry_type->park_id = $model->park_id;
                  $park_to_industry_type->industry_type_id = $industry_type_id;
                  $park_to_industry_type->insert(false);
              }

              foreach ($post['ParkAttribute'] as $attribute_id => $park_attribute) {
                  foreach ($park_attribute as $language_id => $text) {
                      $park_attributes[$attribute_id][$language_id]->park_id = $model->park_id;
                      $park_attributes[$attribute_id][$language_id]->attribute_id = $attribute_id;
                      $park_attributes[$attribute_id][$language_id]->text = $text;
                      $park_attributes[$attribute_id][$language_id]->language_id = $model->language_id;
                      $park_attribute->insert(false);
                  }
              }

              Yii::$app->session->setFlash('success', 'You have modified park!');
          }

          return $this->redirect('index');
      } else {
          return $this->render('create', [
              'zones' => $zones,
              'park_types' => $park_types,
              'manufacturers' => $manufacturers,
              'industry_types' => $industry_types,
              'model' => $model,
              'attributes' => $attributes,
              'park_description' => $park_description,
              'park_attributes' => $park_attributes,
              'park_to_industry_type' => $park_to_industry_type,
              'languages' => $languages,
          ]);
      }
    }

    /**
     * Updates an existing Park model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->park_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Park model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Park model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Park the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Park::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
