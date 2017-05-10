<?php 
namespace app\modules\admin\controllers\actions;

use Yii;

class Update extends \yii\base\Action
{
    use ActionsTraite;
    
    public $model;
    public $redirect = ['index'];
    
    public function run()
    {
        return $this->actionBody($this->model, Yii::t('app', 'Изменения сохранены.'), 'update', $this->redirect);
    }
} 
?>