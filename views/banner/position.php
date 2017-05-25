<?
use app\models\Regions;
/** @var $banners \app\models\Banner[] */
/** @var $this \yii\web\View */
$regions = Regions::getRegions();
$region_id = (int)$regions[Yii::$app->params['region']]['id'];
?>
<div class="<?=$position?>">
    <? foreach ($banners as $banner) {
        $regions = array_map('intval', explode(',', $banner->not_show_in_regions ?: ''));

        if ($region_id and count($regions) and in_array($region_id, $regions)) {
            continue;
        }

        $style = '';
        if ($banner->width) {
            $style .= 'width:' .$banner->width . 'px;';
        }
        if ($banner->height) {
            $style .= 'height:' .$banner->height . 'px;';
        }
        if ($banner->getImageToBanners()->count() > 1) {
            if (!$not_slide) {
                echo $this->renderPhpFile(Yii::getAlias('@app'). '/views/banner/slider.php', ['banner' => $banner, 'style' => $style]);
            } else {
                echo $this->renderPhpFile(Yii::getAlias('@app'). '/views/banner/parts.php', ['banner' => $banner, 'style' => $style]);
            }
        } else if ($banner->getImageToBanners()->count()) {
            echo $this->renderPhpFile(Yii::getAlias('@app'). '/views/banner/' . ($banner->link ? 'banner' : 'image') . '.php', ['banner' => $banner, 'style' => $style, 'image' => $banner->imageToBanners[0]]);
        }
    } ?>
</div>

