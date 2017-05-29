<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RegionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Регионы';
?>

<p><?= Html::a('Создать регион', ['create'], ['class' => 'btn btn-success']) ?></p>

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
            'subdomain',
            SiteHelper::is_active($searchModel),
            'phone',
            'email:email',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'options' => ['width' => '50px']
            ]
        ]
    ]);

?>