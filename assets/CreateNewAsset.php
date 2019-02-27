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
class CreateNewAsset extends AssetBundle
{
//    public $basePath = '@webroot/assets';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/assets/app/';
    public $css = [
        'less/createnew.less'
    ];
    public $js = [
//        'js/touchwipe.min.js',
        'js/createnew.js'
    ];
    public $depends = [
        AppAsset::class
    ];

    public function publish($am)
    {
        $am->appendTimestamp = true;
        $am->linkAssets = true;
        parent::publish($am);
    }
}
