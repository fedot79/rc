<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 30.08.2018
 * Time: 12:29
 */

namespace app\widgets\topmenu;


use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class TopMenuWidget extends Widget
{
    private static $urls = [
        '/tariff/default/tariff'=>'Тарифы',
//        '/user/security/login'=>'Login',
        '/site/contacts'=>'Контакты',
        '/site/user-agreement'=>'Пользовательское соглашение',
        '/site/privacy-policy'=>'Политика конфиденциальности',
        '/pdf/offer.pdf'=>'Договор оферты'
    ];

    public function run()
    {
        $current_url = '/'.Yii::$app->requestedRoute;
        return $this->render('topmenu', ['urls'=>self::$urls, 'current_url'=>$current_url]);
    }
}