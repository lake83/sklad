<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\Manufacturers */

use app\components\SiteHelper;
?>
  
<div class="glossary_item">
    <div class="glossary_head">
        <a class="glossary_headl" href="/nashi_postavchshiki/<?=$model->slug?>/" data-pjax="0"><?=$model->name?></a>
    </div>
    <div class="glossary_img" title="<?=$model->brand?>" style="background: url('<?=SiteHelper::resized_image($model->image, 100, null)?>') no-repeat;"></div>
    <div class="glossary_txt">
        <p><?=$model->intro_text?></p>
    </div>
    <div class="clearfix"></div>
    <a class="artmore" href="/nashi_postavchshiki/<?=$model->slug?>/" data-pjax="0"></a>
    <div class="clearfix"></div>
</div>