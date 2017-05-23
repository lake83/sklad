<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Catalog;
use dosamigos\multiselect\MultiSelect;

/* @var $this yii\web\View */
/* @var $data app\models\Products */
/* @var $form yii\bootstrap\ActiveForm */

$form = ActiveForm::begin(['layout' => 'horizontal', 'action' => ['products/related', 'id' => Yii::$app->request->get('id')]]); ?>

<div class="form-group">
    <label class="control-label col-sm-3" for="catalog-related">Категория</label>
    <div class="col-sm-6">
        <?= Html::dropDownList('catalog_id', null, Catalog::getAll(), ['class' => 'form-control', 'id' => 'catalog-related', 'prompt' => '- выбрать -']) ?>
    </div>
</div>

<div class="form-group" id="products_related">
    <span id="products-related-inner">
    <label<?= (!isset($data) || empty($data)) ? ' style="display: none;"' : '' ?> class="control-label col-sm-3" for="products-related">Товары</label>
    <div class="col-sm-6">
<?php if (isset($data) && !empty($data)): ?>
    <?= MultiSelect::widget([
        'id' => 'products-select',
        'data' => $data,
        'name' => 'products-related',
        'options' => ['multiple' => 'multiple'],
        'clientOptions' => [
            'includeSelectAllOption' => false,
            'numberDisplayed' => 3
        ]
    ]) ?>
<?php elseif (isset($data) && empty($data)): ?>
<div class="col-sm-offset-4">Нет доступных товаров.</div>
<?php endif; ?>
    </div>
    </span>
</div>

<div class="box-footer">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>