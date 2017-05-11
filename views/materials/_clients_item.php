<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\Materials */

use app\components\SiteHelper;
?>
  
<div class="clients-logo">
    <a href="/clients/<?=$model['slug']?>">
        <img src="<?=SiteHelper::resized_image($model['image'], 200, 200)?>" alt="<?=$model['name']?>" title="<?=$model['name']?>"/>
    </a>
</div>