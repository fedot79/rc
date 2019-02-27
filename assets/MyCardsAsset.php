<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 13.01.2019
 * Time: 23:54
 */

namespace app\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MyCardsAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/app/';
    public $css = [
        'less/mycards.less'
    ];
    public $js = [
        'js/mycards.js'
    ];
    public $depends = [
        JqueryAsset::class
    ];

    public function publish($am)
    {
        $am->appendTimestamp = true;
        $am->linkAssets = true;
        parent::publish($am);
    }
}