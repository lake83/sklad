<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;
use app\models\Banners;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BannersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Баннеры';
?>

<p><?= Html::a('Создать баннер', ['create'], ['class' => 'btn btn-success']) ?></p>

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
            'link',
            [
                'attribute' => 'position',
                'filter' => Html::activeDropDownList($searchModel, 'position', Banners::getPositions(), ['class' => 'form-control', 'prompt' => '- выбрать -']),
                'value' => function ($model, $index, $widget) {
                    return $model->getPositions($model->position);}
            ],
            SiteHelper::is_active($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'options' => ['width' => '50px']
            ]
        ]
    ]);
?>