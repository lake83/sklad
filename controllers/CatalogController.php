<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Catalog;
use app\models\Products;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class CatalogController extends Controller
{
    /**
     * Вывод страниц каталога.
     *
     * @param string $alias алиас страницы
     * @return string
     * @throws NotFoundHttpException если модель не найдена
     */
    public function actionPage($alias)
    {
        if ((!$model = Catalog::find()->where(['slug' => $alias, 'is_active' => 1])->localized()->one()) || $model->not_show_region == 1) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        if (strpos(trim(Yii::$app->request->pathInfo, '/'), '/') === false) {
            $this->view->params['breadcrumbs'][] = $model->name;
        } else {
            Catalog::getBreadcrumbs($model);
        }
        $children = $model->children(1)->andWhere(['is_active' => 1])->localized()->asArray()->all();
        
        $childrens = $model->children()->andWhere(['is_active' => 1])->column();
        
        $dataProvider = new ActiveDataProvider([
            'query' => Products::find()->where(['catalog_id' => $model->id, 'is_active' => 1])->orWhere(['catalog_id' => $childrens])->localized(),
            'pagination' => [
                'defaultPageSize' => 12
            ]
        ]);
        return $this->render('page', ['model' => $model, 'children' => $children, 'dataProvider' => $dataProvider]);
    }
    
    /**
     * Вывод страницы товара.
     *
     * @param string $alias алиас страницы
     * @return string
     * @throws NotFoundHttpException если модель не найдена
     */
    public function actionProduct($alias)
    {
        if ((!$model = Products::find()->where(['slug' => $alias, 'is_active' => 1])->localized()->one()) || $model->not_show_region == 1) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        Catalog::getBreadcrumbs($model->catalog);
        
        if ($options = $model->options) {
            $short = [];
            foreach ($options as $option) {
                if ($option['show_short']) {
                    $short[] = $option;
                }
            }
            if ($short) {
                $shortData = new ArrayDataProvider([
                    'allModels' => $short,
                    'pagination' => false
                ]);
            }
            $optionsData = new ArrayDataProvider([
                'allModels' => $options,
                'pagination' => false
            ]);
        }
        if ($related = $model->productsRelated) {
            $relatedData = new ArrayDataProvider([
                'allModels' => $related,
                'pagination' => false
            ]);
        }
        if ($video = $model->productsVideo) {
            $videoData = new ArrayDataProvider([
                'allModels' => $video,
                'pagination' => false
            ]);
        }
        if ($brochures = $model->productsBrochures) {
            $brochuresData = new ArrayDataProvider([
                'allModels' => $brochures,
                'pagination' => false
            ]);
        }
        return $this->render('product', [
            'model' => $model,
            'shortData' => $shortData,
            'optionsData' => $optionsData,
            'relatedData' => $relatedData,
            'videoData' => $videoData,
            'brochuresData' => $brochuresData
        ]);
    }
}
?>