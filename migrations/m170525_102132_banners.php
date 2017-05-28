<?php

use yii\db\Migration;

class m170525_102132_banners extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('banners', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'parent_id' => $this->integer()->notNull(),
            'region' => $this->string(50)->notNull(),
            'image' => $this->string(100)->notNull(),
            'link' => $this->string()->notNull(),
            'position' => $this->boolean()->defaultValue(1)->comment('1-Вверху,2-Справа,3-Слева'),
            'not_show_region' => $this->boolean()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('banners');
    }
}