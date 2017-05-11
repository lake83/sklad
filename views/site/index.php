<?php

/* @var $this yii\web\View */
/* @var $main app\models\Materials */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\SiteHelper;

echo $this->context->renderPartial('/materials/page', ['model' => $main]);

if ($slider) :
foreach ($slider as $item) {
    $items[] = Html::a(Html::img(SiteHelper::resized_image($item['image'], 200, 200), ['alt' => $item['name'], 'title' => $item['name']]), Url::to(['/clients/' . $item['slug']]));
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