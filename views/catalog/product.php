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
use app\models\Regions;

$regions = Regions::getRegions();

$this->title = $model->title ? $model->title : $model->name . ' | Купить в «МаксиСклад» г. ' . $regions[Yii::$app->params['region']]['name'];
if ($model->keywords) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords], 'keywords');
}
$this->registerMetaTag(['name' => 'description', 'content' => ($model->description ? str_replace('##CITY##', $regions[Yii::$app->params['region']]['name'], $model->description) :
    $model->name . ' : купить в «МаксиСклад» г. ' . $regions[Yii::$app->params['region']]['name'] . '. Доступные цены на ' . $model->catalog->name . '. Описание, характеристики, брошюры, схема работы представлены на сайте ' . DOMAIN)], 'description'); ?>

<h1><?= $model->name ?></h1>

<div class="detail">
    <div class="left">
        <?php if ($model->image):
            $fotorama = \metalguardian\fotorama\Fotorama::begin([
                'options' => [
                    'width' => '200',
                    'loop' => 'true',
                    'nav' => 'thumbs',
                    'allowfullscreen' => 'true'
                ]
            ]); 
            foreach ($model->image as $image): ?>
                <?php if (file_exists(Yii::getAlias('@webroot/images/uploads/source/') . $image)): ?>
                <img src="/images/uploads/source/<?=$image?>" alt="<?=$model->name?>" width="200"/>
                <?php else: ?>
                <img src="<?=SiteHelper::resized_image($image, 170, null)?>" alt="<?=$model->name?>" width="200"/>
                <?php endif; ?>
            <?php endforeach; 
            $fotorama->end();
            else: ?>
            <div class="main">
            <div title="<?=$model->name?>" style="background: url('<?=SiteHelper::resized_image('', 170, null)?>') no-repeat;background-size:100% 100%"></div>
            </div>
            <?php endif; ?>
        
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
    $items[] = ['label' => 'Схема работы', 'content' => Html::img('/images/uploads/source/Pages/skhema-prodazh.jpg', ['alt' => 'Схема работы', 'title' => 'Схема работы', 'style' => 'width:100%'])];
    
    echo Tabs::widget(['id' => 'product_details', 'items' => $items]);
    
    if ($relatedData) {
        echo '<h3>С этим товаром покупают</h3>';
        echo ListView::widget([
            'id' => 'related_list',
            'dataProvider' => $relatedData,
            'layout' => "{items}",
            'itemView' => '_product_item'
        ]);
    } ?>
</div>

<?php
$form = new app\models\PriceGetForm();
$form->catalog_id = $model->catalog_id;
$form->product_id = $model->id;
$form->type = 'clarifyprice';
echo $this->render('/forms/getprice', ['model' => $form]);
?>