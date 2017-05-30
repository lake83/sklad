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
                'lng' => '37.6155',
                'lat' => '55.7522',
                'phone' => '+7 (495) 646-8227',
                'address' => 'ул. Краснобогатырская, д.2, стр.2',
                'email' => 'zapros@maxi-sklad.ru'
            ],
            [
                'name' => 'Санкт-Петербург',
                'subdomain' => 'spb',
                'lng' => '30.3141',
                'lat' => '59.9386',
                'phone' => '',
                'address' => 'ул. Воронежская, 5',
                'email' => 'spb@maxi-sklad.ru'
            ],
            [
                'name' => 'Волгоград',
                'subdomain' => 'volgograd',
                'lng' => '44.5018',
                'lat' => '48.7193',
                'phone' => '',
                'address' => 'ул. им. Ткачева, 20Б',
                'email' => 'volgograd@maxi-sklad.ru'
            ],
            [
                'name' => 'Екатеринбург',
                'subdomain' => 'ekb',
                'lng' => '60.6122',
                'lat' => '56.8519',
                'phone' => '',
                'address' => 'ул. Хохрякова, 10',
                'email' => 'ekb@maxi-sklad.ru'
            ],
            [
                'name' => 'Новгород',
                'subdomain' => 'novgorod',
                'lng' => '58.5213',
                'lat' => '31.2710',
                'phone' => '',
                'address' => 'ул. М. Горького, 117',
                'email' => 'novgorod@maxi-sklad.ru'
            ],
            [
                'name' => 'Ростов',
                'subdomain' => 'rostov',
                'lng' => '47.2313',
                'lat' => '39.7232',
                'phone' => '',
                'address' => 'ул. Суворова, 93',
                'email' => 'rostov@maxi-sklad.ru'
            ],
            [
                'name' => 'Самара',
                'subdomain' => 'samara',
                'lng' => '53.2000',
                'lat' => '50.1500',
                'phone' => '',
                'address' => 'ул. Мичурина, 78',
                'email' => 'samara@maxi-sklad.ru'
            ]
        ];
        Yii::$app->db->createCommand()->batchInsert('regions', array_keys($regions[0]), $regions)->execute();
    }

    public function down()
    {
        $this->dropTable('regions');
    }
}