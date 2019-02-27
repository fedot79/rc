<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 24.09.2018
 * Time: 16:34
 */

namespace app\assets;


use yii\web\AssetBundle;

class FeedCheckAssets extends AssetBundle
{
    public $sourcePath = '@app/assets/app/';
    public $css = [
        'less/feed-check.less'
    ];
    public $js = [
//        'js/slider.min.js'
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