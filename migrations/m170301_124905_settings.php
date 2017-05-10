<?php

use yii\db\Migration;

class m170301_124905_settings extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('settings', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'value' => $this->text()->notNull(),
            'label' => $this->string(100)->notNull(),
            'icon' => $this->string(50)->notNull(),
            'rules' => $this->string(50)->notNull(),
            'hint' => $this->string()->notNull()
        ], $tableOptions);
        
        $settings = [
            [
                'name' => 'adminEmail',
                'value' => 'admin@example.com',
                'label' => 'E-mail администратора',
                'icon' => 'fa-envelope-o',
                'rules' => 'email',
                'hint' => 'Используется для связи с администратором сайта.'
            ],
            [
                'name' => 'user.passwordResetTokenExpire',
                'value' => '86400',
                'label' => 'Время на восстановление пароля (сек.)',
                'icon' => 'fa-clock-o',
                'rules' => 'integer',
                'hint' => 'По истечении указанного срока запрос на смену пароля становится не действительным.'
            ],
            [
                'name' => 'skin',
                'value' => 'skin-green',
                'label' => 'Тема админ панели',
                'icon' => 'fa-paint-brush',
                'rules' => 'safe',
                'hint' => 'Цветовое оформление. Варианты: skin-blue, skin-black, skin-red, skin-yellow, skin-purple, skin-green, skin-blue-light, skin-black-light, skin-red-light, skin-yellow-light, skin-purple-light, skin-green-light'
            ],
            [
                'name' => 'phone_mask',
                'value' => '+7 (999) 999-9999',
                'label' => 'Шаблон телефона',
                'icon' => 'fa-phone',
                'rules' => 'safe',
                'hint' => 'Маска телефона используемая в формах.'
            ]
        ];
        Yii::$app->db->createCommand()->batchInsert('settings', array_keys($settings[0]), $settings)->execute();
    }
    
    public function safeDown()
    {
        $this->dropTable('settings');        
    }
}
