<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use app\assets\app\PhoneInputAsset;
use yii\web\AssetBundle;

/**
 */
class SettingsAsset extends AssetBundle
{
//    public $basePath = '@webroot/assets';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/assets/app/';
    public $css = [
        'less/settings.less'
    ];
    public $js = [
        'js/jquery.inputmask.bundle.min.js',
        'js/settings.js',
    ];
    public $depends = [
        AppAsset::class,
        PhoneInputAsset::class
//        LoginAsset::class
    ];

    public function publish($am)
    {
        $am->forceCopy = false;
        $am->appendTimestamp = true;
        $am->linkAssets = true;
        parent::publish($am);
    }
}
