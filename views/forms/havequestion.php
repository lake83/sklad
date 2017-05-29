<?
/* @var $model \app\models\PriceGetForm */
/* @var $this \yii\web\View*/

use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use app\models\Catalog;
use yii\helpers\Html;
use app\models\Regions;

$regions = Regions::getRegions();

Modal::begin([
    'header' => 'Ваш запрос обработан',
    'id' => 'have-question-modal',
]);
Modal::end();
?>

<div class="question-left">
    <h3>Консультация</h3>
    по телефону:<br />
    <?php if ($phone = $regions[Yii::$app->params['region']]['phone']): ?>
    <?=$phone?><br />
    <?php endif; ?>
    +7 (800) 555-5393<br /><br />
    или по e-mail:<br />
    <?=$regions[Yii::$app->params['region']]['email']?>
</div>
<div class="question-right">
    <?php $form = ActiveForm::begin([
            'id' => 'have-question',
            'action' => ['form/havequestion']
        ]); ?>
        
    <?= $form->field($model, 'fio', ['template'=>"{label}\n<div class=\"input-group\">\n
        <span class=\"input-group-addon\" id=\"basic-addon1\"><span class='glyphicon glyphicon-user'></span></span>
               {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'ФИО']) ?>
        
    <?= $form->field($model, 'phone', ['template'=>"{label}\n<div class=\"input-group\">\n
        <span class=\"input-group-addon\" id=\"basic-addon1\"><span class='glyphicon glyphicon-phone'></span></span>
               {input}</div>\n{hint}\n{error}"])->widget(\yii\widgets\MaskedInput::className(), ['mask' => Yii::$app->params['phone_mask']])->label(false)->textInput(['placeholder' => 'Телефон']) ?>

    <?= $form->field($model, 'email', ['template'=>"{label}\n<div class=\"input-group\">\n
        <span class=\"input-group-addon\" id=\"basic-addon1\"></span>
               {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Email']) ?>

    <?= $form->field($model, 'question')->textarea(['placeholder' => 'Ваш вопрос *'])->label(false) ?>

    <?= $form->field($model, 'catalog_id')->hiddenInput()->label(false) ?>

    <?= Html::submitButton('Отпрвить', ['class' => 'btn btn-success btn-block']) ?>
    <br />
    <?php ActiveForm::end(); ?>
</div>