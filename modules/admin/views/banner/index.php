<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Banner;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Акции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">
    <p>
        <?= Html::a('Создать акцию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'layout' => '{items}{pager}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'link',
            [
                'attribute' => 'position',
                'value' => function ($model) {
                    return isset(Banner::$positions[$model->position]) ? Banner::$positions[$model->position] : $model->position;
                },
                'filter' => array_merge(\yii\helpers\ArrayHelper::map(Banner::find()->all(), 'position', 'position'), Banner::$positions)
            ],
            SiteHelper::is_active($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'options' => ['width' => '50px']
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
