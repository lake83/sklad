<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\ResetPasswordForm;
use app\models\RemindForm;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use app\models\SignupForm;
use app\components\SiteHelper;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [$this->action->id],
                        'allow' => true,
                        'roles' => ['@', '?']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ]
            ]
        ];
    }
    
    /**
     * Отправка письма для подтверждения E-mail пользователю.
     * 
     * @return string
     */
    public function actionEmailActivate()
    {
        if (Yii::$app->mailer->compose(['html' => 'emailActivation-html'], ['user' => Yii::$app->user->identity])
            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
            ->setTo(Yii::$app->user->email)
            ->setSubject('Подтверждение email на ' . Yii::$app->name)
            ->send()) {
            Yii::$app->session->setFlash('success', 'Письмо для подтверждения E-mail отправлено.');    
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось отправить письмо.');
        }
        return $this->redirect(SiteHelper::redirectByRole(Yii::$app->user->status));
    }
    
    /**
     * Подтверждение E-mail пользователя.
     * 
     * @return string
     * @throws BadRequestHttpException если не удалось
     */
    public function actionEmailConfirmation($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new BadRequestHttpException('Токен не может быть пустым.');
        } else {
            $model = User::findOne(['auth_key' => $token]);
        }
        if (!$model || !$model->validateAuthKey($token)) {
            throw new BadRequestHttpException('Неправильный токен.');
        } else {
            $model->is_active = 1;
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Ваш E-mail подтвержден.');
                return Yii::$app->user->isGuest ? $this->goHome() : $this->redirect(SiteHelper::redirectByRole(Yii::$app->user->status));
            }
        }
    }
    
    /**
     * Запрос на восстановление пароля
     * 
     * @return string
     */
    public function actionRemind()
    {
        $this->layout = '@app/modules/admin/views/layouts/main-login';
        
        $model = new RemindForm;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Инструкции отправлены на Ваш e-mail.');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при отправлении e-mail.');
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('remind', ['model' => $model]);
    }
    
    /**
     * Смена пароля
     * 
     * @param string $token токен для смены пароля
     * @return string
     * @throws BadRequestHttpException если не удалось
     */
    public function actionReset($token)
    {
        $this->layout = '@app/modules/admin/views/layouts/main-login';
        
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');

            return $this->redirect(['admin/user/index']);
        }
        return $this->render('reset', [
            'model' => $model
        ]);
    }
    
    /**
     * Регистрация пользователя.
     */
    public function actionRegistration()
    {
        $model = new SignupForm();
        
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->session->setFlash('success', 'Инструкции по завершению регистрации отправлены на Ваш e-mail.');
                Yii::$app->user->login($user);
                return $this->redirect(SiteHelper::redirectByRole($user->status));
            }
        }
    }
}
?>