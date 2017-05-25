<?
/** @var $banner \app\models\Banner */
/** @var $image \app\models\ImageToBanner */
/** @var $this \yii\web\View */
?>
<p>
    <img src="<?=$image->image?>"  style="width:<?=$banner->width?>px; height:<?=$banner->height?>px;" alt="">
    <br>
</p>
