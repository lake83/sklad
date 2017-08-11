<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuWidget;
use app\components\RegionSelect;
use app\components\CatalogMenu;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Regions;
use app\models\Banners;
use yii2mod\bxslider\BxSlider;
use yii\jui\AutoComplete;

AppAsset::register($this);

$regions = Regions::getRegions();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
    <title><?= Html::encode(str_replace('##CITY##', $regions[Yii::$app->params['region']]['name'], $this->title)) ?></title>
    <?php $this->head() ?>

    <!--<script type="text/javascript">
        (function ct_load_script() {
        var ct = document.createElement('script'); ct.type = 'text/javascript';
        ct.src = document.location.protocol+'//cc.calltracking.ru/phone.5c429.4879.async.js?nc='+Math.floor(new Date().getTime()/300000);
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ct, s);
        })();
    </script>-->


</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <div class="Ztopper">
            <span class="octo_tel">
                Рабочие дни: Пн-Пт, 09:00-18:00.<br/>
                Выходные: суббота, воскресенье.
            </span>
            <a class="akcii_top_button" href="<?=Url::to(['/akcii'])?>">акции</a>
            <a class="requestcall" href="javascript:void(0)" data-toggle="modal" data-target="#recall-form-modal">заказать звонок</a>
            <?= Html::mailto('Отправить письмо', 'zapros@maxi-sklad.ru', ['class' => 'sendletter']) ?>
            <div class="ZTleft">
                <div class="Zlogo">
                    <?php if(Yii::$app->request->url == '/'): ?>
                        <img src="/images/logo.png" alt="<?=Yii::$app->name?>" />
                    <?php else: ?>
                        <a href="/" title="<?=Yii::$app->name?>">
                             <img src="/images/logo.png" alt="<?=Yii::$app->name?>" />
                        </a>
                    <?php endif;?>
                </div>
                <div class="Zreg-sel">
                    <?= RegionSelect::widget(['regions' => $regions]) ?>
                </div>
            </div>
            <div class="ZTmiddle">
                <div class="top-search">
                    <form id="top-search" name="top-search" action="<?=Url::to(['site/search'])?>">
                        <?= AutoComplete::widget([
                            'name' => 'q',
                            'clientOptions' => [
                            'source' => Url::to(['site/autocomplete']),
                                'minLength'=>'3',
                            ],
                            'options' => [
                                'class' => 'search-val'
                            ]
                        ]); ?>
                        <input type="submit" id="submit-search-button" class="submitsearch" value=""/>
                    </form>
                </div>
                <div class="z-right">
                    <div class="phone-top">
                        <div id="main_tel">
                            <div><?= $regions[Yii::$app->params['region']]['phone'] ?></div>
                            <div>+7 (800) 555-5393<p>Звонок бесплатный по РФ</p></div>
                        </div>
                    </div>
                </div>
                <div class="top-menu">
                    <?= MenuWidget::widget(['alias' => 'verhnee-menu']) ?>
                </div>
                <div class="top-menu lower-menu">
                    <?= MenuWidget::widget(['alias' => 'niznee-menu']) ?>
                </div>
            </div>
        </div>
        <?php if (Url::current() == Url::home() && ($baners = Banners::getBanners(1))): ?>
        <div class="top-banners">
           <?php foreach ($baners as $baner) {
                if ($baner['not_show_region'] == 0) {
                    $img = Html::img('/images/uploads/source/' . $baner['image'], ['alt' => $baner['name'], 'title' => $baner['name']]);
                    if ($baner['link']) {
                        $items[] = Html::a($img, $baner['link']);
                    } else {
                        $items[] = $img;
                    }
                }
            }
            echo BxSlider::widget([
                'id' => 'banners',
                'pluginOptions' => [
                    'auto' => true,
                    'slideWidth' => 1000,
                    'minSlides' => 1,
                    'maxSlides' => 1,
                    'controls' => false,
                    'pager' => true
                ],
                'items' => $items
            ]); ?>
        </div>
        <?php endif; ?>
        <div class="left-column">
            <?= CatalogMenu::widget() ?>
            <?php if ($baners = Banners::getBanners(3)) {
                foreach ($baners as $baner) {
                    if ($baner['not_show_region'] == 0) {
                        $img = Html::img('/images/uploads/source/' . $baner['image'], ['alt' => $baner['name'], 'title' => $baner['name'], 'style' => 'margin:15px 0']);
                        if ($baner['link']) {
                            echo Html::a($img, $baner['link']);
                        } else {
                            echo $img;
                        }
                    }
                }
            } ?>
            <div class="asideContacts">
                <div class="asideEmail asideContacts__block">
                    <div class="asideContacts__block_heading">Электронная почта:</div>
                    <?= $mailto = Yii::$app->formatter->asEmail($regions[Yii::$app->params['region']]['email']) ?>
                </div>
                <div class="asidePhone asideContacts__block">
                    <div class="asideContacts__block_heading">Телефон:</div>
                    +7 (800) 555-5393<br/>
                    <?= $regions[Yii::$app->params['region']]['phone'] ?>
                </div>
            </div>
        </div>
        <div class="right-column">
        
            <div xmlns:v="http://rdf.data-vocabulary.org/#">
            <? $breadcrumbs = Breadcrumbs::widget([
            'itemTemplate' => "<li><span typeof=\"v:Breadcrumb\">{link}</span></li>\n", // template for all links
            'homeLink' => [ 
                'label' => 'Складская техника',
                'url' => Yii::$app->homeUrl
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ;
        echo preg_replace("/<a href/","<a rel=\"v:url\" property=\"v:title\" href",$breadcrumbs);  
        ?>
        </div>
        
            <?= $content ?>
        </div>
    </div>
</div>

<div class="container">
    <div id="toTop" style="display: block;"><img src="/images/up.png" alt="Вверх"/></div>
    <footer class="footer">
        <div>
            © 2007 - <?= date( 'Y' ) ?>, <b>"МаксиСклад"</b><br/>
            При полном или частичном использовании материалов ссылка на сайт обязательна
        </div>
        <div>
            Адрес: <?= $regions[Yii::$app->params['region']]['name'] ?>, <br/><?= $regions[Yii::$app->params['region']]['address'] ?><br/>
            E-mail: <?= $mailto ?>
        </div>
        <a href="<?=Url::to(['materials/page', 'alias' => 'karta_sayta'])?>" class="sitemap_link">Карта сайта</a>
        <div>
            <a style="text-decoration-line: none;" href="http://astonia.ru/" target="_blank" rel="nofollow" title="Разработка сайта">Разработка сайта</a>
            <a style="text-decoration-line: none;" href="http://www.astoni.ru/" target="_blank" rel="nofollow" title="Продвижение сайтов">Поддержка сайтов</a>  
        </div>
        <div>
            <a href="http://www.cool-reklama.ru" target="_blank"><img src="/images/astonia.png" alt="реклама в интернете"/></a>
        </div>
    </footer>
</div>
<?=$this->render('/forms/recall', ['model' => new \app\models\RecallForm()])?>
<?php $this->endBody() ?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter37797340 = new Ya.Metrika({
                    id:37797340,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/37797340" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92777752-2', 'auto');
  ga('send', 'pageview');
</script>

<script type="text/javascript">
var __cs = __cs || [];
__cs.push(["setCsAccount", "krG_aaGTtHyHy9zgihzs6y3L42zH8fhr"]);
</script>
<script type="text/javascript" async src="//app.comagic.ru/static/cs.min.js"></script>

</body>
</html>
<?php $this->endPage() ?>