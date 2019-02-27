<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'reconnect',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
            'linkAssets' => true,
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'less' => ['css','lessc {from} {to} --no-color --source-map={to}.map'],
                    'ts' => ['js','tsc --out {to} {from}'],
                    'scss' => ['css', '{from} {to}'],



                ],
                'forceConvert' => true
            ],
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 		'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ]
            ],
        ],
        'authManager' => [
            'class' => 'Da\User\Component\AuthDbManagerComponent',
            'cache' => 'cache'
        ],
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'b45cffe084dd3d20d928bee85e7b0f21',
            'baseUrl'=>'',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'mailer' => [
//            'class' => 'boundstate\mailgun\Mailer',
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'maxFileSize' => 100,
                    'maxLogFiles' => 100,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,

            'rules' => [
                'logout' => 'user/security/logout',
                'login' => 'user/security/login',
                'user/<id:\d+>' => 'user/profile/show',
                'user/<action:(login|logout|check)>' => 'user/security/<action>',
                'user/<action:(register|resend|confirm)>' => 'user/registration/<action>',
                'user/forgot' => 'user/recovery/request',
                'user/recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'user/recovery/reset',
                '<action>' => 'site/<action>',
                '<module>/<controller>/<action>' => '<module>/<controller>/<action>'
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@Da/User/resources/views' => '@app/views/user'
                ],
            ]
        ]
    ],
    'modules' => [
        'user' => [
            'class' => Da\User\Module::class,
            'administratorPermissionName'=>'admin',
            'classMap' => [
                'User' => \app\models\UserModel::class,
//                'Profile' => \app\models\Profile::class,
                'LoginForm' => \app\models\LoginForm::class,
                'ResendForm' => \app\models\ResendForm::class,
                'RegistrationForm' => \app\models\RegistrationForm::class,
//                'ConfirmForm'=> \app\models\ConfirmForm::class
            ],
            'controllerMap' => [
                'security' => \app\controllers\SecurityController::class,
                'registration' => \app\controllers\RegistrationController::class,
                'admin' => \app\controllers\AdminController::class
            ],
            'routes' => []
        ],
    ],
    'params' => $params,
];

if (YII_ENV_TEST || YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '95.161.202.86'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
