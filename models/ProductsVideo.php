<?php

namespace app\models;

use Yii;
use app\components\LogBehavior;

/**
 * This is the model class for table "{{%products_video}}".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @property string $link
 * @property integer $is_active
 *
 * @property Products $product
 */
class ProductsVideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_video}}';
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
            [['link'], 'required'],
            [['product_id', 'is_active'], 'integer'],
            [['name', 'link'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'name' => 'Название',
            'link' => 'Вставка Youtube',
            'is_active' => 'Активно',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
