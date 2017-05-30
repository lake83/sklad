git <?php

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
        
        $this->createTable('products_related', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'related_id' => $this->integer()->notNull()
        ], $tableOptions);
        
        /*$this->createTable('products_gallery', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'image' => $this->string(100)->notNull(),
            'position' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);*/
        
        $this->createTable('products_video', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'link' => $this->string()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
        
        $this->createTable('products_brochures', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'file' => $this->string(100)->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
        
        $this->createIndex('idx-products_options_id', 'products_options', 'product_id');
        $this->addForeignKey('products_options_ibfk_1', 'products_options', 'product_id', 'products', 'id', 'CASCADE');
        
        $this->createIndex('idx-catalog_options_id', 'products_options', 'option_id');
        $this->addForeignKey('catalog_options_ibfk_2', 'products_options', 'option_id', 'catalog_options', 'id', 'CASCADE');
        
        $this->createIndex('idx-products_related_id', 'products_related', 'product_id');
        $this->addForeignKey('products_related_ibfk_3', 'products_related', 'product_id', 'products', 'id', 'CASCADE');
        
        $this->createIndex('idx-products_related_id_1', 'products_related', 'related_id');
        $this->addForeignKey('products_related_ibfk_4', 'products_related', 'related_id', 'products', 'id', 'CASCADE');
        
        /*$this->createIndex('idx-products_gallery_id', 'products_gallery', 'product_id');
        $this->addForeignKey('products_gallery_ibfk_5', 'products_gallery', 'product_id', 'products', 'id', 'CASCADE');*/
        
        $this->createIndex('idx-products_video_id', 'products_video', 'product_id');
        $this->addForeignKey('products_video_ibfk_6', 'products_video', 'product_id', 'products', 'id', 'CASCADE');
        
        $this->createIndex('idx-products_brochures_id', 'products_brochures', 'product_id');
        $this->addForeignKey('products_brochures_ibfk_7', 'products_brochures', 'product_id', 'products', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('products_options_ibfk_1', 'products_options');
        $this->dropIndex('idx-products_options_id', 'products_options');
        
        $this->dropForeignKey('catalog_options_ibfk_2', 'products_options');
        $this->dropIndex('idx-catalog_options_id', 'products_options');
        
        $this->dropForeignKey('products_related_ibfk_3', 'products_related');
        $this->dropIndex('idx-products_related_id', 'products_related');
        
        $this->dropForeignKey('products_related_ibfk_4', 'products_related');
        $this->dropIndex('idx-products_related_id_1', 'products_related');
        
        /*$this->dropForeignKey('products_gallery_ibfk_5', 'products_gallery');
        $this->dropIndex('idx-products_gallery_id', 'products_gallery');*/
        
        $this->dropForeignKey('products_video_ibfk_6', 'products_video');
        $this->dropIndex('idx-products_video_id', 'products_video');
        
        $this->dropForeignKey('products_brochures_ibfk_7', 'products_brochures');
        $this->dropIndex('idx-products_brochures_id', 'products_brochures');
        
        $this->dropTable('products_brochures');
        $this->dropTable('products_video');
        /*$this->dropTable('products_gallery');*/
        $this->dropTable('products_related');
        $this->dropTable('products_options');
        $this->dropTable('products');
    }
}