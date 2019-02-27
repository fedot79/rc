<?php

// comment out the following two lines when deployed to production


//if((array_key_exists('ENV', $_SERVER) && $_SERVER['ENV']=='dev'))
//{
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
//}


//if(!in_array($_SERVER['REMOTE_ADDR'], ['95.161.202.86', '188.242.209.203', '213.110.201.61']))
//    die();


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';



(new yii\web\Application($config))->run();
