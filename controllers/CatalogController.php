<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Catalog;
use yii\web\NotFoundHttpException;

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
        $view = $this->view;
        if (strpos(trim(Yii::$app->request->pathInfo, '/'), '/') === false) {
            $view->params['breadcrumbs'][] = $model->name;
        } else {
            if (!$parents = $model->parents()->localized()->asArray()->all()) {
                $p = Catalog::find()->select('name,slug')->where(['depth' => 0])->localized()->asArray()->one();
                $view->params['breadcrumbs'][] = ['label' => $p['name'], 'url' => ['catalog/page', 'alias' => $p['slug']]];
            } else {
                $slug = '';
                foreach ($parents as $parent) {
                    if ($parent['not_show_region'] == 0) {
                        $slug.= $parent['slug'] . '/';
                        $view->params['breadcrumbs'][] = ['label' => $parent['name'], 'url' => ['catalog/page', 'alias' => trim($slug, '/')]];
                    }
                }
            }
        }
        $children = $model->children(1)->andWhere(['is_active' => 1])->localized()->asArray()->all();
        
        return $this->render('page', ['model' => $model, 'children' => $children]);
    }
}
?>