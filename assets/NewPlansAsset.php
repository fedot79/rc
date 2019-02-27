<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 11.01.2019
 * Time: 18:04
 */

namespace app\assets;


use yii\web\AssetBundle;

class NewPlansAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/app/';
    public $css = [
        'less/plans.less'
    ];
    public $js = [
        'js/plans.js'
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