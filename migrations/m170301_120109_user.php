<?php

use yii\db\Migration;

class m170301_120109_user extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->defaultValue(null),
            'email' => $this->string(100)->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(20)->comment('10-администратор,20-пользователь'),
            'is_active' => $this->boolean()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);
        
        $this->insert('user', [
            'username' => 'admin',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'password_reset_token' => null,
            'email' => 'lake83@mail.ru',
            'status' => 10,
            'is_active' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }
    
    public function safeDown()
    {
        $this->dropTable('user');               
    }
}
