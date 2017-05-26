<?
/* @var $model \app\models\PriceGetForm */
/* @var $this \yii\web\View*/

use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use app\models\Catalog;
use yii\helpers\Html;

Modal::begin([
    'header' => 'Ваш запрос обработан',
    'id' => 'have_question',
]);
Modal::end();
?>

<div class="row">
    <div class="col-md-4">
        <h2>Консультация</h2>
        по телефонам:<br>
        +7 (495) 646-8227<br>
        +7 (800) 555-5393<br><br>
        или по e-mail:<br>
        zapros@maxi-sklad.ru
    </div>
    <div class="col-md-5 col-md-offset-1">
        <?php $form = ActiveForm::begin([
            'id' => 'have_question-form',
        ]); ?>
        <?= $form->field($model, 'fio', ['template'=>"{label}\n<div class=\"input-group\">\n
            <span class=\"input-group-addon\" id=\"basic-addon1\"><span class='glyphicon glyphicon-user'></span></span>
               {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'ФИО']) ?>
        <?= $form->field($model, 'phone', ['template'=>"{label}\n<div class=\"input-group\">\n
            <span class=\"input-group-addon\" id=\"basic-addon1\"><span class='glyphicon glyphicon-phone'></span></span>
               {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Телефон', "required" => true]) ?>

        <?= $form->field($model, 'email', ['template'=>"{label}\n<div class=\"input-group\">\n
            <span class=\"input-group-addon\" id=\"basic-addon1\"></span>
               {input}</div>\n{hint}\n{error}"])->label(false)->textInput(['placeholder' => 'Email']) ?>

        <?= $form->field($model, 'question')->textarea(['placeholder' => 'Ваш вопрос *', "required" => true])->label(false) ?>

        <?= $form->field($model, 'catalog_id')->hiddenInput()->label(false) ?>


        <?= Html::submitButton('Отпрвить', ['class' => 'btn btn-success btn-block']) ?>
        <br>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?


$this->registerJs(<<<JAVASCRIPT
$('#have_question-form').on('submit', function () {
    $.post("/form/havequestion/", $(this).serialize(), function (resp) {
        $('#have_question .modal-body').html(resp.message)
        $('#have_question').modal();
        $('#have_question-form')[0].reset();
    }, 'json');
    return false;
});
JAVASCRIPT
);