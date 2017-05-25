<?
/** @var $banner \app\models\Banner */
/** @var $this \yii\web\View */
?>

<? foreach ($banner->imageToBanners as $image) { ?>
    <p>
        <img style="max-width:100%" src="<?=$image->image?>"/>
        <br>
    </p>
<? } ?>

