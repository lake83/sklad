<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;
use app\models\Log;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логи';
?>

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

            'controller',
            [
                'attribute' => 'action',
                'filter' => Html::activeDropDownList($searchModel, 'action', Log::getActions(), ['class' => 'form-control', 'prompt' => '- выбрать -']),
                'value' => function ($model, $index, $widget) {
                    return $model->getActions($model->action);}
            ],
            [
                'attribute' => 'user_id',
                'value' => function ($model, $index, $widget) {
                    return $model->user->username;}
            ],
            'target_id',
            SiteHelper::created_at($searchModel)
        ]
    ]);

?>