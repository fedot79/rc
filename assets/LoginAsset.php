<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 11.07.2018
 * Time: 14:39
 */

namespace app\assets;


use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/assets/login';
    public $css = [
        'less/login.less',
    ];
    public $js = [
        'js/jquery.inputmask.bundle.min.js',
        'js/phones.js',
        'js/pincode.js',
//        'js/pretty-dropdown.js',
        'js/login.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public function publish($am)
    {
        $am->forceCopy = true;
        $am->appendTimestamp = true;
        $am->linkAssets = false;
        parent::publish($am); // TODO: Change the autogenerated stub
    }
}