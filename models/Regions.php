<?php

namespace app\models;

use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%regions}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $subdomain
 * @property double $lng
 * @property double $lat
 * @property string $phone
 * @property integer $is_active
 * @property string $address
 * @property string $email
 */
class Regions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%regions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'subdomain', 'address', 'email'], 'required'],
            [['lng', 'lat'], 'number'],
            ['phone', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/'],
            [['is_active'], 'integer'],
            [['name', 'email'], 'string', 'max' => 100],
            [['subdomain'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
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
            'subdomain' => 'Название поддомена',
            'lng' => 'Долгота',
            'lat' => 'Широта',
            'phone' => 'Номер телефона',
            'is_active' => 'Активно',
            'address' => 'Адрес',
            'email' => 'Email',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, 'regions');
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        TagDependency::invalidate(Yii::$app->cache, 'regions');
        
        parent::afterDelete();
    }
    
    /**
     * Список регионов
     * 
     * @return array
     */
    public static function getRegions()
    {
        $db = Yii::$app->db;
        return $db->cache(function ($db) {
            return ArrayHelper::map(self::find()->where(['is_active' => 1])->asArray()->all(), 'subdomain', function($model) {return $model;});
        }, 0, new TagDependency(['tags' => 'regions']));
    }
}
