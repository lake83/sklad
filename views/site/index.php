<?php

/* @var $this yii\web\View */
/* @var $news app\models\Materials */
/* @var $main app\models\Materials */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\SiteHelper;

if ($news):
?>

<div class ="Znews">
    <p class="Znews__header"><span class="Znews__headerInner">Новости</span></p>
    <div class="Znews__inner">
        <?php foreach ($news as $n): ?>
        <?php if ($n['not_show_region'] == 0): ?>
        <div class="ZnewsItem">
            <div class="ZnewsItem__imgbox">
                <img src="<?=SiteHelper::resized_image($n['image'], 100, 100)?>" alt="<?=$n['name']?>"/>
            </div>
            <div class="ZnewsItem__txtbox">
                <a href="<?=Url::to(['/news/' . $n['slug']])?>" class="ZnewsItem__head"><?=$n['name']?></a>
                <div class="ZnewsItem__date"><?= Yii::$app->formatter->asDate($n['created_at'], 'php:d.m.Y') ?></div>
                <div class="ZnewsItem__description"><?=$n['intro_text']?></div>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        <a href="<?=Url::to(['/press-centr/news'])?>" class="Znews__all">Все новости</a>
    </div>
</div>

<?php endif;

echo $this->context->renderPartial('/materials/page', ['model' => $main, 'title' => false]);

if ($slider) :
foreach ($slider as $item) {
    if ($item['not_show_region'] == 0) {
        $items[] = Html::a(Html::img(SiteHelper::resized_image($item['image'], 200, 200), ['alt' => $item['name'], 'title' => $item['name']]), Url::to(['/clients/' . $item['slug']]));
    }
} ?>

<div class="clearfix"></div>
<div class="partnersSlider">
    <div class="partnersSlider__header">Нам доверяют:</div>
    <?= yii2mod\bxslider\BxSlider::widget([
        'pluginOptions' => [
            'slideWidth' => 130,
            'slideMargin' => 21,
            'minSlides' => 6,
            'maxSlides' => 6,
            'pager' => false
        ],
        'items' => $items 
    ]) ?>
</div>
<?php endif; ?>