<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Materials;
use app\models\Products;
use app\models\Catalog;
use app\models\Manufacturers;
use app\models\ManufacturersSearch;
use app\models\MaterialsSearch;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;

class MaterialsController extends Controller
{
    /**
     * Вывод страниц из материалов с типом Страницы.
     *
     * @param string $alias алиас страницы
     * @return string
     * @throws NotFoundHttpException если модель не найдена
     */
    public function actionPage($alias)
    {
        if ((!$model = Materials::find()->where(['slug' => $alias, 'is_active' => 1])->localized()->one()) || $model->not_show_region == 1) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        $view = $this->view;
        if (strpos($alias, '/') === false) {
            $view->params['breadcrumbs'][] = $model->name;
        } else {
            $parents = explode('/', $alias);
            foreach ($parents as $parent) {
                array_pop($parents);
                $path = implode('/', $parents);
                if ($page = Materials::find()->where(['is_active' => 1])->andWhere(['or', ['like', 'slug', $path, false], ['like', 'slug', '%/'.$path, false]])->one()) {
                    $view->params['breadcrumbs'][] = ['label' => $page->name, 'url' => ['materials/page', 'alias' => $page->slug]];
                }
            }
        }
        return $this->render('page', ['model' => $model]);
    }
    
    /**
     * Вывод страницы Наши поставщики.
     *
     * @return string
     */
    public function actionPostavchshiki()
    {
        $searchModel = new ManufacturersSearch;
        $searchModel->is_active = 1;        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('postavchshiki', ['dataProvider' => $dataProvider]);
    }
    
    /**
     * Вывод страницы поставщика.
     *
     * @param string $alias алиас страницы
     * @return string
     * @throws NotFoundHttpException если модель не найдена
     */
    public function actionPostavchshikiView($alias)
    {
        if (!$model = Manufacturers::findOne(['slug' => $alias, 'is_active' => 1])) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        $products = Products::find()->select('catalog_id')->distinct()->where(['manufacturer_id' => $model->id, 'is_active' => 1])->column();
        $categories = Catalog::find()->where(['id' => $products, 'is_active' => 1])->localized()->all();
        
        return $this->render('postavchshiki-view', ['model' => $model, 'categories' => $categories]);
    }
    
    /**
     * Вывод страницы Новости.
     *
     * @param string $type тип материалов
     * @return string
     */
    public function actionNews($type = 1)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Materials::find()->where(['type' => $type, 'is_active' => 1])->orderBy('created_at DESC')->localized(),
            'pagination' => [
                'defaultPageSize' => 10
            ]
        ]);
        return $this->render('materials', ['dataProvider' => $dataProvider, 'type' => $type]);
    }
    
    /**
     * Вывод страницы Статьи.
     *
     * @return string
     */
    public function actionArticles()
    {
        return Yii::$app->runAction('materials/news', ['type' => 2]);
    }
    
    /**
     * Вывод страницы материала (статьи или новости).
     *
     * @param string $alias алиас страницы
     * @return string
     * @throws NotFoundHttpException если модель не найдена
     */
    public function actionMaterialsView($alias)
    {
        if ((!$model = Materials::find()->where(['slug' => $alias, 'is_active' => 1])->localized()->one()) || $model->not_show_region == 1) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        return $this->render('materials-view', ['model' => $model]);
    }
    
    /**
     * Вывод страницы Клиенты.
     *
     * @return string
     */
    public function actionClients()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => Materials::getClients(),
            'pagination' => false
        ]);
        return $this->render('clients', ['dataProvider' => $dataProvider]);
    }
}
?>