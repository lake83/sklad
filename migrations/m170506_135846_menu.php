<?php

use yii\db\Migration;

class m170506_135846_menu extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
        
        $this->createTable('menu_items', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'menu_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->defaultValue(0),
            'type' => $this->boolean()->defaultValue(1)->comment('1-Страница,2-Файл,3-Ссылка'),
            'value' => $this->string()->notNull(),
            'position' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
        
        $this->createIndex('idx-menu_id', 'menu_items', 'menu_id');
        $this->addForeignKey('menu_items_ibfk_1', 'menu_items', 'menu_id', 'menu', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('menu_items_ibfk_1', 'menu_items');
        $this->dropIndex('idx-menu_id', 'menu_items');
        
        $this->dropTable('menu');
        $this->dropTable('menu_items');
    }
}