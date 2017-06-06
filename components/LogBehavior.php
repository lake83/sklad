<?php

/**
 * Логирование действий в админ панели
 */
namespace app\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\Log;

class LogBehavior extends Behavior
{
    const SCENARIO_INSERT = 'insert';
	const SCENARIO_UPDATE = 'update';
	const SCENARIO_DELETE = 'delete';
	
	public function events()
    {
		parent::events();
		
		return [
			ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
			ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
			ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
		];
	}
    
    public function afterInsert($event)
	{
		$this->processLogging(self::SCENARIO_INSERT);
	}
	
	public function afterUpdate($event)
	{
		$this->processLogging(self::SCENARIO_UPDATE);
	}
	
	public function afterDelete($event)
	{
		$this->processLogging(self::SCENARIO_DELETE);
	}
    
    private function processLogging($scenario)
	{
		$model = new Log;
        $model->controller = Yii::$app->requestedRoute;
        $model->action = $scenario;
        $model->user_id = Yii::$app->user->id;
        $model->target_id = $this->owner->getPrimaryKey();
        $model->created_at = time();
        $model->save();
	}
}
?>