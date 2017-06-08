<?php

/* @var $this yii\web\View */
/* @var $model app\models\Catalog */
/* @var $leaves app\models\Catalog */
/* @var $dataProvider app\models\Products */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\SiteHelper;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\models\Regions;

$regions = Regions::getRegions();

$this->title = $model->title ? $model->title : $model->name;
if ($model->keywords) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords], 'keywords');
}
if ($model->description) {
    $this->registerMetaTag(['name' => 'description', 'content' => str_replace('##CITY##', $regions[Yii::$app->params['region']]['name'], $model->description)], 'description');
} else {
    if ($model->depth == 1) {
        $description = $model->name . ': купить по доступной цене в «Макси Склад» г. ' . $regions[Yii::$app->params['region']]['name'] . '. Мы являемся официальными дилерами. Гарантируем высокое качество, сервис и ремонт, обслуживание спецтехники.';
    } else {
        $section = $this->params['breadcrumbs'];
        array_shift($section);
        $section_list = $model->name . ' ';
        foreach (array_reverse($section) as $one) {
            if (is_array($one)) {
                $section_list.= mb_strtolower($one['label']) . ' ';
            }
        }
        $description = $section_list . ': купить по доступной цене в «Макси Склад» г. ' . $regions[Yii::$app->params['region']]['name'] . '. Широкий ассортимент (в каталоге представлено более ' . (\app\models\Products::find()->where(['is_active' => 1])->count()) . ' моделей). Гарантия. Сервис и ремонт. Мы являемся официальным дилером';
    }
    $this->registerMetaTag(['name' => 'description', 'content' => $description], 'description');
} ?>

<h1><?= $model->article_name ? $model->article_name : $model->name ?></h1>

<?php
echo $model->intro_text; ?>

<strong><?=count($children) ? 'Каталог' : 'Каталог продукции'?>:</strong>

<a href="javascript:void(0)" data-toggle="modal" data-target="#get-pricelist-modal" class="requestbutton pull-right">Запросить прайс-лист</a>

<div class="clearfix" style="margin-bottom: 30px;"></div>

<?php if (count($children)): ?>

<ul class="catalog-list row">
    <?php foreach ($children as $one):
    if ($one['not_show_region'] == 0):
    $src = SiteHelper::resized_image($one['image'], 120, null);
    $size = SiteHelper::image_size($src); ?>

    <li>
        <a class="catalog_preview" href="<?=Url::to([Yii::$app->request->pathInfo . $one['slug']])?>">
            <div title="<?=$one['name']?>" style="background: url('<?=$src?>') no-repeat;<?=$one['image'] ? ($size[0]>$size[1] ? 'background-size:100% auto' : 'background-size:auto 100%') : ''?>"></div>
            <div class="caption"><?=$one['name']?></div>
        </a>        
    </li>
    <?php endif;
    endforeach; ?>
</ul>
<?php endif;

Pjax::begin(['id' => 'products_items', 'timeout' => false]);

echo ListView::widget([
     'id' => 'products_list',
     'dataProvider' => $dataProvider,
     'layout' => "{items}\n<div class='clearfix'></div>{pager}",
     'itemView' => '_product_item',
     'emptyText' => 'Нет доступных товаров.'
]);

Pjax::end();

echo $model->full_text;

$form = new app\models\HaveQuestionForm();
$form->catalog_id = $model->id;
echo $this->render('/forms/havequestion.php', ['model' => $form]);

$form2 = new app\models\PriceGetForm();
$form2->catalog_id = $model->id;
echo $this->render('/forms/getprice', ['model' => $form2]);
?>