<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 */
class ContactsAsset extends AssetBundle
{
//    public $basePath = '@webroot/assets';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/assets/app/';
    public $css = [
        'less/contacts.less'
    ];
    public $js = [
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
