<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
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
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

/**
 * ParkController implements the CRUD actions for Park model.
 */
class ParkController extends BaseController
{
    /**
     * Lists all Park models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $manufacturers = ArrayHelper::map(Manufacturer::find()->joinWith('manufacturerDescription')->all(), 'manufacturer_id', 'manufacturerDescription.name');
        $park_types = ArrayHelper::map(ParkType::find(['status' => ParkType::STATUS_ACTIVE])->joinWith('parkTypeDescription')->all(), 'park_type_id', 'parkTypeDescription.name');
        $searchModel = new ParkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'manufacturers' => $manufacturers,
            'park_types' => $park_types,
        ]);
    }

    /**
     * Creates a new Park model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $zones = ArrayHelper::map(Zone::find(['status' => Zone::STATUS_ACTIVE])->joinWith('zoneDescription')->all(), 'zone_id', 'zoneDescription.name');
        $park_types = ArrayHelper::map(ParkType::find(['status' => ParkType::STATUS_ACTIVE])->joinWith('parkTypeDescription')->all(), 'park_type_id', 'parkTypeDescription.name');
        $manufacturers = ArrayHelper::map(Manufacturer::find()->joinWith('manufacturerDescription')->all(), 'manufacturer_id', 'manufacturerDescription.name');
        $industry_types = ArrayHelper::map(IndustryType::find(['status' => IndustryType::STATUS_ACTIVE])->joinWith('industryTypeDescription')->all(), 'industry_type_id', 'industryTypeDescription.name');
        $attributes = Attribute::find(['status' => Attribute::STATUS_ACTIVE, 'type' => 1])->indexBy('attribute_id')->joinWith('attributeDescription')->all();
        $languages = Yii::$app->languageManager->getLanguages();

        $model = new Park();
        $park_to_industry_type = new ParkToIndustryType();
        $park_description = [];
        $park_attributes = [];

        foreach ($attributes as $attribute_id => $attribute) {
            foreach ($languages as $language) {
                $park_attribute = new ParkAttribute();
                $park_attribute->text = $attribute->attributeDescription->value;
                $park_attributes[$attribute_id][$language->language_id] = $park_attribute;
            }
        }

        foreach ($languages as $key => $language) {
            $park_description[$language->language_id] = new ParkDescription();
        }

        $post = Yii::$app->request->post();
        if ($model->load($post) && $park_to_industry_type->load($post) && Model::loadMultiple($park_description, $post)) {
            $isValid = $model->validate();
            $isValid = $park_to_industry_type->validate();
            $isValid = Model::validateMultiple($park_description) && $isValid;
            $isValid = $this->validateAttributes($model, $park_attributes, $post) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $park_description, $post);
                $this->updateIndustryType($model, $park_to_industry_type, $post);
                $this->updateAttributes($model, $park_attributes, $post);
                Yii::$app->session->setFlash('success', 'You have modified park!');

                return $this->redirect('index');
            }
        }

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

    /**
     * Updates an existing Park model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $zones = ArrayHelper::map(Zone::find(['status' => Zone::STATUS_ACTIVE])->joinWith('zoneDescription')->all(), 'zone_id', 'zoneDescription.name');
        $park_types = ArrayHelper::map(ParkType::find(['status' => ParkType::STATUS_ACTIVE])->joinWith('parkTypeDescription')->all(), 'park_type_id', 'parkTypeDescription.name');
        $manufacturers = ArrayHelper::map(Manufacturer::find()->joinWith('manufacturerDescription')->all(), 'manufacturer_id', 'manufacturerDescription.name');
        $industry_types = ArrayHelper::map(IndustryType::find(['status' => IndustryType::STATUS_ACTIVE])->joinWith('industryTypeDescription')->all(), 'industry_type_id', 'industryTypeDescription.name');
        $attributes = Attribute::find(['status' => Attribute::STATUS_ACTIVE, 'type' => 1])->indexBy('attribute_id')->joinWith('attributeDescription')->all();
        $languages = Yii::$app->languageManager->getLanguages();

        $model = $this->findModel($id);
        $park_to_industry_type = new ParkToIndustryType();
        $park_to_industry_type->industry_type_id = ArrayHelper::getColumn(ParkToIndustryType::find(['park_id' => $id])->all(), 'industry_type_id');
        $park_description = [];
        $park_attributes = [];

        $park_attribute_data = ArrayHelper::map(ParkAttribute::find(['park_id' => $id])->all(), 'language_id', 'text', 'attribute_id');

        foreach ($attributes as $attribute_id => $attribute) {
            foreach ($languages as $language) {
                $park_attribute = new ParkAttribute();
                $park_attribute->text = isset($park_attribute_data[$attribute_id][$language->language_id]) ? $park_attribute_data[$attribute_id][$language->language_id] : '';
                $park_attributes[$attribute_id][$language->language_id] = $park_attribute;
            }
        }

        $description = ParkDescription::find()->where(['park_id' => $id])->indexBy('language_id')->all();
        foreach ($languages as $key => $language) {
            $park_description[$language->language_id] = new ParkDescription();
            $park_description[$language->language_id]->name = isset($description[$language->language_id]->name) ? $description[$language->language_id]->name : '';
            $park_description[$language->language_id]->address = isset($description[$language->language_id]->address) ? $description[$language->language_id]->address : '';
            $park_description[$language->language_id]->video = isset($description[$language->language_id]->video) ? $description[$language->language_id]->video : '';
            $park_description[$language->language_id]->owner = isset($description[$language->language_id]->owner) ? $description[$language->language_id]->owner : '';
            $park_description[$language->language_id]->description = isset($description[$language->language_id]->description) ? $description[$language->language_id]->description : '';
        }

        $post = Yii::$app->request->post();
        if ($model->load($post) && $park_to_industry_type->load($post) && Model::loadMultiple($park_description, $post)) {
            $isValid = $model->validate();
            $isValid = $park_to_industry_type->validate();
            $isValid = Model::validateMultiple($park_description) && $isValid;
            $isValid = $this->validateAttributes($model, $park_attributes, $post) && $isValid;
            if ($isValid) {
                $model->save(false);
                $this->updateDescription($model, $park_description, $post, $id);
                $this->updateIndustryType($model, $park_to_industry_type, $post, $id);
                $this->updateAttributes($model, $park_attributes, $post, $id);
                Yii::$app->session->setFlash('success', 'You have modified park!');

                return $this->redirect('index');
            }
        }

        return $this->render('update', [
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

    /**
     * Deletes an existing Park model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete()
    {
        $request = Yii::$app->request;
        if ($request->getIsAjax()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $selection = $request->post('selection');

            foreach ($selection as $id) {
                $this->findModel($id)->delete();
                ParkDescription::deleteAll('park_id = '.(int) $id);
                ParkToIndustryType::deleteAll('park_id = '.(int) $id);
                ParkAttribute::deleteAll('park_id = '.(int) $id);
            }

            Yii::$app->session->setFlash('success', 'You have delete parks!');
        }
    }

    protected function validateAttributes($model, $park_attributes, $post)
    {
        $isValid = true;

        foreach ($park_attributes as $attribute_id => $park_attribute) {
            foreach ($park_attribute as $language_id => $description) {
                $description->text = ArrayHelper::getValue($post, "ParkAttribute.{$attribute_id}.{$language_id}.text", '');
                $isValid = $description->validate() && $isValid;
            }
        }

        return $isValid;
    }

    protected function updateDescription($model, $description, $post, $id = null)
    {
        $languages = Yii::$app->languageManager->getLanguages();
        if ($id) {
            ParkDescription::deleteAll(['park_id' => $id]);
        }
        foreach ($languages as $key => $language) {
            $description[$language->language_id]->park_id = $model->park_id;
            $description[$language->language_id]->name = $post['ParkDescription'][$language->language_id]['name'];
            $description[$language->language_id]->description = $post['ParkDescription'][$language->language_id]['description'];
            $description[$language->language_id]->language_id = $language->language_id;
            $description[$language->language_id]->save(false);
        }
    }

    protected function updateIndustryType($model, $park_to_industry_type, $post, $id = null)
    {
        $languages = Yii::$app->languageManager->getLanguages();
        if ($id) {
            ParkToIndustryType::deleteAll(['park_id' => $id]);
        }
        foreach ($post['ParkToIndustryType']['industry_type_id'] as $industry_type_id) {
            $park_to_industry_type->park_id = $model->park_id;
            $park_to_industry_type->industry_type_id = $industry_type_id;
            $park_to_industry_type->insert(false);
        }
    }

    protected function updateAttributes($model, $park_attributes, $post, $id = null)
    {
        $languages = Yii::$app->languageManager->getLanguages();
        if ($id) {
            ParkAttribute::deleteAll(['park_id' => $id]);
        }

        foreach ($park_attributes as $attribute_id => $park_attribute) {
            foreach ($park_attribute as $language_id => $description) {
                $description->park_id = $model->park_id;
                $description->attribute_id = $attribute_id;
                $description->language_id = $language_id;
                $description->save(false);
            }
        }
    }

    /**
     * Finds the Park model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Park the loaded model
     *
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
