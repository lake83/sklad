<?
/** @var $banner \app\models\Banner */
/** @var $this \yii\web\View */
?>
<div style="width:<?=$banner->width?>px; height:<?=$banner->height?>px; margin:0px auto;">
    <section id="fader<?=$banner->id?>">
        <? foreach ($banner->imageToBanners as $image) { ?>
        <img src="<?=$image->image?>"/>
        <? } ?>
    </section>
</div>
<?
$this->registerJs(<<<JAVASCRIPT
    jQuery('#fader{$banner->id} img:gt(0)').hide();
    
    setInterval(function(){
        jQuery('#fader{$banner->id} :first-child')
            .fadeTo(900, 0)
            .next('img')
            .fadeTo(900, 1)
            .end()
            .appendTo('#fader{$banner->id}');
    }, 10000);
JAVASCRIPT
);
