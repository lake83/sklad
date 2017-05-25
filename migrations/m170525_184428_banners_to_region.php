<?php

use yii\db\Migration;

class m170525_184428_banners_to_region extends Migration
{
    public function up()
    {
        $this->addColumn('banners', 'not_show_in_regions', $this->text()->defaultValue(null));
    }

    public function down()
    {
        echo "m170525_184428_banners_to_region cannot be reverted.\n";
        $this->dropColumn('banners', 'not_show_in_regions');
        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
