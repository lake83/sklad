<?php

use yii\db\Migration;

class m170520_082545_products extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'catalog_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'parent_id' => $this->integer()->notNull(),
            'region' => $this->string(50)->notNull(),
            'image' => $this->string(100)->notNull(),
            'price' => $this->float()->notNull(),
            'currency' => $this->boolean()->defaultValue(1)->comment('1-RUR,2-USD,3-EUR'),
            'not_show_price' => $this->boolean()->defaultValue(0),
            'manufacturer_id' => $this->integer()->notNull(),
            'full_text' => $this->text()->notNull(),
            'title' => $this->string()->notNull(),
            'keywords' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'not_show_region' => $this->boolean()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
        
        $this->createTable('products_options', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'option_id' => $this->integer()->notNull(),
            'value' => $this->string()->notNull()
        ], $tableOptions);
        
        $this->createIndex('idx-products_options_id', 'products_options', 'product_id');
        $this->addForeignKey('products_options_ibfk_1', 'products_options', 'product_id', 'products', 'id', 'CASCADE');
        
        $this->createIndex('idx-catalog_options_id', 'products_options', 'option_id');
        $this->addForeignKey('catalog_options_ibfk_2', 'products_options', 'option_id', 'catalog_options', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('products_options_ibfk_1', 'products_options');
        $this->dropIndex('idx-products_options_id', 'products_options');
        
        $this->dropForeignKey('catalog_options_ibfk_2', 'products_options');
        $this->dropIndex('idx-catalog_options_id', 'products_options');
        
        $this->dropTable('products_options');
        $this->dropTable('products');
    }
}