<?php
namespace app\config;

use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;

class settings implements BootstrapInterface 
{
    private $db;

    public function __construct()
    {
        $this->db = Yii::$app->db;
    }

    /**
    * Bootstrap method to be called during application bootstrap stage.
    * Loads all the settings into the Yii::$app->params array
    * @param Application $app the application currently running
    */
    public function bootstrap($app)
    {
        if (!$settings = Yii::$app->cache->get('settings')) {
            $settings = ArrayHelper::map($this->db->createCommand("SELECT name, value FROM settings")->queryAll(), 'name', 'value');
            Yii::$app->cache->set('settings', $settings, 0, new \yii\caching\TagDependency(['tags' => 'settings']));           
        }
        Yii::$app->params = $settings;
        
        if (!$app instanceof \yii\console\Application) {
            // Установка темы в админке
            Yii::$container->set('dmstr\web\AdminLteAsset', ['skin' => Yii::$app->params['skin']]);
        }
    }
}
?>