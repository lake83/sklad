<?php

/* @var $this yii\web\View */
/* @var $model app\models\Products */

use yii\helpers\Html;
use app\components\SiteHelper;

$this->title = $model->title ? $model->title : $model->name;
if ($model->keywords) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords], 'keywords');
}
if ($model->description) {
    $this->registerMetaTag(['name' => 'description', 'content' => $model->description], 'description');
} ?>

<h1><?= $model->name ?></h1>

<div class="detail">
    <div class="left">
        <div class="main"> 
            <?php if ($model->image): ?>
            <a class="fancyItem" href="/images/uploads/source/<?=$model->image?>" data-fancybox="true">
            <?= newerton\fancybox3\FancyBox::widget() ?>
            <?php endif; ?>
                <img src="<?=SiteHelper::resized_image($model->image, 170, 140)?>" alt="<?=$model->name?>" title="<?=$model->name?>"/>
            <?php if ($model->image): ?>
            </a>
            <?php endif; ?>
        </div>
        <a class="formreqestitem requestbutton" href="">
            <?php if ($model->not_show_price == 1): ?>
                Уточнить стоимость
            <?php else: ?>
                Цена: <?= Yii::$app->formatter->asDecimal($model->price) . ' ' . $model->getСurrency($model->currency) ?>
            <?php endif; ?>
        </a>
        <div class="mcblock-flashmessage">
            Позвоните нам<br />
            +7 (800) 555-53-93 *<br />
            * Звонок бесплатный по РФ
        </div>
    </div>
    <div class="right">
        <?= $model->full_text; ?>
    </div>
</div>