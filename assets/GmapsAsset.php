<?php
namespace app\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * SelectMapLocationWidget assets class
 *
 * @author Max Kalyabin <maksim@kalyabin.ru>
 * @package yii2-select-google-map-location
 * @copyright (c) 2015, Max Kalyabin, http://github.com/kalyabin
 */
class GmapsAsset extends AssetBundle
{
    public $css = [
    ];
    public $js = [
//        '//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&sensor=true&language=ru&key=' . Yii::$app->params['gmap_key'];
    ];
    public $depends = [
    ];
    public static function register($view)
    {
        /* @var $view \yii\web\View */
        $view->registerJsFile('//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&language=ru&key=' . Yii::$app->params['gmap_key']);
        return parent::register($view);
    }
}
