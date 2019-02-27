<?php

namespace app\controllers;

use app\components\Image;
use app\components\TrackingController;
use app\models\CustomRequest;
use app\models\UserModel;
use app\models\UserPassForm;
use app\modules\notification\models\Notification;
use app\modules\payment\models\Payments;
use app\modules\referal\models\Referal;
use app\widgets\help\HelpForm;
use DateTime;
use DateTimeZone;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions'=>['choose'],
                        'allow'=>true,
                        'roles' => ['@']
                    ],
                    [
                        'actions'=>['settings', 'save-settings'],
                        'allow'=>true,
                        'roles'=>['@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'decline' => ['post'],
                ],
            ],
            'utm_source' => [
                'class' => TrackingController::class,
                'queryParam' => 'utm_source',
                'sessionParam' => 'utm_source',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error'
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'index_new';
        return $this->render('index_new', []);
    }

    public function actionChoose()
    {
        $this->layout = 'main';
        if(Yii::$app->user->can('buyerRole'))
        {
            return $this->redirect('/new-search');
        }
        if(Yii::$app->user->can('sellerRole'))
        {
            return $this->redirect('/new');
        }
        return $this->render('choose');
    }

    public function actionHelp()
    {
        $form = new HelpForm();
        if($form->load(Yii::$app->request->post()) && $form->validate())
        {
            $user = null;
            if(!Yii::$app->user->isGuest)
                $user = \Da\User\Model\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->username;


            $msg =  'Сообщение в ТП';
            $body = 'От: '.$form->email.' '
                .($user?$user.' ':'')
                .PHP_EOL
                .$form->text
                .PHP_EOL.'Отправлено '.(new DateTime(null, (new DateTimeZone('Europe/Moscow'))))->format('d.m.Y H:i:s');
            Yii::$app->mailer->compose()
                ->setFrom('server@re-connect.ru')
                ->setTo('support@re-connect.ru')
                ->setReplyTo($form->email)
                ->setSubject($msg)
                ->setTextBody($body)
                ->send();
        }
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }

    public function actionPrice()
    {
        return $this->render('price');
    }

    public function actionUserAgreement()
    {
        return $this->render('agree');
    }

    public function actionPrivacyPolicy()
    {
        return $this->render('privacy');
    }

    public function actionBeforeNew()
    {
        return $this->render('before_new');
    }

    public function actionTestImages()
    {
        $images = scandir('img');
        echo '<style>body{background: #f6f6f6}</style>';
        foreach ($images as $image) {
            if(!in_array($image, ['.', '..']) && (strpos($image, 'png')!==null || strpos($image, 'svg')!==null))
            {
                echo '<figure style="display: inline-block; max-width: 50px">
    <p><img src="/img/'.$image.'" alt="" style="max-width: 50px"/></p>
    <figcaption>'.$image.'</figcaption>
    </figure>';
            }
        }



        die;
    }

    public function actionNotice()
    {
//        $notice = Notification::make(Notification::RULE_NEW_NEGO, ['url'=>'/contact/see/16/53/search']);
//        var_dump($notice);
//        die;
        /** @var Notification[] $notices */
        $notices = Notification::find()->new()->all();
        echo '<pre>'.PHP_EOL;
        $notices[0]->send(Notification::TRANSPORT_EMAIL);
        var_dump($notices[0]);
        echo '</pre>'.PHP_EOL;
    }

    public function actionSettings()
    {
        $user = Yii::$app->user->identity;
        $userForm = new UserPassForm();
        return $this->render('settings', ['user'=>$user, 'userForm'=>$userForm]);
    }

    public function actionSaveSettings()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(Yii::$app->request->isPost)
        {
//            var_dump($_POST);
//            die;
            $user = UserModel::find()->where(['id'=>Yii::$app->user->id])->one();
            $userForm = null;
            $profile = $user->profile;
            if(!empty($_POST['action']))
            {
                if($_POST['action']=='check')
                {
                    $userForm = new UserPassForm(['scenario' => UserPassForm::SCENARIO_CHECK]);
                }
                if($_POST['action']=='update')
                {
                    $userForm = new UserPassForm(['scenario' => UserPassForm::SCENARIO_UPDATE]);
                }
                if($_POST['action']=='del_ava')
                {
                    $user->avatar = '';
                    $user->save();
                    return true;
                }
            }




//            $_POST['UserModel']['username'] = str_replace(['-', ' '], '', $_POST['UserModel']['username']);
//            Yii::warning($_POST['UserModel']['username']);
//            unset($_POST['UserModel']['username']);
//            Yii::info($_POST['UserModel']['username']);
            if($profile->load(Yii::$app->request->post()))
            {
                $profile->save();
                Yii::info(var_export($profile->errors, true));
            }

            if($userForm && $userForm->load(Yii::$app->request->post()) && $_POST['action']=='check')
            {
                $userForm->validate();
                if(count($userForm->errors)>0)
                    return false;
                else
                    return true;
            }

            if($userForm && $userForm->load(Yii::$app->request->post()) && $_POST['action']=='update')
            {
                $user->password_hash = Yii::$app->security->generatePasswordHash($userForm->new_pass);
                $user->password_changed_at = time();
                return $user->save();
            }

            $user->ava_file = UploadedFile::getInstance($user, 'ava_file');
            Yii::info(var_export($user->ava_file, true));
            if($user->ava_file && $user->validate())
            {
                $filename = md5($user->ava_file->baseName.microtime()).'.'.$user->ava_file->extension;
                $s = $user->ava_file->saveAs('uploads/ava/' . $filename);
                Image::convert($filename);

                $user->ava_file = null;
                if($s)
                {
                    $user->avatar = $filename;
                    $user->save();
                }

                else
                {
                    Yii::warning($s);
                    Yii::warning($user->errors);
                }
            }

            if($user->load(Yii::$app->request->post()))
            {
                $user->save();
                Yii::info(var_export($user->errors, true));
            }
        }
