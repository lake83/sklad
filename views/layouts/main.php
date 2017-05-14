<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuWidget;
use app\components\RegionSelect;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Regions;

AppAsset::register($this);

$regions = Regions::getRegions();

if (Yii::$app->request->hostName !== DOMAIN) {
    $region = explode('.', Yii::$app->request->hostName);
    Yii::$app->params['region'] = $region[0];
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
    <title><?= Html::encode($this->title) ?> | «МаксиСклад» г. <?= $regions[Yii::$app->params['region']]['name'] ?></title>
    <?php $this->head() ?>
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
            <a class="requestcall" href="<?=Url::to(['#' => 'formcallback'])?>">заказать звонок</a>
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
                    <form id="top-search" name="top-search" action="<?=Url::to(['/search'])?>">
                        <span style = "display: inline-block;">
                        <?/*= Typeahead::widget([
                            'name' => 'q',
                            'options' => [
                                'placeholder' => 'Поиск по каталогу',
                                'data-placeholder' => 'Поиск по каталогу',
                                'class' => 'search-val',
                                'style' => 'display:inline-block;'
                            ],
                            'pluginOptions' => ['highlight'=>true],
                            'dataset' => [
                                [
                                    'local' => $product,
                                    'limit' => 10
                                ]
                            ]
                        ]);*/ ?>
                        </span>
                        <input type="submit" id="submit-search-button" class="submitsearch"/>
                        <?php $catId = 0;
                        if (Yii::$app->controller->id == 'catalog') {
                            $catId = $this->model->id;
                        } elseif (Yii::$app->controller->id=='search') {
                            $catId = $cat_id;
                        } ?>
                        <input type="hidden" name="cat_id" value="<?= $catId ?>"/>
                    </form>
                </div>
                <div class="z-right">
                    <div class="phone-top">
                        <span id="main_tel">
                            <span><?= $regions[Yii::$app->params['region']]['phone'] ?></span>
                            <span>+7 (800) 555-5393<p>Звонок бесплатный по РФ</p></span>
                        </span>
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
        <div class="left-column">
            <div class="asideContacts">
                <div class="asideEmail asideContacts__block">
                    <div class="asideContacts__block_heading">Электронная почта:</div>
                    <a href="mailto:<?= $regions[Yii::$app->params['region']]['email'] ?>"><?= $regions[Yii::$app->params['region']]['email'] ?></a>
                </div>
                <div class="asidePhone asideContacts__block">
                    <div class="asideContacts__block_heading">Телефон:</div>
                    +7 (800) 555-5393<br/>
                    <?= $regions[Yii::$app->params['region']]['phone'] ?>
                </div>
            </div>
        </div>
        <div class="right-column">
            <?= Breadcrumbs::widget([
            'homeLink' => [ 
                'label' => 'Складская техника',
                'url' => Yii::$app->homeUrl
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
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
            E-mail: <a href="mailto:<?= $regions[Yii::$app->params['region']]['email'] ?>"><?= $regions[Yii::$app->params['region']]['email'] ?></a>
        </div>
        <a href="<?=Url::to(['materials/page', 'alias' => 'karta_sayta'])?>" class="sitemap_link">Карта сайта</a>
        <div>
            <a style="text-decoration-line: none;" href="http://astonia.ru/" target="_blank" rel="nofollow" title="Разработка сайта">>Разработка сайта</a>
            <a style="text-decoration-line: none;" href="http://www.astoni.ru/" target="_blank" rel="nofollow" title="Продвижение сайтов">>Поддержка сайтов</a>  
        </div>
        <div>
            <a href="http://www.cool-reklama.ru" target="_blank"><img src="/images/astonia.png" alt="реклама в интернете"/></a>
        </div>
    </footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>