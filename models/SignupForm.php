<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $status;
    public $username;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'match', 'pattern' => '/^(([a-z\(\)\s]+)|([а-яё\(\)\s]+))$/isu'],
            ['username', 'string', 'min' => 3, 'max' => 25],
            ['username', 'trim'],

            [['email', 'status'], 'required'],
            ['email', 'email'],
            [['email'], 'string', 'max' => 100],
            ['email', 'trim'],
            ['email', 'unique', 'targetClass' => User::className(),
                'message' => 'Этот E-mail уже зарегистрирован.'
            ]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'email' => 'E-mail'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $this->status;
            $user->generateAuthKey();
            if ($user->save()) {
                Yii::$app->mailer->compose(['html' => 'newUser-html'], [
                    'user' => $user,
                    'password' => $user->password_hash
                ])
                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                ->setTo($user->email)
                ->setSubject('Регистрация на ' . Yii::$app->name)
                ->send(); 
                return $user;
            }
        }
        return null;
    }
}