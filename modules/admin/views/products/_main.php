<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\RedactorTinymce;
use app\models\Catalog;
use app\models\Manufacturers;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\bootstrap\ActiveForm */

$request = Yii::$app->request;
$catalog_id = $request->get('catalog_id');
$controller = $this->context;
$listOptions = ['prompt' => '- выбрать -'];

$form = ActiveForm::begin(['layout' => 'horizontal']);
?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?php if ($controller->action->id !== 'localization') {
    echo $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Генерируется из названия.');
} else {
    echo Html::activeHiddenInput($model, 'slug');
} ?>
    
<?= $form->field($model, 'image')->widget(\app\components\FilemanagerInput::className()) ?>
    
<?php if (!$catalog_id || $controller->action->id == 'update') {
    echo $form->field($model, 'catalog_id')->dropDownList(Catalog::getAll(), $listOptions);
} else {
    echo Html::activeHiddenInput($model, 'catalog_id', ['value' => $catalog_id]);
}  ?>

<?= Html::activeHiddenInput($model, 'parent_id', ['value' => $request->get('parent_id') ? $request->get('parent_id') : 0]) ?>
    
<?= Html::activeHiddenInput($model, 'region', ['value' => $request->get('region') ? $request->get('region') : '']) ?>

<?= $form->field($model, 'price')->textInput() ?>

<?= $form->field($model, 'currency')->dropDownList($model->getСurrency(), $listOptions) ?>

<?= $form->field($model, 'not_show_price')->checkbox() ?>

<?= $form->field($model, 'manufacturer_id')->dropDownList(Manufacturers::getAll(), $listOptions) ?>

<?= $form->field($model, 'full_text')->widget(RedactorTinymce::className()) ?>

<?= $form->field($model, 'position')->textInput() ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'not_show_region', ['enableAjaxValidation' => true])->checkbox() ?>

<?php if ($controller->action->id !== 'localization') {
    echo $form->field($model, 'is_active')->checkbox();
} ?>

<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>