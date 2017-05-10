<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Menu;
use app\models\Materials;

/* @var $this yii\web\View */
/* @var $model app\models\MenuItems */
/* @var $form yii\bootstrap\ActiveForm */

$listOptions = ['class' => 'form-control', 'prompt' => '- выбрать -'];
$flag = $model->isNewRecord || $model->type !== 1;

$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'menu_id')->dropDownList(Menu::getAll(), $listOptions) ?>
    
    <?= $form->field($model, 'parent_id')->dropDownList($model->getAll($model->menu_id), $listOptions) ?>
    
    <?= $form->field($model, 'type')->dropDownList($model->getTypes(), $listOptions) ?>

    <div id="type-input" style="<?=$flag ? '' : 'display:none'?>">
    <?= $form->field($model, 'value')->textInput(['disabled' => !$flag]) ?>
    </div>
    <div id="type-list" style="<?=$flag ? 'display:none' : ''?>">
    <?= $form->field($model, 'value')->dropDownList(Materials::getPages(), $listOptions + ['disabled' => $flag]) ?>
    </div>
    
    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>