<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\RedactorTinymce;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */
/* @var $form yii\bootstrap\ActiveForm */

$type = Yii::$app->request->get('type');

$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Генерируется из названия.') ?>

    <?php if ((int)$type !== 3) {
        echo $form->field($model, 'image')->widget(\app\components\FilemanagerInput::className());
        
        if ((int)$type !== 4) {
            echo $form->field($model, 'intro_text')->widget(RedactorTinymce::className());
        }
    } ?>

    <?= $form->field($model, 'full_text')->widget(RedactorTinymce::className()) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?=  Html::activeHiddenInput($model, 'type', ['value' => $type]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>