<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\ProductsVideo */
?>
<div class="row">  
    <?php if ($model->name): ?>
    <h4><?=$model->name?></h4>
    <?php endif; ?>
    <?=$model->link?>
</div>