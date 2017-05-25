<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%products_brochures}}".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @property string $file
 * @property integer $is_active
 *
 * @property Products $product
 */
class ProductsBrochures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_brochures}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['product_id', 'is_active'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['file'], 'file'],
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
            'file' => 'Файл',
            'is_active' => 'Активно',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $file = UploadedFile::getInstance($this, 'file');
        if ($file) {
            $path = Yii::getAlias('@webroot/files/');
        
            if (!file_exists($path)) {
                mkdir($path);
            }
            $fileName = $file->baseName . '.' . $file->extension;
            $file->saveAs($path . $fileName);
            $this->file = $fileName;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        $filePath = Yii::getAlias('@webroot/files/') . $this->file;
        if (is_file($filePath)) {
            unlink($filePath);
        }
        return parent::afterDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
