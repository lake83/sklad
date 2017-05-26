<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class HaveQuestionForm extends Model
{
    public $fio;
    public $email;
    public $phone;
    public $catalog_id;
    public $question;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'phone'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['fio', 'phone', 'question'], 'string'],
            [['catalog_id'], 'integer'],
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
     * @param  string  $to the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($to)
    {
        return Yii::$app->mailer->compose()
            ->setTo($to)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject('Запрос с формы - У Вас есть вопрос?')
            ->setTextBody("
                ФИО: {$this->fio}
                Телефон: {$this->phone}
                Каталог: " . Catalog::findOne($this->catalog_id)->name . "
                Email: {$this->email}
                Вопрос: {$this->question}
            ")
            ->send();
    }
}
