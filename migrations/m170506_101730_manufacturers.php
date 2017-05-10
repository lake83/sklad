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
            'brand' => $this->string(100)->notNull(),
            'image' => $this->string(100)->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'intro_text' => $this->text()->notNull(),
            'full_text' => $this->text()->notNull(),
            'title' => $this->string()->notNull(),
            'keywords' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('manufacturers');
    }
}