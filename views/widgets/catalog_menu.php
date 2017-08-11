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
	        //echo '</li>'."\n";
	    } else if ($category['depth'] > $level) {
	        echo '<ul>'."\n";
	    } else {
		    echo '</li>'."\n";

		    for ($i = $level-$category['depth']; $i; $i--) {
			    echo '</ul>'."\n";
			    echo '</li>'."\n";
		    }
	    }
        $path = trim(Yii::$app->request->pathInfo, '/');
        if (($path == $category['slug'] && $path !== $catalogItems[0]['slug']) || ($category['depth'] == 1 && strpos($path, $category['slug']) !== false)) {
            $active = true;
            if (!isset($active_cat)) {
                $active_cat = $category['rgt'];
            }
        } else {
            $active = false;
        }
        $src = SiteHelper::resized_image($category['image'], 120, null);

        $size = SiteHelper::image_size($src);
        
        echo '<li' . ($category['depth'] == 1 ? ($active ? ' class="active"' : (($category['rgt']-$category['lft']) !== 1 ? ' class="cat-modal"' : '')) : '') . '>';
	    $image = '';
        if ($category['depth'] == 2 && !$active && $active_cat < $category['rgt']) {
	        $image = '<span title="' . $category['name'] . '" style="background:url(' . $src . ') no-repeat;background-size:' . ($size[0]>$size[1] ? '100% auto' : 'auto 100%') . '"></span><br />';
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
</ul>