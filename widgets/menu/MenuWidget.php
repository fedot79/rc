<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 23.08.2018
 * Time: 14:33
 */

namespace app\widgets\menu;


use app\modules\negotiation\models\Negotiations;
use app\modules\tariff\models\Tariff;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class MenuWidget extends Widget
{
    public function run()
    {
        $user = false;
        $items = [];

        $i_retailer = true;

        if(Yii::$app->user->isGuest)
        {
            if(Yii::$app->session->get('user_type', 'buyer')=='buyer')
            {
                $i_retailer = true;
            }
            else
            {
                $i_retailer = false;
            }
        }
        else
        {
            if(Yii::$app->user->can('buyerRole'))
            {
                $i_retailer = true;
            }
            else
            {
                $i_retailer = false;
            }
        }



        if(!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;

            $pakets = Tariff::find()->where(['user_id'=>Yii::$app->user->id])->limit(1)->one();

            if($pakets)
            {
                $pakets = Yii::$app->user->identity->getRemainShows();
                $items[] = [
                    'href' => null,
                    'svg' => '/img/wallet.svg#wallet',
                    'txt' => $user->balance.' ₽',
                    'class'=>'narrow'.($user->balance>0?' mint':'')
                ];

                $pakets_class = ['narrow', 'packets'];
                $pakets_txt = '';
                $pakets_after = '';
                $pakets_svg = '/img/views.svg#views.svg';

                if($pakets<=10)
                {
                    $pakets_txt = '<strong>'.$pakets.'</strong> показов';
                    $pakets_class[] = 'low';
                    $pakets_after = '<div class="notify">На вашем счету осталось меньше 10 показов.<br><a class="button-common button-sm" href="'.Url::to(['/tariff/default/index']).'">Докупить пакет</a></div>';
                }
                else
                {
                    $pakets_txt = $pakets.' показов';
                }

                if($pakets>0)
                    $pakets_class[] = 'mint';
                else
                {
                    $pakets_class[] = 'red';
                    $pakets_svg = '/img/no-views.svg#no-views.svg';
                    $pakets_after = '<div class="notify">На вашем счету не осталось показов.<br><a class="button-common button-sm" href="'.Url::to(['/tariff/default/index']).'">Докупить пакет</a></div>';
                }

                $items[] = [
                    'href' => Url::to(['/tariff/default/index']),
                    'svg' => $pakets_svg,
                    'txt' => $pakets_txt,
                    'class'=>implode(' ', $pakets_class),
                    'after'=>$pakets_after
                ];
            }
            else
            {
                $items[] = [
                    'href' => null,
                    'svg' => '/img/wallet.svg#wallet',
                    'txt' => $user->balance.' ₽',
                    'class'=>($user->balance>0)?'mint':''
                ];
            }

        }
        $items[] = [
            'href'=>$i_retailer?Url::to(['/searches/default/new']):Url::to(['/objects/default/new']),
            'svg'=>'/img/newobject.svg#newobject',
            'txt'=>($i_retailer?'Новая потребность':'Создать объект')
        ];
        if(!Yii::$app->user->isGuest) {
            $items[] = [
                'href' => Yii::$app->user->can('sellerRole') ? Url::to(['/objects/default/my']) : Url::to(['/searches/default/my']),
                'svg' => '/img/myobjects.svg#myobjects',
                'txt' => 'Мои' . (Yii::$app->user->can('sellerRole') ? ' объекты' : ' потребности')
            ];
            if (Negotiations::find()->myCount()->count() > 0) {
                $nego_after = '';
//                if(Negotiations::find()->my('waiting')->count()>0)
//                {
//                    $nego_after = '<div class="notify">У вас новое входящее предложение</div>';
//                }
                $items[] = [
                    'href' => Url::to(['/negotiation/default/index']),
                    'svg' => '/img/nego.svg#nego',
                    'txt' => 'Переговоры',
                    'class' => $nego_after?'mint':'',
                    'after'=>$nego_after
                ];
            }
//            $items[] = [
//                'href' => Url::to(['/review/default/index']),
//                'svg' => '/img/reviews.svg#reviews.svg',
//                'txt' => 'Отзывы'
//            ];
            $items[] = [
                'href' => Url::to(['/site/settings']),
                'svg' => '/img/settings.svg#settings.svg',
                'txt' => 'Настройки'
            ];

            $items[] = [
                'href'=>Url::to(['/tariff/default/plans']),
                'svg'=>'/img/plan.svg#plan.svg',
                'txt'=>'Пакеты'
            ];
        }

        if(Yii::$app->user->can('sellerRole'))
        {

            $items[] = [
                'href'=>Url::to(['/brand/default/index']),
                'svg'=>'/img/brand.svg#brand.svg',
                'txt'=>'Брендирование',
                'class'=>'branding'
            ];
        }

        if(!Yii::$app->user->isGuest) {
            $items[] = [
                'href'=>Url::to(['/user/security/logout']),
                'svg'=>'/img/logout.svg#logout',
                'txt'=>'Выход',
                'class'=>'logout menu-mobile'
            ];
        }
        else
        {
            $items[] = [
                'href'=>Url::to(['/user/security/login']),
                'svg'=>'/img/login.svg#login',
                'txt'=>'Вход',
                'class'=>'logout menu-mobile'
            ];
        }

        $items[] = [
            'href'=>Url::to('#help'),
            'svg'=>'/img/infos.svg#infos',
            'txt'=>'Помощь',
            'class'=>'menu-help menu-mobile'
        ];






        return $this->render('menu', ['user'=>$user, 'items'=>$items]);
    }
}