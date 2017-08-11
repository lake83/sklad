<?php

/* @var $this yii\web\View */
/* @var $news app\models\Materials */
/* @var $main app\models\Materials */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\SiteHelper;
use yii2mod\bxslider\BxSlider;
use app\models\Banners;

if ($news):
?>

<div class ="Znews">
    <p class="Znews__header"><span class="Znews__headerInner">Новости</span></p>
    <div class="Znews__inner">
        <?php foreach ($news as $n): ?>
        <?php if ($n['not_show_region'] == 0):
        $src = SiteHelper::resized_image($n['image'], 100, null);
        $size = SiteHelper::image_size($src); ?>
        <div class="ZnewsItem">
            <div class="ZnewsItem__imgbox">
                <div class="glossary_img" title="<?=$n['name']?>" style="background: url('<?=$src?>') no-repeat;background-size:<?=$size[0]>$size[1] ? '100% auto' : 'auto 100%'?>"></div>
            </div>
            <div class="ZnewsItem__txtbox">
                <a href="<?=Url::to(['/press-centr/news/' . $n['slug']])?>" class="ZnewsItem__head"><?=$n['name']?></a>
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

if ($baners = Banners::getBanners(2)): ?>
   <div class="actions"> 
   <?php echo Html::a('Акции', ['site/akcii'], ['class' => 'actions__header']);
   foreach ($baners as $baner) {
        if ($baner['not_show_region'] == 0) {
            $img = Html::img('/images/uploads/source/' . $baner['image'], ['alt' => $baner['name'], 'title' => $baner['name']]);
            if ($baner['link']) {
                $items_actions[] = Html::a($img, $baner['link']);
            } else {
                $items_actions[] = $img;
            }
        }
    }
    echo BxSlider::widget([
        'id' => 'actions',
        'pluginOptions' => [
            'auto' => true,
            'slideWidth' => 225,
            'minSlides' => 1,
            'maxSlides' => 1,
            'controls' => false,
            'pager' => false
        ],
        'items' => $items_actions
    ]); ?>
    </div>
<?php endif;

echo $this->context->renderPartial('/materials/page', ['model' => $main, 'title' => false]);

if ($slider) :
foreach ($slider as $item) {
    if ($item['not_show_region'] == 0) {
        $items_clients[] = Html::a('<div class="slider_img" title="' . Html::encode($item['name']) . '" style="background: url(\'' . SiteHelper::resized_image($item['image'], 130, null) . '\') no-repeat;"></div>', ['/clients/' . $item['slug']]);
    }
} ?>

<div class="clearfix"></div>
<div class="partnersSlider">
    <div class="partnersSlider__header">Нам доверяют:</div>
    <?= BxSlider::widget([
        'id' => 'clients',
        'pluginOptions' => [
            'slideWidth' => 130,
            'slideMargin' => 21,
            'minSlides' => 6,
            'maxSlides' => 6,
            'pager' => false
        ],
        'items' => $items_clients 
    ]) ?>
</div>
<?php endif; ?>