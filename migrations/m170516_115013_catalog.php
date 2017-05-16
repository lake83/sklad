<?php

use yii\db\Migration;

class m170516_115013_catalog extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('catalog', [
            'id' => $this->primaryKey(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'parent_id' => $this->integer()->notNull(),
            'region' => $this->string(50)->notNull(),
            'image' => $this->string(100)->notNull(),
            'intro_text' => $this->text()->notNull(),
            'full_text' => $this->text()->notNull(),
            'title' => $this->string()->notNull(),
            'keywords' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'not_show_region' => $this->boolean()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(1),
        ]);
    }

    public function down()
    {
        $this->dropTable('catalog');
    }
}
