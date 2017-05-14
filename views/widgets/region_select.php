<?php
/* @var $this \yii\web\View */
/* @var $regions array \app\models\Regions */
/* @var $thisRegion string */

use yii\helpers\Html;

$request = Yii::$app->request;
?>

<div class="tooltip_conteiner" id="city-list">
    <span class="fl">Ваш регион:</span>
    <a class="fl" href="javascript:void(0)" id="download_now"><?= $regions[Yii::$app->params['region']]['name'] ?></a>
    <img src="/images/toolsel.gif"/>
    <div id="region-list">
        <?php foreach($regions as $region): ?>
             <br/>
             <?= Html::a($region['name'], ($request->isSecureConnection ? 'https://' : 'http://') .
                 ($region['subdomain'] ? $region['subdomain'] . '.' : '') . DOMAIN . '/' . $request->pathInfo)
             ?>
        <?php endforeach; ?>
    </div>
</div>

<?php if (!isset($_COOKIE['region'])): ?>
<div class="tooltip-fader"></div>
<div class="tooltip_conteiner" id="tooltip_conteiner_city">
    <div id="region-city">
        <img src="/images/top_tooltip.png" style="left: -15px;position: relative;top: -12px;"/>
        <div>
            Ближайший<br />к вам город:<br />
            <h3><?=$regions[$thisRegion]['name']?></h3>
            Угадали?<br /><br />
        </div>
        <div>
            <?= Html::a('Да', ['site/region', 'subdomain' => $thisRegion], ['class' => 'btn btn-default']) ?>
            <?= Html::a('Нет', ['site/region', 'subdomain' => ''], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<?php endif; ?>