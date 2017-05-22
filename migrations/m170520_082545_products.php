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
            'is_active' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('products');
    }
}