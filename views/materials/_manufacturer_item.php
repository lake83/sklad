<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\Manufacturers */

use app\components\SiteHelper;
?>
  
<div class="glossary_item">
    <div class="glossary_head">
        <a class="glossary_headl" href="/nashi_postavchshiki/<?=$model->slug?>/"><?=$model->name?></a>
    </div> 
    <img src="<?=SiteHelper::resized_image($model->image, 100, 100)?>" alt="<?=$model->brand?>" title="<?=$model->name?>" class="glossary_img"/>
    <div class="glossary_txt">
        <p><?=$model->intro_text?></p>
    </div>
    <div class="clearfix"></div>
    <a class="artmore" href="/nashi_postavchshiki/<?=$model->slug?>/"></a>
    <div class="clearfix"></div>
</div>