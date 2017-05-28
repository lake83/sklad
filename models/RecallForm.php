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
            ['fio', 'match', 'pattern' => '/^(([a-z\(\)\s]+)|([а-яё\(\)\s]+))$/isu'],
            ['phone', 'string', 'max' => 20],
            ['phone', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/'],
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
     * @param  string  $url страница (URL) с которой было отправлено сообщение
     * @return boolean whether the email was sent
     */
    public function sendEmail($to, $url)
    {
        return Yii::$app->mailer->compose(['html' => 'recall-html'], ['model' => $this, 'url' => $url])
            ->setTo($to)
            ->setBcc('support@astonia.ru')
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject('Заказ обратного звонка на сайте' . Yii::$app->name)
            ->send();
    }
}