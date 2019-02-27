<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 26.08.2018
 * Time: 18:00
 */

namespace app\widgets\card;


use app\assets\AppAsset;
use yii\web\AssetBundle;

class CardAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/card/';
    public $css = [
        'card.less'
    ];
    public $js = [
        'card.js'
    ];
    public $depends = [
        AppAsset::class,
    ];

    public function publish($am)
    {
        $am->forceCopy = false;
        $am->appendTimestamp = true;
        $am->linkAssets = true;
        parent::publish($am);
    }
}