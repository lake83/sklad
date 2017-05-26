<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Catalog;

/* @var $this yii\web\View */
/* @var $model app\models\Catalog */
/* @var $models app\models\CatalogOptions */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Опции категории каталога: ' . $model->name;

$labelOptions = ['labelOptions' => ['style' => 'margin-right:30px']];

$form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>
    
<div class="form-group">
    <label class="control-label col-sm-3">Опции</label>
    <div class="col-sm-6">
             
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
              'show_anons',
              'show_short',
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
                    <div class="col-sm-3"><b><?= $models[0]->getAttributeLabel('name') ?></b></div>
                    <div class="col-sm-7">
                        <?= $form->field($one, "[{$i}]name", ['template' => "{input}\n{error}"])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="remove-item btn btn-danger" title="Удалить"><i class="glyphicon glyphicon-minus"></i></button>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3"><?= $models[0]->getAttributeLabel('change_category') ?></label>
                    <div class="col-sm-7">
                        <?= $form->field($one, "[{$i}]change_category", ['template' => "{input}\n{error}"])->dropDownList(Catalog::getAll(), ['prompt' => '- выбрать -']) ?>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3"><?= $models[0]->getAttributeLabel('position') ?></label>
                    <div class="col-sm-7">
                        <?= $form->field($one, "[{$i}]position", ['template' => "{input}\n{error}"])->textInput() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= Html::activeCheckbox($one, "[{$i}]show_anons", $labelOptions) ?>
                        <?= Html::activeCheckbox($one, "[{$i}]show_short", $labelOptions) ?>
                        <?= Html::activeCheckbox($one, "[{$i}]is_active") ?>
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