<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property integer $id
 * @property string $controller
 * @property string $action
 * @property integer $target_id
 * @property integer $user_id
 * @property integer $created_at
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller', 'action', 'user_id'], 'required'],
            [['user_id', 'target_id', 'created_at'], 'integer'],
            [['controller'], 'string', 'max' => 50],
            [['action'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'controller' => 'Контроллер',
            'action' => 'Действие',
            'user_id' => 'Пользователь',
            'target_id' => 'ID элемента',
            'created_at' => 'Дата',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * Возвращает виды действий или название действия
     * 
     * @param integer $key ключ в массиве названий
     * @return mixed
     */
    public static function getActions($key = null)
    {
        $actions = ['insert' => 'Создание', 'update' => 'Редактирование', 'delete' => 'Удаление'];
        return is_null($key) ? $actions : $actions[$key];
    }
}