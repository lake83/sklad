<?
/* @var $model \app\models\RecallForm */
/* @var $this \yii\web\View*/

use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use app\models\Catalog;
use yii\helpers\Html;

Modal::begin([
    'header' => 'Заказать звонок',
    'id' => 'recall-form-modal',
]);

$form = ActiveForm::begin([
        'id' => 'recall-form',
        'action' => ['form/recall'],
        'options' => ['data-ga' => 'form_call']
    ]); ?>

        <?= $form->field($model, 'fio', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\"><span class='glyphicon glyphicon-user'></span></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'ФИО']) ?>
        
        <?= $form->field($model, 'phone', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\"><span class='glyphicon glyphicon-phone'></span></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Телефон']) ?>
        
        <?= $form->field($model, 'catalog_id')->label(false)->dropDownList(\yii\helpers\ArrayHelper::map(Catalog::find()->select('id,name,depth')->where(['is_active' => 1, 'depth' => 1])->orderBy('lft')->localized()->all(), 'id', 'name'), ['prompt' => 'Тип техники или услуги*']) ?>
        
        <p style="text-align: center;">Нажимая на кнопку «Позвоните мне», вы принимаете условия <br /> <?=Html::a('Политики конфиденциальности', ['materials/page', 'alias' => 'politika'], ['target' => '_blank'])?></p> 
        
        <?= Html::submitButton('Позвоните мне', ['class' => 'btn btn-success btn-block']) ?>
        
        <br />
    <?php ActiveForm::end();

Modal::end(); ?>