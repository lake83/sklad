<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;
use app\models\Menu;
use app\models\MenuItems;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пункты меню';

$listOptions = ['class' => 'form-control', 'prompt' => '- выбрать -'];
?>

<p><?= Html::a('Создать пункт меню', ['create'], ['class' => 'btn btn-success']) ?></p>

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

            'name',
            [
                'attribute' => 'type',
                'filter' => Html::activeDropDownList($searchModel, 'type', MenuItems::getTypes(), $listOptions),
                'value' => function ($model, $index, $widget) {
                    return $model->getTypes($model->type);}
            ],
            [
                'attribute' => 'menu_id',
                'filter' => Html::activeDropDownList($searchModel, 'menu_id', Menu::getAll(), $listOptions),
                'value' => function ($model, $index, $widget) {
                    return $model->menu->name;}
            ],
            [
                'attribute' => 'parent_id',
                'filter' => Html::activeDropDownList($searchModel, 'parent_id', MenuItems::getAll(), $listOptions),
                'value' => function ($model, $index, $widget) {
                    return $model->parent_id === 0 ? '---' : $model->getAll()[$model->parent_id];}
            ],
            'position',
            SiteHelper::is_active($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'options' => ['width' => '50px']
            ]
        ]
    ]);

?>