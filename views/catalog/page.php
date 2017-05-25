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

$this->title = $model->title ? $model->title : $model->name;
if ($model->keywords) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords], 'keywords');
}
if ($model->description) {
    $this->registerMetaTag(['name' => 'description', 'content' => $model->description], 'description');
} ?>

<h1><?= $model->name ?></h1>

<?php
echo $model->intro_text;

if (count($children)): ?>
<strong>Каталог техники:</strong>

<a href="#" class="requestbutton pull-right">Запросить прайс-лист</a>

<ul class="catalog-list row">
    <?php foreach ($children as $one):
    if ($one['not_show_region'] == 0): ?>
    <li>
        <a class="catalog_preview" href="<?=Url::to([Yii::$app->request->pathInfo . $one['slug']])?>">
            <div title="<?=$one['name']?>" style="background: url('<?=SiteHelper::resized_image($one['image'], 120, null)?>') no-repeat;"></div>
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

echo $model->full_text; ?>