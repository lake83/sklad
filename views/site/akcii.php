<?

/* @var $this yii\web\View */
/* @var $baners app\models\Banners */

use yii\helpers\Html;

$this->title = 'Акции';

if ($baners) {
    foreach ($baners as $baner) {
        if ($baner['not_show_region'] == 0) {
            $img = Html::img('/images/uploads/source/' . $baner['image'], ['alt' => $baner['name'], 'title' => $baner['name'], 'width' => 723, 'style' => 'margin-bottom:15px']);
            if ($baner['link']) {
                echo Html::a($img, $baner['link']);
            } else {
                echo $img;
            }
        }
    }
}