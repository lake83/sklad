<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Catalog;
use dosamigos\multiselect\MultiSelectAsset;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

MultiSelectAsset::register($this);

$form = ActiveForm::begin(['layout' => 'horizontal', 'action' => ['products/related', 'id' => Yii::$app->request->get('id')]]); ?>

<div class="form-group">
    <label class="control-label col-sm-3" for="catalog-related">Категория</label>
    <div class="col-sm-6">
        <?= Html::dropDownList('catalog_id', null, Catalog::getAll(), ['class' => 'form-control', 'id' => 'catalog-related', 'prompt' => '- выбрать -']) ?>
    </div>
</div>

<div class="form-group">
    <div id="products-related-inner" style="display: none;">
        <label id="products_related" class="control-label col-sm-3" for="products-related">Товары</label>
        <div class="col-sm-6">
            <select id="products-select" name="products-related[]" multiple="multiple"></select>
        </div>
    </div>
    <div id="no_products" class="col-sm-offset-3 col-sm-6"></div>
</div>

<div class="box-footer">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?=  GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'related_id',
                'value' => function ($model, $index, $widget) {
                    return $model->related->name;}
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {     
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/admin/products/delete-related', 'id' => $model->id], [
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