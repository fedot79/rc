<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BrandAsset extends AssetBundle
{
//    public $basePath = '@webroot/assets';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/assets/app/';
    public $css = [
        'less/brand.less'
    ];
    public $js = [
//        'js/iro.min.js',
        'js/colorthief.min.js',
        'js/brand.js'
    ];
    public $depends = [
        AppAsset::class
    ];

    public function publish($am)
    {
        $am->forceCopy = false;
        $am->appendTimestamp = true;
        $am->linkAssets = true;
        parent::publish($am);
    }
}
