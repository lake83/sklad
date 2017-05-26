<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Products;
use app\models\CatalogOptions;
use app\models\ProductsOptions;
use app\models\ProductsRelated;
use app\models\ProductsBrochures;
use yii\web\NotFoundHttpException;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends AdminController
{
    use actions\MultipleTraite;
    
    public function actions()
    {
        $category = ($catalog_id = Yii::$app->request->get('catalog_id')) ? ['catalog_id' => $catalog_id] : [];
        return [
            'index' => [
                'class' => $this->actionsPath.'Index',
                'search' => $this->modelPath.'ProductsSearch'
            ],
            'create' => [
                'class' => $this->actionsPath.'Create',
                'model' => $this->modelPath.'Products',
                'redirect' => ['/admin/products/index'] + $category,
                'scenario' => 'main'
            ],
            'update' => [
                'class' => $this->actionsPath.'Update',
                'model' => $this->modelPath.'Products',
                'redirect' => Yii::$app->request->referrer,
                'scenario' => 'main'
            ],
            'delete' => [
                'class' => $this->actionsPath.'Delete',
                'model' => $this->modelPath.'Products',
                'redirect' => ['/admin/products/index'] + $category
            ],
            'toggle' => [
                'class' => \pheme\grid\actions\ToggleAction::className(),
                'modelClass' => $this->modelPath.'Products',
                'attribute' => 'is_active'
            ],
            'video' => [
                'class' => $this->actionsPath.'UpdateMultiple',
                'model' => $this->modelPath.'Products',
                'models' => $this->modelPath.'ProductsVideo',
                'owner' => 'product_id',
                'view' => 'video',
                'redirect' => Yii::$app->request->referrer,
                'partial' => true
            ]
        ];
    }
    
    /**
     * Создание и редактирование локальных версий для регионов
     * 
     * @param integer $parent_id ID родительской модели
     * @param string $region субдомен региона
     * @return string
     */
    public function actionLocalization($parent_id, $region)
    {
        if (!$model = Products::findOne(['parent_id' => $parent_id, 'region' => $region])) {
            $model = new Products;
            $parent = Products::find()->select('slug,catalog_id,manufacturer_id,price')->where(['id' => $parent_id])->asArray()->one();
            $model->slug = $parent['slug'];
            $model->catalog_id = $parent['catalog_id'];
            $model->manufacturer_id = $parent['manufacturer_id'];
            $model->price = $parent['price'];
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
            return $this->refresh();
        }
        return $this->render('_form', ['model' => $model]);
    }
    
    /**
     * Создание клона товара
     * 
     * @param integer $id ID клонируемого товара
     * @return string
     */
    public function actionClone($id)
    {
        if ($parent = Products::findOne($id)) {
            $model = new Products;
            $parent->slug = '';
            $model->attributes = $parent->attributes;
            $model->scenario = 'clone';
        } else {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
            return $this->redirect(['index'] + (($catalog_id = Yii::$app->request->get('catalog_id')) ? ['catalog_id' => $catalog_id] : []));
        }
        return $this->render('_main', ['model' => $model]);
    }
    
    /**
     * Опции спецификации товара
     * 
     * @param integer $id ID товара
     * @return string
     */
    public function actionOptions($id)
    {
        if ($product = Products::findOne($id)) {
            $parents = $product->catalog->parents()->andWhere(['is_active' => 1])->column();
            $options = ArrayHelper::map(CatalogOptions::find()->select('id,name')->where(['catalog_id' => $product->catalog_id, 'is_active' => 1])->orWhere(['catalog_id' => $parents])->orderBy('position ASC')->asArray()->all(), 'id', 'name');
            $values = ArrayHelper::map(ProductsOptions::find()->select('option_id,value')->where(['product_id' => $id])->asArray()->all(), 'option_id', 'value');
            
            foreach ($options as $key => $option) {
                $fields['field' . $key] = isset($values[$key]) ? $values[$key] : '';
            }
            $model = new DynamicModel($fields);
            $model->addRule(array_keys($fields), 'string', ['max' => 255, 'message' => 'Значение должно содержать максимум 255 символов.']);
        } else {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        if ($model->load(Yii::$app->request->post())) {
            foreach ($model->attributes as $key => $attribute) {
                $option_id = str_replace('field', '', $key);
                if ($opt = ProductsOptions::findOne(['option_id' => $option_id, 'product_id' => $id])) {
                    if (!empty($attribute)) {
                        $opt->value = $attribute;
                        $opt->save();
                    } else {
                        $opt->delete();
                    }
                } else {
                    $opt = new ProductsOptions;
                    $opt->option_id = $option_id;
                    $opt->product_id = $id;
                    $opt->value = $attribute;
                    $opt->save();
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderPartial('_options', ['model' => $model, 'options' => $options]);
    }
    
    /**
     * Связанные товары
     * 
     * @param integer $id ID товара
     * @return string
     */
    public function actionRelated($id)
    {
        if (Yii::$app->request->isAjax && isset($_POST['catalog_id'])) {
            if ($products = Products::find()->select('id,name')->where(['catalog_id' => $_POST['catalog_id'], 'is_active' => 1])->andWhere('id!='.$id)->asArray()->all()) {
                foreach ($products as $product) {
                    $data[] = ['label' => $product['name'], 'title' => $product['name'], 'value' => $product['id']];
                }
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $data;
            } else {
                return 'Нет доступных товаров.';
            }
        }
        if (Yii::$app->request->isPost) {
            if (isset($_POST['products-related'])) {
                foreach ($_POST['products-related'] as $product) {
                    if (!ProductsRelated::find()->where(['product_id' => $id, 'related_id' => $product])->exists()) {
                        $model = new ProductsRelated;
                        $model->product_id = $id;
                        $model->related_id = $product;
                        $model->save();
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => ProductsRelated::find()->where(['product_id' => $id]),
            'pagination' => [
                'defaultPageSize' => 10
            ]
        ]);
        return $this->renderPartial('_related', ['dataProvider' => $dataProvider]);
    }
    
    /**
     * Удаление связанного товара
     * 
     * @param integer $id ID товара
     * @return string
     */
    public function actionDeleteRelated($id)
    {
        if (ProductsRelated::findOne($id)->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
    
    /**
     * Брошюры
     * 
     * @param integer $id ID товара
     * @return string
     */
    public function actionBrochures($id)
    {
        if (!$model = Products::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена.'));
        }
        $models = ProductsBrochures::find()->where(['product_id' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($brochures = $this->multipleUpdate($model, ProductsBrochures::className(), $models, 'product_id')) {
                $path = Yii::getAlias('@webroot/files/');
                if (!file_exists($path)) {
                    mkdir($path);
                }
                foreach ($brochures as $key => $one) {
                    if ($name = $_FILES['ProductsBrochures']['name'][$key]['file']) {
                        $temp = $_FILES['ProductsBrochures']['tmp_name'][$key]['file'];
                        if (move_uploaded_file($temp, $path . $name)) {
                            if ($one->file !== $name && is_file($path . $one->file)) {
                                unlink($path . $one->file);
                            }
                            $one->file = $name;
                            $one->save();     
                        }
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->renderPartial('brochures', [
            'model' => $model,
            'models' => (empty($models)) ? [new ProductsBrochures] : $models
        ]);
    }
}