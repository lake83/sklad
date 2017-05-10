<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Materials;
use app\models\ManufacturersSearch;
use yii\web\NotFoundHttpException;

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
                if ($page = Materials::findOne(['slug' => $path, 'is_active' => 1])) {
                    $view->params['breadcrumbs'][] = ['label' => $page->name, 'url' => ['materials/page', 'alias' => $path]];
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
}
?>