<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 11.01.2019
 * Time: 18:04
 */

namespace app\assets;


use yii\web\AssetBundle;

class PaymentAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/app/';
    public $css = [
        'less/payment.less'
    ];
    public $js = [
        'js/payment.js'
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