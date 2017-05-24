<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\ProductsVideo */
?>
<div class="row">  
    <?php if ($model->name): ?>
    <h4><?=$model->name?></h4>
    <?php endif; ?>
    <iframe class="embed-responsive-item" width="560" height="315" src="<?=$model->link?>" frameborder="0" allowfullscreen></iframe>
</div>