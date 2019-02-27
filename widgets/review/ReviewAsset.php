<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 11.07.2018
 * Time: 14:39
 */

namespace app\widgets\review;


use app\assets\AppAsset;
use app\assets\FeatherLightAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class ReviewAsset extends AssetBundle
{
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/widgets/review/assets';
    public $css = [
        'review.less',
    ];
    public $js = [
        'review.js'
    ];
    public $depends = [
        FeatherLightAsset::class,
        AppAsset::class
    ];
    public function publish($am)
    {
//                $am->forceCopy = true;
        $am->appendTimestamp = true;
//                $am->linkAssets = true;
        parent::publish($am);
    }
}