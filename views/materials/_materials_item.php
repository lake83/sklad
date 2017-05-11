<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\Materials */

use app\components\SiteHelper;

$type = $model->type == 1 ? '/news/' : '/stati/';
?>
  
<div class="art-block">
    <div class="ab1">
        <img src="<?=SiteHelper::resized_image($model->image, 100, 100)?>" alt="<?=$model->name?>"/>
    </div>
    <div class="ab2">
        <a class="newsa" href="<?=$type . $model->slug?>/"><?=$model->name?></a>
        <p class="ndate"><?= Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y') ?></p>
        <div class="glossary_txt"><?=$model->intro_text?></div>
    </div>
    <div class="clearfix"></div>
    <a class="artmore" href="<?=$type . $model->slug?>/"></a>     
    <div class="clearfix"></div>
</div>