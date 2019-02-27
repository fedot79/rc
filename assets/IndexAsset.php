<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 11.01.2019
 * Time: 18:04
 */

namespace app\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class IndexAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/app/';
    public $css = [
        '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css',
        'less/index.less'
    ];
    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.9/typed.min.js',
        'js/index.js'
    ];
    public $depends = [
//        AppAsset::class
        JqueryAsset::class
    ];

    public function publish($am)
    {
        $am->appendTimestamp = true;
        $am->linkAssets = true;
        parent::publish($am);
    }
}