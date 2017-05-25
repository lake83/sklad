<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class RecallForm extends Model
{
    public $fio;
    public $phone;
    public $catalog_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio', 'phone'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['fio', 'phone'], 'string'],
            [['catalog_id'], 'integer'],
            // verifyCode needs to be entered correctly
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'ФИО',
            'phone' => 'Телефон',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($to)
    {
        return Yii::$app->mailer->compose()
            ->setTo($to)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject('Заказ обратного звонка связь')
            ->setTextBody('Фио: '.$this->fio.' Телефон: '.$this->phone . ' Каталог: ' . Catalog::findOne($this->catalog_id)->name)
            ->send();
    }
}
