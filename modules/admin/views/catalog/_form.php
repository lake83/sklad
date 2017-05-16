<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\components\RedactorTinymce;
use app\models\Regions;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Catalog */
/* @var $form yii\bootstrap\ActiveForm */

$request = Yii::$app->request;

if (!$model->isNewRecord || $this->context->action->id == 'localization') {
    $id = $request->get('parent_id') ? $request->get('parent_id') : $request->get('id');
    foreach(Regions::getRegions() as $key => $region) {
        if ($key == '') {
            $items[] = ['label' => $region['name'], 'url' => Url::to(['/admin/catalog/update', 'id' => $id])];
        } else {
            $items[] = [
                'label' => $region['name'],
                'url' => Url::to(['/admin/catalog/localization', 'parent_id' => $id, 'region' => $key]),
                'active' => $key == $request->get('region')
            ];
        }
    }
    echo Tabs::widget(['items' => $items]) . '<br />';
}
$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php if ($this->context->action->id !== 'localization') {
        echo $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Генерируется из названия.');
    } else {
        echo Html::activeHiddenInput($model, 'slug');
    }  ?>
    
    <?= $form->field($model, 'image')->widget(\app\components\FilemanagerInput::className()) ?>
    
    <?= $form->field($model, 'intro_text')->widget(RedactorTinymce::className()) ?>
    
    <?= $form->field($model, 'full_text')->widget(RedactorTinymce::className()) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    
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