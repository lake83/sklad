<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Materials;
use app\models\Manufacturers;
use app\models\ManufacturersSearch;
use app\models\MaterialsSearch;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;

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
        if (!$model = Materials::findOne(['slug' => $alias, 'is_active' => 1])) {
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
            $view->params['breadcrumbs'][] = $model->name;
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
        return $this->render('postavchshiki-view', ['model' => $model]);
    }
    
    /**
     * Вывод страницы Новости.
     *
     * @param string $type тип материалов
     * @return string
     */
    public function actionNews($type = 1)
    {
        $searchModel = new MaterialsSearch;
        $searchModel->is_active = 1;
        $searchModel->type = $type;       
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
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
        if (!$model = Materials::findOne(['slug' => $alias, 'is_active' => 1])) {
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