<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image_to_banner".
 *
 * @property integer $id
 * @property string $image
 * @property integer $banner_id
 *
 * @property Banners $banner
 */
class ImageToBanner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image_to_banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image', 'banner_id'], 'required'],
            [['banner_id'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['banner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Banner::className(), 'targetAttribute' => ['banner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'banner_id' => 'Banner ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banners::className(), ['id' => 'banner_id']);
    }
}
