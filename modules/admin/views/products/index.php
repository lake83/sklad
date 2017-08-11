<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;
use app\models\Products;
use app\models\Manufacturers;
use app\models\Catalog;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';

$listOptions = ['class' => 'form-control', 'prompt' => '- выбрать -'];
?>

<p><?= Html::a('Создать товар', ['create'] + (($catalog_id = Yii::$app->request->get('catalog_id')) ? ['create', 'catalog_id' => $catalog_id] : []), ['class' => 'btn btn-success']) ?></p>

<?=  GridView::widget([
    'dataProvider' => $dataProvider,
    'panel' => [
        'type' => GridView::TYPE_ACTIVE,
        'after' => false
    ],
    'resizableColumns' => true,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'format' => 'raw',
                'filter' => false,
                'value' => function ($model, $index, $widget) {
                    return Html::img(SiteHelper::resized_image($model->image[0], 120, 100), ['width' => 70]);
                }
            ],
            'name',
            [
                'attribute' => 'catalog_id',
                'filter' => Html::activeDropDownList($searchModel, 'catalog_id', Catalog::getAll(), $listOptions),
                'value' => function ($model, $index, $widget) {
                    return str_replace('-', '', Catalog::getAll()[$model->catalog_id]);}
            ],
            'price',
            [
                'attribute' => 'currency',
                'filter' => Html::activeDropDownList($searchModel, 'currency', Products::getСurrency(), $listOptions),
                'value' => function ($model, $index, $widget) {
                    return $model->getСurrency($model->currency);}
            ],
            [
                'attribute' => 'manufacturer_id',
                'filter' => Html::activeDropDownList($searchModel, 'manufacturer_id', Manufacturers::getAll(), $listOptions),
                'value' => function ($model, $index, $widget) {
                    return Manufacturers::getAll()[$model->manufacturer_id];}
            ],
            'position',
            SiteHelper::is_active($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{clone}{update}{delete}',
                'buttons' => [
                    'clone' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-duplicate"></span>', ['/admin/products/clone', 'id' => $model->id] + (($catalog_id = Yii::$app->request->get('catalog_id')) ? ['catalog_id' => $catalog_id] : []), [
                            'title' => 'Клонировать',
                            'data-pjax' => 0
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/products/update', 'id' => $model->id], [
                            'title' => 'Редактировать',
                            'data-pjax' => 0
                        ]);
                    },
                    'delete' => function ($url, $model) {     
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/admin/products/delete', 'id' => $model->id] + (($catalog_id = Yii::$app->request->get('catalog_id')) ? ['catalog_id' => $catalog_id] : []), [
                            'title' => 'Удалить',
                            'data-method' => 'POST',
                            'data-confirm' => 'Вы уверены, что хотите удалить товар "' . $model->name . '"?'
                        ]);
                    }
                ],
                'options' => ['width' => '70px']
            ]
        ]
    ]);
?>