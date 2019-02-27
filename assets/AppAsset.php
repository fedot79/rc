<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 */
class AppAsset extends AssetBundle
{
//    public $basePath = '@webroot/assets';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/assets/app/';
    public $css = [

        '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css',
        'less/main.less'
    ];
    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js',
//        '//cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.2/mobile-detect.min.js',
//        'js/defect.js',
        'js/svgxuse.js',
        'js/script.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function publish($am)
    {
        if(YII_ENV_DEV)
        {
            $this->js = [
                '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js',
//                '//cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.2/mobile-detect.min.js',
//                'js/defect.js',
                'js/svgxuse.js',
                'js/script.js'
            ];
        }
//        if()

//        if($_SERVER['REMOTE_ADDR']=='188.242.209.203')
//        {
//            $this->js = [
//                '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js',
//                '//cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.2/mobile-detect.min.js',
////                'js/defect.js',
//                //        'js/highlite.js',
//                'js/highlite3.js',
//                'js/help.js'
//            ];
//        }
        $am->forceCopy = false;
        $am->appendTimestamp = true;
        $am->linkAssets = true;
        parent::publish($am);
    }
}
