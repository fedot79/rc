<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 */
class TariffAsset extends AssetBundle
{
//    public $basePath = '@webroot/assets';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/assets/tariff/';
    public $css = [
        'tariff.less'
    ];
    public $js = [
//        'review.js'
    ];
    public $depends = [
        AppAsset::class
    ];

    public function publish($am)
    {
//        $am->forceCopy = true;
        $am->appendTimestamp = true;
        $am->linkAssets = true;
        parent::publish($am);
    }
}
