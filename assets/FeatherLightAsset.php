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
class FeatherLightAsset extends AssetBundle
{
//    public $basePath = '@webroot/assets';
    public $sourcePath = '@app/assets/featherlight/';
    public $css = [
        'css/style.css'
    ];
    public $js = [
        'js/script.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function publish($am)
    {
        //        $am->forceCopy = true;
        $am->appendTimestamp = true;
//                $am->linkAssets = false;
        parent::publish($am);
    }
}
