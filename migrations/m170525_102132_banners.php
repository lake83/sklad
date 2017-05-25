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
            'link' => $this->string()->defaultValue(null),
            'position' => $this->string()->notNull(),
            'width' => $this->integer()->notNull(),
            'height' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)
        ], $tableOptions);

        $this->createTable('image_to_banner', [
            'id' => $this->primaryKey(),
            'image' => $this->string()->notNull(),
            'banner_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-image_to_banner', 'image_to_banner', 'banner_id');
        $this->addForeignKey('banners_ibfk_1', 'image_to_banner', 'banner_id', 'banners', 'id', 'CASCADE');

    }

    public function down() {
        $this->dropForeignKey('banners_ibfk_1', 'image_to_banner');

        $this->dropTable('image_to_banner');
        $this->dropTable('banners');

        return false;
    }
}
