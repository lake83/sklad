<?php
if (substr_count($_SERVER['SERVER_NAME'], '.') > 1) {
    $host = explode('.', $_SERVER['SERVER_NAME']);
    array_shift($host);
    define('DOMAIN', implode('.', $host));
} else {
    define('DOMAIN', $_SERVER['SERVER_NAME']);
}
$config = [
    'id' => 'basic',
    'name' => 'MaxiSklad',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['app\config\settings'],
    'language' => 'ru',
    'sourceLanguage' => 'ru',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'BpFsddFeU0Qaf9oYQ6Fv80iLa9ebcndv',
            'baseUrl' => ''
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\components\User',
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['admin']
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'plugins' => [
                    [
                        'class' => 'Swift_Plugins_ThrottlerPlugin',
                        'constructArgs' => [20]
                    ]     
                ]
            ]
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '/',
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer'
            ],
            'rules' => [
                ['class' => 'app\components\UrlRule'],
                'admin' => 'site/admin',
                '/clients' => 'materials/clients',
                '/about/nashi_postavchshiki' => 'materials/postavchshiki',
                '/press-centr/news' => 'materials/news',
                '/press-centr/stati' => 'materials/articles',
                '/<alias>' => 'materials/page',
                '/nashi_postavchshiki/<alias>' => 'materials/postavchshiki-view',
                '/<_a:(stati|news|clients)>/<alias>' => 'materials/materials-view',
                
                '/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '/<action:\w+>/<id:\d+>' => 'site/<action>',
                '' => 'site/index'
            ]

        ],
        'formatter' => [
            'timeZone' => 'Europe/Moscow'
        ]     
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module'
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
                'generators' => [
            'controller'   => [
                'class'     => 'yii\gii\generators\controller\Generator',
                'templates' => [
                    'actions' => '@app/components/gii/controller'
                ]
            ],
            'crud'   => [
                'class'     => 'yii\gii\generators\crud\Generator',
                'templates' => ['actions' => '@app/components/gii/crud']
            ]
        ]
    ];
}

return $config;