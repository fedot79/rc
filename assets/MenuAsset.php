<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 23.08.2018
 * Time: 15:43
 */

namespace app\assets;


use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/menu/';
    public $css = [
        'menu.less'
    ];
    public $js = [
                'menu.js'
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