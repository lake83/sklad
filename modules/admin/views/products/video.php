<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsGallery */
/* @var $form yii\bootstrap\ActiveForm */

$labelOptions = ['labelOptions' => ['style' => 'margin-right:30px']];

$form = ActiveForm::begin(['id' => 'dynamic-form', 'action' => ['products/video', 'id' => Yii::$app->request->get('id')], 'layout' => 'horizontal']); ?>
    
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
             
    <?php DynamicFormWidget::begin([
          'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
          'widgetBody' => '.container-items', // required: css class selector
          'widgetItem' => '.item', // required: css class
          'insertButton' => '.add-item', // css class
          'deleteButton' => '.remove-item', // css class
          'model' => $models[0],
          'formId' => 'dynamic-form',
          'formFields' => [
              'name',
              'link',
              'is_active'
          ]
    ]);
    
    echo Html::activeHiddenInput($model, 'name'); ?>

        <div class="container-items">
            <button type="button" class="add-item btn btn-default" style="margin: 0 0 30px -15px;"><i class="glyphicon glyphicon-plus"></i> Добавить</button>
            <div class="clearfix"></div>
            
            <?php foreach ($models as $i => $one): ?>
            <div class="item">
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
                        <button type="button" class="remove-item btn btn-danger" title="Удалить"><i class="glyphicon glyphicon-minus"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"><b><?= $models[0]->getAttributeLabel('link') ?></b></div>
                    <div class="col-sm-8">
                        <?= $form->field($one, "[{$i}]link", ['template' => "{input}\n{error}"])->textInput(['maxlength' => true]) ?>
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