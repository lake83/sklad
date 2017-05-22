<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Products;
use yii\web\NotFoundHttpException;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends AdminController
{
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
        return $this->render('_form', ['model' => $model]);
    }
}