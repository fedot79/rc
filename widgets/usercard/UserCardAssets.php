<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 14.08.2018
 * Time: 13:28
 */

namespace app\widgets\usercard;


use yii\web\AssetBundle;

class UserCardAssets extends AssetBundle
{
    public $sourcePath = '@app/assets/app';
    public $css = [
                'less/usercard.less',
    ];
    public $js = [
//        'js/jquery.inputmask.bundle.min.js',
//        'js/phones.js',
//        'js/pincode.js',
//        'js/reg.js',
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
    public function publish($am)
    {
        $am->appendTimestamp = true;
        $am->linkAssets = true;
        parent::publish($am);
    }
}