<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;
use app\models\Materials;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$type = Yii::$app->request->get('type');
$this->title = Materials::getTypes($type);
?>

<p><?= Html::a('Создать ' . Materials::getTypes($type, false), ['create', 'type' => $type], ['class' => 'btn btn-success']) ?></p>

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
            SiteHelper::is_active($searchModel),
            SiteHelper::created_at($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/admin/materials/update', 'id' => $model->id, 'type' => $model->type], [
                            'title' => 'Редактировать',
                            'data-pjax' => 0
                        ]);
                    },
                    'delete' => function ($url, $model) {     
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/admin/materials/delete', 'id' => $model->id, 'type' => $model->type], [
                            'title' => 'Удалить',
                            'data-method' => 'POST',
                            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?'
                        ]);
                    }
                ],
                'options' => ['width' => '50px']
            ]
        ]
    ]);
?>