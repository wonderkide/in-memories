<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'wonderkide',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'wonder',
    'timeZone' => 'Asia/Bangkok',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qaz]wssx[;.edcpl,rfvokmtgbokmyhniju',
        ],
        'user' => [
            'identityClass' => 'app\models\UserAuth',
            'enableAutoLogin' => true,
            'loginUrl' => ['wonderkide/auth/login'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => FALSE,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'gator3020.hostgator.com',
                'username' => 'noreply@in-memories.com',
                'password' => '8pRfsi=Tbu7m',
                'port' => '465',
                'encryption' => 'ssl',
                ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'view' => [
            'theme' => [
                //'pathMap' => ['@app/views' => '@app/themes/wonderkide/views']
                'pathMap' => ['@app/views' => '@app/themes/brushed/views']
            ],
            'title' => 'What the fuck!!! :: เว็บเหี้ยอะไรว่ะ',
        ],
        'urlManager' => require(__DIR__ . '/url.php'),
        
        'db' => require(__DIR__ . '/db.php'),
        /*'authManager' => [
            'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
        ]*/
        'image' => [  
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ],
        'seo' => [  
            'class' => 'app\components\Seo',
        ],
        'facebook' => [  
            'class' => 'app\components\facebook\facebookAPI',
        ],
    ],
    /*'as access' => [
        'class' => 'app\modules\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],*/
    'aliases' => [
        '@WDAsset' => '@app/themes/wonderkide/assets',
        '@UploadAsset' => '@app/themes/wonderkide/assets/jquery-fileupload',
        '@BEAsset' => '@app/themes/admin/views/layouts',
        '@BRUSHAsset' => '@app/themes/brushed/assets',
        '@WHITEAsset' => '@app/themes/white/assets',
        '@GENAsset' => '@app/themes/gentelella/assets',
    ],
    'modules' => [
        'wonderkide' => [
            'class' => 'app\modules\wonderkide\Module',
            'defaultRoute' => 'main',
            //'layoutPath' => '@app/themes/backend/layouts',
            'layoutPath' => '@app/themes/gentelella/views/layouts',
            'layout' => 'main',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            'downloadAction' => 'gridview/export/download',
            'i18n' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@kvgrid/messages',
                'forceTranslation' => true
            ]
            
        ]
        
    ],
    'params' => $params,
    
    
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
