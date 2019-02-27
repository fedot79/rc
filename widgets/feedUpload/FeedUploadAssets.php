<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 21.09.2018
 * Time: 12:24
 */

namespace app\widgets\feedUpload;


use app\assets\AppAsset;
use yii\web\AssetBundle;

class FeedUploadAssets extends AssetBundle
{
    public $sourcePath = '@app/assets/app/';
    public $css = [
        'less/feed.less'
    ];
    public $js = [
        'js/feed.js'
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