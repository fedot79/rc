<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 11.12.2018
 * Time: 10:08
 */

namespace app\components;


use Yii;

/**
 * Class TrackingController
 *
 * @property string $queryParam
 * @property string $sessionParam
 * @property string $trackingParam
 */
class TrackingController extends \yii\base\Behavior
{

    public $queryParam;
    public $sessionParam;

    public function events()
    {
        return [
            \yii\web\Controller::EVENT_BEFORE_ACTION => 'updateTrackingParam',
        ];
    }

    /**
     * @param string|null $defaultValue
     * @return string|null
     */
    public function getTrackingParam($defaultValue = null)
    {
        return \Yii::$app->session->get($this->sessionParam, $defaultValue);
    }

    /**
     * @return string|null
     */
    public function updateTrackingParam()
    {
//        Yii::info('update tracking param '.$this->queryParam);
//        Yii::info(var_export(Yii::$app->request, true));
        if ($value = \Yii::$app->request->get($this->queryParam))
        {
            \Yii::$app->session->set($this->sessionParam, $value);
//            Yii::info('save tracking param '.$value);
        }
    }
}