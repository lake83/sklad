<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\Products */

use yii\helpers\Url;
use app\components\SiteHelper;

if ($model->not_show_region == 0): ?>
  
<div class="product_item">
    <div class="thumbnail">
        <a href="<?= $model->getUrl() ?>">
            <div class="prod-title"><?= $model->name ?></div>
            <img src="<?=SiteHelper::resized_image($model->image, 170, 140)?>" alt="<?=$model->name?>" title="<?=$model->name?>"/>
        </a>
        <p>
            <?php if ($model->not_show_price == 0 && $model->price > 0): ?>
            <span style="background: #fff79d;">Цена: <?= Yii::$app->formatter->asDecimal($model->price) . ' ' . $model->getСurrency($model->currency) ?></span>
            <?php endif;
            if ($anons = $model->getOptions(true)):
            foreach ($anons as $one): ?>
            <span><?=$one['name']?>: <?=$one['value']?></span>
            <?php endforeach;
            endif; ?>
        </p>
    </div>
</div>

<?php endif; ?>