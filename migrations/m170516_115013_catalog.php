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
            'image' => $this->string(100)->notNull(),
            'intro_text' => $this->text()->notNull(),
            'full_text' => $this->text()->notNull(),
            'title' => $this->string()->notNull(),
            'keywords' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'not_show_region' => $this->boolean()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(1),
        ]);
        
        $this->createTable('catalog_regions', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'catalog_id' => $this->integer()->notNull(),
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
        
        $this->createIndex('idx-catalog_regions_id', 'catalog_regions', 'catalog_id');
        $this->addForeignKey('catalog_regions_ibfk_1', 'catalog_regions', 'catalog_id', 'catalog', 'id', 'CASCADE');
        
        $this->createTable('catalog_options', [
            'id' => $this->primaryKey(),
            'catalog_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'show_anons' => $this->boolean()->defaultValue(0),
            'show_short' => $this->boolean()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
        
        $this->createIndex('idx-catalog_options_id', 'catalog_options', 'catalog_id');
        $this->addForeignKey('catalog_options_ibfk_1', 'catalog_options', 'catalog_id', 'catalog', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('catalog_regions_ibfk_1', 'catalogRegions');
        $this->dropIndex('idx-catalog_regions_id', 'catalogRegions');
        
        $this->dropForeignKey('catalog_options_ibfk_1', 'catalog_options');
        $this->dropIndex('idx-catalog_options_id', 'catalog_options');
        
        $this->dropTable('catalog_options');
        $this->dropTable('catalog_regions');
        $this->dropTable('catalog');
    }
}