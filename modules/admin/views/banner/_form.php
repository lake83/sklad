<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Banner;
use kartik\file\FileInput;
use himiklab\thumbnail\EasyThumbnailImage;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\Materials;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'images[]')->widget(FileInput::classname(), [
        'options' => [
            'multiple' => true,
            'accept' => 'image/*'
        ],
        'pluginOptions' => [
            'previewFileType' => 'image',
            'browseLabel' => 'Выбрать',
            'removeLabel' => 'Удалить',
            'showUpload' => false,
        ],
    ]); ?>

    <div class="images">
        <?php if (count($model->imageToBanners)): ?>
            <?php foreach ($model->imageToBanners as $image): ?>
                <div class="image">
                    <?= EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot') . $image->image, 160, 160, EasyThumbnailImage::THUMBNAIL_OUTBOUND) ?>
                    <?= Html::a('Удалить', ['delete-image', 'id' => $image->id], ['class' => 'btn btn-xs btn-danger delete-image']) ?>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>

    <?= $form->field($model, 'link')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Materials::find()->select(['*', 'concat("/news/", `slug`) as slug'])->where(['type' => 1, 'is_active' => 1])->all(), 'slug', 'name'),
        'options' => ['placeholder' => 'Введите свою ссылку или выберите из списка...', 'multiple' => false],
    ]) ?>



    <?= $form->field($model, 'width')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'height')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'position')->widget(Select2::classname(), [
        'data' => array_merge(\yii\helpers\ArrayHelper::map(Banner::find()->all(), 'position', 'position'), Banner::$positions),
        'options' => ['placeholder' => 'Выберите позицию для выввода акции ...', 'multiple' => false],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ]) ?>

    <?= $form->field($model, 'not_show_in_regions')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\Regions::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Выберите города ...', 'multiple' => true],
        'pluginOptions' => [
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ]) ?>

    <?= $form->field($model, 'is_active')->checkbox(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-link']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
