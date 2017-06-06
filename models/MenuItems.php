<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;
use app\components\LogBehavior;

/**
 * This is the model class for table "{{%menu_items}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $menu_id
 * @property integer $parent_id
 * @property integer $type
 * @property string $value
 * @property integer $position
 * @property integer $is_active
 *
 * @property Menu $menu
 */
class MenuItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_items}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            LogBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'menu_id', 'type', 'value'], 'required'],
            [['menu_id', 'parent_id', 'type', 'position', 'is_active'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255],
            [['parent_id', 'position'], 'default', 'value' => 0],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'menu_id' => 'Меню',
            'parent_id' => 'Родитель',
            'type' => 'Тип',
            'value' => 'Значение',
            'position' => 'Позиция',
            'is_active' => 'Активно',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, 'menu');
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        TagDependency::invalidate(Yii::$app->cache, 'menu');
        
        parent::afterDelete();
    }
    
    /**
     * Список пунктов меню
     * @param integer $menu_id ID меню
     * @return array 
     */
    public static function getAll($menu_id = null)
    {
        return ArrayHelper::map(self::find()->where(['is_active' => 1] + (!is_null($menu_id) ? ['menu_id' => $menu_id] : []))->all(), 'id', 'name');
    }
    
    /**
     * Возвращает список типов пунктов меню или название типа
     * 
     * @param integer $key ключ в массиве названий
     * @return mixed
     */
    public static function getTypes($key = null)
    {
        $type = [1 => 'Страница', 2 => 'Файл', 3 => 'Ссылка'];
        return is_null($key) ? $type : $type[$key];
    }
}