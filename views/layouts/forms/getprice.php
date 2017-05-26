<?
/* @var $model \app\models\PriceGetForm */
/* @var $this \yii\web\View*/

use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use app\models\Catalog;
use yii\helpers\Html;

Modal::begin([
    'header' => 'ЗАПРОСИТЬ ПРАЙС-ЛИСТ',
    'id' => 'get_pricelist',
]);
?>
    <?php $form = ActiveForm::begin([
        'id' => 'get_pricelist-form',
    ]); ?>

        <?= $form->field($model, 'fio', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\" id=\"basic-addon1\"><span class='glyphicon glyphicon-user'></span></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'ФИО']) ?>
        <?= $form->field($model, 'phone', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\" id=\"basic-addon1\"><span class='glyphicon glyphicon-phone'></span></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Телефон']) ?>

        <?= $form->field($model, 'email', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\" id=\"basic-addon1\"></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Email']) ?>

        <?= $form->field($model, 'city', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\" id=\"basic-addon1\"></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Город']) ?>


        <?= $form->field($model, 'catalog_id')->label(false)->hiddenInput() ?>
        <?= $form->field($model, 'product_id')->label(false)->hiddenInput() ?>
        <?= $form->field($model, 'type')->label(false)->hiddenInput() ?>

        <?= $form->field($model, 'organization', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\" id=\"basic-addon1\"></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Название организации']) ?>

        <?= $form->field($model, 'how_did_you_know', ['template'=>"{label}\n<div class=\"input-group\">\n
                <span class=\"input-group-addon\" id=\"basic-addon1\"></span>
                   {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Откуда вы узнали про нас']) ?>

        <?= $form->field($model, 'comment')->textarea(['placeholder' => 'Комментарий*'])->label(false) ?>


        <?= Html::submitButton('Напишите нам', ['class' => 'btn btn-success btn-block']) ?>
        <br>
    <?php ActiveForm::end(); ?>
<?
Modal::end();

$this->registerJs(<<<JAVASCRIPT
$('#get_pricelist-form').on('submit', function () {
    var form = this;
    setTimeout(function() {
        if ($(form).find('.has-error').length) {
            return false;
        }
        $.post("/form/getprice/", $(form).serialize(), function (resp) {
            $('#get_pricelist .modal-body').html(resp.message)
        }, 'json');
    }, 300);
    return false;
});
JAVASCRIPT
, \yii\web\View::POS_READY);