<?
/** @var $banners \app\models\Banner[] */
/** @var $this \yii\web\View */
?>
<div class="<?=$position?>">
    <? foreach ($banners as $banner) {
        if ($banner->getImageToBanners()->count() > 1) {
            echo $this->renderPhpFile(Yii::getAlias('@app'). '/views/banner/slider.php', ['banner' => $banner]);
        } else if ($banner->getImageToBanners()->count()) {
            echo $this->render(Yii::getAlias('@app'). '/views/banner/' . ($banner->link ? 'banner' : 'image'), ['banner' => $banner]);
        }
    } ?>
</div>

