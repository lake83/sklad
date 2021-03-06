<?php

use yii\db\Migration;

class m170506_124205_materials extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('materials', [
            'id' => $this->primaryKey(),
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
            'type' => $this->boolean()->defaultValue(1)->comment('1-Новость,2-Статья,3-Страница,4-Клиент'),
            'in_slider' => $this->boolean()->defaultValue(0),
            'not_show_region' => $this->boolean()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('materials');
    }
}
