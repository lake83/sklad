<?php

/* @var $this yii\web\View */
/* @var $model app\models\Manufacturers */
/* @var $categories app\models\Catalog */

use app\components\SiteHelper;
use app\models\Catalog;

$this->title = $model->title ? $model->title : $model->name;
if ($model->keywords) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords]);
}
if ($model->description) {
    $this->registerMetaTag(['name' => 'description', 'content' => $model->description]);
}
$this->params['breadcrumbs'][] = ['label' => 'О компании', 'url' => ['/about']];
$this->params['breadcrumbs'][] = ['label' => 'Наши поставщики', 'url' => ['/about/nashi_postavchshiki']];
$this->params['breadcrumbs'][] = $model->name;
?>

<h1><?= $model->name ?></h1>

<div class="mcblock">
<?= $model->full_text ?>
</div>

<?php if ($categories): ?>

<ul class="catalog-list row mcblock-products">
    <h4>Ассортимент техники:</h4>
    <?php foreach ($categories as $one):
    if ($one->not_show_region == 0):
    $src = SiteHelper::resized_image($one->image, 120, null);
    $size = SiteHelper::image_size($src); ?>

    <li>
        <a class="catalog_preview" href="<?=$one->getUrl()?>">
            <div title="<?=$one->name?>" style="background: url('<?=$src?>') no-repeat;<?=$one->image ? ($size[0]>$size[1] ? 'background-size:100% auto' : 'background-size:auto 100%') : ''?>"></div>
            <div class="caption"><?=$one->name?></div>
        </a>        
    </li>
    <?php endif;
    endforeach; ?>
</ul>

<?php endif; ?>