<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\Regions;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Banners */
/* @var $form yii\bootstrap\ActiveForm */

$request = Yii::$app->request;

if (!$model->isNewRecord || $this->context->action->id == 'localization') {
    $id = $request->get('parent_id') ? $request->get('parent_id') : $request->get('id');
    foreach(Regions::getRegions() as $key => $region) {
        if ($key == '') {
            $items[] = ['label' => $region['name'], 'url' => Url::to(['/admin/banners/update', 'id' => $id])];
        } else {
            $items[] = [
                'label' => $region['name'],
                'url' => Url::to(['/admin/banners/localization', 'parent_id' => $id, 'region' => $key]),
                'active' => $key == $request->get('region')
            ];
        }
    }
    echo Tabs::widget(['items' => $items]) . '<br />';
}
$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'image')->widget(\app\components\FilemanagerInput::className()) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?php if ($this->context->action->id !== 'localization') {
        echo $form->field($model, 'position')->dropDownList($model->getPositions(), ['class' => 'form-control', 'prompt' => '- выбрать -']);
    } else {
        echo Html::activeHiddenInput($model, 'position');
    }  ?>

    <?=  Html::activeHiddenInput($model, 'parent_id', ['value' => $request->get('parent_id') ? $request->get('parent_id') : 0]) ?>
    
    <?=  Html::activeHiddenInput($model, 'region', ['value' => $request->get('region') ? $request->get('region') : '']) ?>

    <?= $form->field($model, 'not_show_region')->checkbox() ?>
    
    <?php if ($this->context->action->id !== 'localization') {
        echo $form->field($model, 'is_active')->checkbox();
    } ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>