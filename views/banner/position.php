<?
/** @var $banners \app\models\Banner[] */
/** @var $this \yii\web\View */
?>
<div class="<?=$position?>">
    <? foreach ($banners as $banner) {
        $style = '';
        if ($banner->width) {
            $style .= 'width:' .$banner->width . 'px;';
        }
        if ($banner->height) {
            $style .= 'height:' .$banner->height . 'px;';
        }
        if ($banner->getImageToBanners()->count() > 1) {
            echo $this->renderPhpFile(Yii::getAlias('@app'). '/views/banner/slider.php', ['banner' => $banner, 'style' => $style]);
        } else if ($banner->getImageToBanners()->count()) {
            echo $this->renderPhpFile(Yii::getAlias('@app'). '/views/banner/' . ($banner->link ? 'banner' : 'image') . '.php', ['banner' => $banner, 'style' => $style, 'image' => $banner->imageToBanners[0]]);
        }
    } ?>
</div>

