<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 13.01.2019
 * Time: 23:54
 */

namespace app\assets;


use yii\web\AssetBundle;

class NegoAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/app/';
    public $css = [
        'less/nego.less'
    ];
    public $js = [
        'js/nego.js'
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