//        return $this->redirect('/settings');
    }

    public function actionReferal($referal_url)
    {
        $ref = Referal::find()->where(['url'=>$referal_url, 'active'=>1])->one();
        if($ref)
        {
            if(Yii::$app->user->isGuest)
            {
                $ref->visited = (new Expression('NOW()'));
                $ref->save();

                Yii::$app->session->set('referal_id', $ref->id);
                return $this->redirect(['/login']);
            }
            else
            {
                /** @var UserModel $user */
                $user = Yii::$app->user->identity;
                $ref->visited = (new Expression('NOW()'));
                $ref->active = 0;
                $ref->user_id = $user->id;
                $ref->save();
                $user->balance+=$ref->bonus;
                $user->save();
                Payments::newRefPayment($ref);
                return $this->redirect(['/site/choose']);
            }
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCustomRequest()
    {
        if(!Yii::$app->user->isGuest && Yii::$app->request->isAjax)
        {
            /** @var UserModel $user */
            $user = Yii::$app->user->identity;
            Yii::$app->response->format = Response::FORMAT_JSON;
            $cr = new CustomRequest();
            $cr->user_id = $user->id;
            $cr->save();

            $msg =  'Заявка на всю РФ';
            $body = 'От: '.$user->username.' '.$user->profile->name
                .PHP_EOL
                .PHP_EOL.'Отправлено '.(new DateTime(null, (new DateTimeZone('Europe/Moscow'))))->format('d.m.Y H:i:s');
            Yii::$app->mailer->compose()
                ->setFrom('server@re-connect.ru')
                ->setTo('support@re-connect.ru')
                ->setSubject($msg)
                ->setTextBody($body)
                ->send();
            return 'ok';
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPdfTest()
    {
        $this->layout = 'clean';
        return $this->render('pdf-test');
    }
}
