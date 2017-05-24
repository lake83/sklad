<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Regions;
use yii\bootstrap\Tabs;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$request = Yii::$app->request;
$catalog_id = $request->get('catalog_id');
$controller = $this->context;

if (!$model->isNewRecord || $controller->action->id == 'localization') {
    $id = $request->get('parent_id') ? $request->get('parent_id') : $request->get('id');
    foreach(Regions::getRegions() as $key => $region) {
        if ($key == '') {
            $items[] = ['label' => $region['name'], 'url' => Url::to(['/admin/products/update', 'id' => $id] + ($catalog_id ? ['catalog_id' => $catalog_id] : []))];
        } else {
            $items[] = [
                'label' => $region['name'],
                'url' => Url::to(['/admin/products/localization', 'parent_id' => $id, 'region' => $key] + ($catalog_id ? ['catalog_id' => $catalog_id] : [])),
                'active' => $key == $request->get('region')
            ];
        }
    }
    echo Tabs::widget(['items' => $items]) . '<br />';
}

if ($controller->action->id !== 'localization') {
    echo Collapse::widget([
        'items' => [
            [
                'label' => 'Описание товара',
                'content' => $controller->renderPartial('_main', ['model'=>$model]),
                'contentOptions' => ['class' => 'in']
            ],
            [
                'label' => 'Спецификация',
                'content' => Yii::$app->runAction('/admin/products/options', ['id' => $model->id])
            ],
            [
                'label' => 'Связанные товары',
                'content' => Yii::$app->runAction('/admin/products/related', ['id' => $model->id])
            ],
            [
                'label' => 'Видео',
                'content' => Yii::$app->runAction('/admin/products/video', ['id' => $model->id])
            ],
            [
                'label' => 'Брошюра',
                'content' => Yii::$app->runAction('/admin/products/brochures', ['id' => $model->id])
            ]
        ]
    ]);
} else {
    echo $controller->renderPartial('_main', ['model'=>$model]);
} ?>