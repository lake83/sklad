<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\Materials */

use app\components\SiteHelper;
use yii\helpers\Url;

$type = $model->type == 1 ? 'press-centr/news/' : 'press-centr/stati/';

if ($model->not_show_region == 0):
    $src = SiteHelper::resized_image($model->image, 100, null);
    $size = SiteHelper::image_size($src); ?>
  
<div class="art-block">
    <div class="ab1">
        <div class="glossary_img" title="<?=$model->name?>" style="background: url('<?=$src?>') no-repeat;background-size:<?=$size[0]>$size[1] ? '100% auto' : 'auto 100%'?>"></div>
    </div>
    <div class="ab2">
        <a class="newsa" href="<?=Url::to([$type . $model->slug])?>" data-pjax="0"><?=$model->name?></a>
        <p class="ndate"><?= Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y') ?></p>
        <div class="glossary_txt"><?=$model->intro_text?></div>
    </div>
    <div class="clearfix"></div>
    <a class="artmore" href="<?=Url::to([$type . $model->slug])?>" data-pjax="0"></a>     
    <div class="clearfix"></div>
</div>

<?php endif; ?>