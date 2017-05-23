<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model yii\base\DynamicModel */
/* @var $options app\models\CatalogOptions */
/* @var $form yii\bootstrap\ActiveForm */

$form = ActiveForm::begin(['layout' => 'horizontal', 'action' => ['products/options', 'id' => Yii::$app->request->get('id')]]);

foreach ($model as $key => $one) {
    echo $form->field($model, $key)->label($options[str_replace('field', '', $key)]);
}
?>

<div class="box-footer">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>