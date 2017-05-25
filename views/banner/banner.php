<?
/** @var $banner \app\models\Banner */
/** @var $image \app\models\ImageToBanner */
/** @var $this \yii\web\View */
?>
<p>
    <a href="<?=$banner->link?>">
        <img style="<?=$style?>" src="<?=$image->image?> alt="">
        <br>
    </a>
</p>