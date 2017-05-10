<?php
namespace app\components;

use yii\web\UrlRuleInterface;
use yii\base\Object;
use app\models\Materials;
 
class UrlRule extends Object implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'materials/page') {
            if (isset($params['alias'])) {
                return $params['alias'] . '/';
            }
        }
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = trim($request->getPathInfo(), '/');
        if (strpos($pathInfo, '/') !== false && Materials::find()->where(['slug' => $pathInfo, 'is_active' => 1])->exists()) {
            $params['alias'] = $pathInfo;
            return ['materials/page', $params];
        }
        return false;
    }
}