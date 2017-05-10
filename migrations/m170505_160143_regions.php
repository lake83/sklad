<?php

use yii\db\Migration;

class m170505_160143_regions extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('regions', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'subdomain' => $this->string(50)->notNull(),
            'lng' => $this->float()->notNull(),
            'lat' => $this->float()->notNull(),
            'phone' => $this->string(20)->notNull(),
            'is_active' => $this->boolean()->defaultValue(1),
            'address' => $this->string()->notNull(),
            'email' => $this->string(100)->notNull()
        ], $tableOptions);
        
        $regions = [
            [
                'name' => 'Москва',
                'subdomain' => '',
                'lng' => '55.755833',
                'lat' => '37.617778',
                'phone' => '+7 (495) 646-8227',
                'address' => 'ул. Краснобогатырская, д.2, стр.2',
                'email' => 'zapros@maxi-sklad.ru'
            ],
            [
                'name' => 'Ростов',
                'subdomain' => 'rostov',
                'lng' => '47.240556',
                'lat' => '39.710556',
                'phone' => '',
                'address' => 'ул. Суворова, 93',
                'email' => 'rostov@maxi-sklad.ru'
            ],
            [
                'name' => 'Екатеринбург',
                'subdomain' => 'ekb',
                'lng' => '56.833333',
                'lat' => '60.583333',
                'phone' => '',
                'address' => 'ул. Хохрякова, 10',
                'email' => 'ekb@maxi-sklad.ru'
            ],
            [
                'name' => 'Новгород',
                'subdomain' => 'novgorod',
                'lng' => '58.525',
                'lat' => '31.275',
                'phone' => '',
                'address' => 'ул. М. Горького, 117',
                'email' => 'novgorod@maxi-sklad.ru'
            ],
            [
                'name' => 'Самара',
                'subdomain' => 'samara',
                'lng' => '53.183333',
                'lat' => '50.116667',
                'phone' => '',
                'address' => 'ул. Мичурина, 78',
                'email' => 'samara@maxi-sklad.ru'
            ],
            [
                'name' => 'Санкт-Петербург',
                'subdomain' => 'spb',
                'lng' => '59.95',
                'lat' => '30.316667',
                'phone' => '',
                'address' => 'ул. Воронежская, 5',
                'email' => 'spb@maxi-sklad.ru'
            ],
            [
                'name' => 'Волгоград',
                'subdomain' => 'volgograd',
                'lng' => '48.699167',
                'lat' => '44.473333',
                'phone' => '',
                'address' => 'ул. им. Ткачева, 20Б',
                'email' => 'volgograd@maxi-sklad.ru'
            ]
        ];
        Yii::$app->db->createCommand()->batchInsert('regions', array_keys($regions[0]), $regions)->execute();
    }

    public function down()
    {
        $this->dropTable('regions');
    }
}