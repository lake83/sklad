<?php

use yii\db\Migration;

class m170506_101730_manufacturers extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('manufacturers', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->notNull(),
            'description' => $this->text()->notNull(),
            'title' => $this->string()->notNull(),
            'keywords' => $this->string()->notNull(),
            'meta_description' => $this->text()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('manufacturers');
    }
}
