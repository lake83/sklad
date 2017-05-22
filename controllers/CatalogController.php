<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Catalog;
use app\models\Products;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

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
        
        $dataProvider = new ActiveDataProvider([
            'query' => Products::find()->where(['is_active' => 1])->localized(),
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
        
        return $this->render('product', ['model' => $model]);
    }
}
?>