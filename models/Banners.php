<?php

namespace app\models;

use Yii;
use app\components\LocalizedActiveRecord;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%banners}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $region
 * @property string $image
 * @property string $link
 * @property integer $position
 * @property integer $not_show_region
 * @property integer $is_active
 */
class Banners extends LocalizedActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banners}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'position'], 'required'],
            [['parent_id', 'position', 'not_show_region', 'is_active'], 'integer'],
            [['name', 'link'], 'string', 'max' => 255],
            [['region'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 100],
            ['link', 'url']
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
            'parent_id' => 'Родитель',
            'region' => 'Регион',
            'image' => 'Изображение',
            'link' => 'Ссилка',
            'position' => 'Позиция',
            'not_show_region' => 'Не выводить для региона',
            'is_active' => 'Активно',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, 'banners');
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        TagDependency::invalidate(Yii::$app->cache, 'banners');
        
        self::deleteAll(['parent_id' => $this->id]);
        self::deleteAll(['name' => '', 'image' => '', 'link' => '', 'not_show_region' => 0]);
        
        parent::afterDelete();
    }
    
    /**
     * Возвращает позицию баннера или название позиции
     * 
     * @param integer $key ключ в массиве названий
     * @return mixed
     */
    public static function getPositions($key = null)
    {
        $position = [1 => 'Вверху', 2 => 'Справа', 3 => 'Слева'];
        return is_null($key) ? $position : $position[$key];
    }
    
    /**
     * Данные для вывода баннеров
     * 
     * @param integer $position позиция
     * @return array
     */
    public static function getBanners($position)
    {
        $db = Yii::$app->db;
        return $db->cache(function ($db) use ($position) {
            return self::find()->where(['position' => $position, 'is_active' => 1])->localized()->asArray()->all();
        }, 0, new TagDependency(['tags' => 'banners']));
    }
}