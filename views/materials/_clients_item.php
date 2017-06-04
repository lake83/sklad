<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\Materials */

use app\components\SiteHelper;

if ($model['not_show_region'] == 0): ?>
  
<div class="clients-logo">
    <a href="/clients/<?=$model['slug']?>" data-pjax="0">
        <div title="<?=$model['name']?>" style="background: url('<?=SiteHelper::resized_image($model['image'], 200, null)?>') no-repeat;"></div>
    </a>
</div>

<?php endif; ?>