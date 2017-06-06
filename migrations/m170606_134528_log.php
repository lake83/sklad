<?php

use yii\db\Migration;

class m170606_134528_log extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('log', [
            'id' => $this->primaryKey(),
            'controller' => $this->string(50)->notNull(),
            'action' => $this->string(20)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'target_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('log');
    }
}