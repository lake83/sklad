<?php
/* @var $this \yii\web\View */
/* @var $catalogItems array \app\models\Catalog */

use yii\helpers\Html;
use app\components\SiteHelper;

if ($catalogItems && $catalogItems[0]['is_active'] == 1 && $catalogItems[0]['not_show_region'] == 0):
?>

<ul class="links_tree">
<?php 
$level = 0;

foreach($catalogItems as $category) {
	if ($category['is_active'] == 1 && $category['not_show_region'] == 0) {
        if ($category['depth'] == $level) {
	        echo '</li>'."\n";
	    } else if ($category['depth'] > $level) {
	        echo '<ul>'."\n";
	    } else {
		    echo '</li>'."\n";

		    for ($i = $level-$category['depth']; $i; $i--) {
			    echo '</ul>'."\n";
			    echo '</li>'."\n";
		    }
	    }
	    echo '<li' . ($category['depth'] == 1 && ($category['rgt']-$category['lft']) !== 1 ? ' class="cat-modal"' : '') . '>';
	    $image = '';
        if ($category['depth'] == 2) {
	        $image = '<span title="' . $category['name'] . '" style="background:url(' . SiteHelper::resized_image($category['image'], 120, 100) . ') no-repeat;"></span><br />';
	    }
        echo Html::a($image.$category['name'], ['catalog/page', 'alias' => $category['slug']], 
                 $category['depth'] == 0 ? ['class' => 'catalogtitle'] : ($category['depth'] == 1 ? ['class' => 'octo'] : [])
             );
	    $level = $category['depth'];
    }
}
for ($i = $level; $i; $i--) {
	echo '<li>'."\n";
	echo '</ul>'."\n";
}
endif; ?>