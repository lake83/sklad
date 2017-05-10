<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Materials;
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
        return $this->render('page', ['model' => $model]);
    }
}
?>