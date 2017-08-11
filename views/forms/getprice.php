<?
/* @var $model \app\models\PriceGetForm */
/* @var $this \yii\web\View*/

use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use app\models\Catalog;
use yii\helpers\Html;

Modal::begin([
    'header' => ($model->type == 'clarifyprice' ? 'УТОЧНИТЬ СТОИМОСТЬ' : 'ЗАПРОСИТЬ ПРАЙС-ЛИСТ'),
    'id' => 'get-pricelist-modal',
]);

$form = ActiveForm::begin([
        'id' => 'get-pricelist',
        'action' => ['form/getprice'],
        'options' => ['data-ga' => ($model->type == 'clarifyprice' ? 'ask_price' : 'price_list')]
    ]); ?>

        <?= $form->field($model, 'fio', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\"><span class='glyphicon glyphicon-user'></span></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'ФИО']) ?>
        
        <?= $form->field($model, 'phone', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\"><span class='glyphicon glyphicon-phone'></span></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Телефон']) ?>

        <?= $form->field($model, 'email', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\"><span class='glyphicon glyphicon-envelope'></span></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Email']) ?>

        <?= $form->field($model, 'city', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\"><span class='glyphicon glyphicon-home'></span></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Город']) ?>


        <?= $form->field($model, 'catalog_id')->label(false)->hiddenInput() ?>
        
        <?= $form->field($model, 'product_id')->label(false)->hiddenInput() ?>
        
        <?= $form->field($model, 'type')->label(false)->hiddenInput() ?>

        <?= $form->field($model, 'organization', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\"><span class='glyphicon glyphicon-briefcase'></span></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Название организации']) ?>

        <?= $form->field($model, 'how_did_you_know', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\"><span class='glyphicon glyphicon-hand-right'></span></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Откуда вы узнали про нас']) ?>

        <?= $form->field($model, 'comment')->textarea(['placeholder' => 'Комментарий*'])->label(false) ?>
        
        <p style="text-align: center;">Нажимая на кнопку «Напишите нам», вы принимаете условия <br /> <?=Html::a('Политики конфиденциальности', ['materials/page', 'alias' => 'politika'], ['target' => '_blank'])?></p> 

        <?= Html::submitButton('Напишите нам', ['class' => 'btn btn-success btn-block']) ?>
        <br />
    <?php ActiveForm::end();

Modal::end(); ?>