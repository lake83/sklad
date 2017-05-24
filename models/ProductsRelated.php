<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%products_related}}".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $related_id
 *
 * @property Products $product
 * @property Products $related
 */
class ProductsRelated extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_related}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'related_id'], 'required'],
            [['product_id', 'related_id'], 'integer'],
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
            'product_id' => 'Продукт',
            'related_id' => 'Связаный продукт',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id'])->andWhere(['is_active' => 1])->localized();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelated()
    {
        return $this->hasOne(Products::className(), ['id' => 'related_id'])->andWhere(['is_active' => 1])->localized();
    }
}
