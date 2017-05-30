<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\FileHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsGallery */
/* @var $form yii\bootstrap\ActiveForm */

$files = [];
if ($dir = FileHelper::findFiles(Yii::getAlias('@webroot/images/uploads/source/files'))) {
    foreach (array_map(function($path){return basename($path);}, $dir, ['recursive' => false]) as $file) {
        $files[$file] = $file;
    }
}
$labelOptions = ['labelOptions' => ['style' => 'margin-right:30px']];

$form = ActiveForm::begin(['id' => 'dynamic-form-brochures', 'action' => ['products/brochures', 'id' => Yii::$app->request->get('id')], 'options' => ['enctype' => 'multipart/form-data'], 'layout' => 'horizontal']); ?>
    
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
             
    <?php DynamicFormWidget::begin([
          'widgetContainer' => 'dynamicform_wrapper_brochures', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
          'widgetBody' => '.container-items-brochures', // required: css class selector
          'widgetItem' => '.item-brochures', // required: css class
          'insertButton' => '.add-item-brochures', // css class
          'deleteButton' => '.remove-item-brochures', // css class
          'model' => $models[0],
          'formId' => 'dynamic-form-brochures',
          'formFields' => [
              'name',
              'file',
              'is_active'
          ]
    ]);
    
    echo Html::activeHiddenInput($model, 'name'); ?>

        <div class="container-items-brochures">
            <button type="button" class="add-item-brochures btn btn-default" style="margin: 0 0 30px -15px;"><i class="glyphicon glyphicon-plus"></i> Добавить</button>
            <div class="clearfix"></div>
            
            <?php foreach ($models as $i => $one): ?>
            <div class="item-brochures">
            <?php
                // necessary for update action.
                if (!$one->isNewRecord) {
                    echo Html::activeHiddenInput($one, "[{$i}]id");
                }
            ?>
                <div class="row">
                    <div class="col-sm-2"><b><?= $models[0]->getAttributeLabel('name') ?></b></div>
                    <div class="col-sm-8">
                        <?= $form->field($one, "[{$i}]name", ['template' => "{input}\n{error}"])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="remove-item-brochures btn btn-danger" title="Удалить"><i class="glyphicon glyphicon-minus"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"><b><?= $models[0]->getAttributeLabel('file') ?></b></div>
                    <div class="col-sm-8">
                        <?= $form->field($one, "[{$i}]file", ['template' => "{input}\n{error}"])->dropDownList($files, ['prompt' => '- выбрать -']) ?>
                    </div>
                    <div class="col-sm-2">
                        <?= $form->field($one, "[{$i}]is_active")->checkbox() ?>
                    </div>
                </div>
                <hr />
            </div>
            <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>