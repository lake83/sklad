<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\MenuWidget;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
    <title><?= Html::encode($this->title) ?></title>
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
                    <?php if($_SERVER['REQUEST_URI'] == '/'): ?>
                        <img src="/images/logo.png" alt="<?=Yii::$app->name?>" />
                    <?php else: ?>
                        <a href="/" title="<?=Yii::$app->name?>">
                             <img src="/images/logo.png" alt="<?=Yii::$app->name?>" />
                        </a>
                    <?php endif;?>
                </div>
                <div class="Zreg-sel">
                    <?//= RegionSelect::widget() /*php /* * / */?>
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
                            <span><?= $region->phone1?></span>
                            <span>+7 (800) 555-5393<p> Звонок бесплатный по РФ</p></span>
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

<footer class="footer">
    <div class="container">
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
