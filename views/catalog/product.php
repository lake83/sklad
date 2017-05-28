<?php

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $relatedData app\models\Products */
/* @var $shortData app\models\CatalogOptions */
/* @var $optionsData app\models\CatalogOptions */
/* @var $videoData app\models\ProductsVideo */
/* @var $brochuresData app\models\ProductsBrochures */

use yii\helpers\Html;
use app\components\SiteHelper;
use yii\bootstrap\Tabs;
use yii\grid\GridView;
use yii\widgets\ListView;

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
            <?php $src = SiteHelper::resized_image($model->image, 170, null);
                  $size = SiteHelper::image_size($src);
                  endif; ?>
                <div title="<?=$model->name?>" style="background: url('<?=$src?>') no-repeat;background-size:<?=$size[0]>$size[1] ? '100% auto' : 'auto 100%'?>"></div>
            <?php if ($model->image): ?>
            </a>
            <?php endif; ?>
        </div>
        <a class="formreqestitem requestbutton" data-toggle="modal" data-target="#get-pricelist-modal" href="javascript:void(0)">
            <?php if ($model->not_show_price == 1 || $model->price == 0): ?>
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
    <div class="clearfix"></div>
    <?php if ($shortData) {
        $columns = [
            [
                'attribute' => 'name',
                'label' => false
            ],
            [
                'attribute' => 'value',
                'label' => false
            ]
        ];
        $items[] = ['label' => 'Коротко', 'content' => GridView::widget([
		    'dataProvider' => $shortData,
            'headerRowOptions' => ['class' => 'hide'],
            'summary' => false,
            'columns' => $columns
        ])];
    }
    if ($optionsData) {
        $items[] = ['label' => 'Спецификация', 'content' => GridView::widget([
		    'dataProvider' => $optionsData,
            'headerRowOptions' => ['class' => 'hide'],
            'summary' => false,
            'columns' => $columns
        ])];
    }
    if ($relatedData) {
        $items[] = ['label' => 'С этим товаром покупают', 'content' => ListView::widget([
            'id' => 'related_list',
            'dataProvider' => $relatedData,
            'layout' => "{items}",
            'itemView' => '_product_item'
        ])];
    }
    if ($videoData) {
        $items[] = ['label' => 'Видео', 'content' => ListView::widget([
            'id' => 'video_list',
            'dataProvider' => $videoData,
            'layout' => "{items}",
            'itemView' => '_video_item'
        ])];
    }
    if ($brochuresData) {
        $items[] = ['label' => 'Брошюра', 'content' => ListView::widget([
            'id' => 'brochures_list',
            'dataProvider' => $brochuresData,
            'layout' => "{items}",
            'itemView' => '_brochures_item'
        ])];
    }
    $items[] = ['label' => 'Схема работы', 'content' => Html::img('/images/uploads/source/Pages/skhema-prodazh.jpg', ['alt' => 'Схема работы', 'title' => 'Схема работы', 'width' => '100%'])];
    
    echo Tabs::widget(['id' => 'product_details', 'items' => $items]); ?>
</div>

<?php
$form = new app\models\PriceGetForm();
$form->catalog_id = $model->catalog_id;
$form->product_id = $model->id;
$form->type = 'clarifyprice';
echo $this->render('/forms/getprice', ['model' => $form]);
?>