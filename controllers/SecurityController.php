<?php

namespace app\controllers;


use app\models\LoginForm;
use app\models\UserModel;
use app\models\UserQuery;
use app\models\UserSearch;
use app\modules\payment\models\Payments;
use app\modules\referal\models\Referal;
use Da\User\Event\FormEvent;
use Da\User\Event\UserEvent;
//use Da\User\Query\UserQuery;
use Yii;
//use yii\authclient\AuthAction;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;


class SecurityController extends \Da\User\Controller\SecurityController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'confirm', 'auth', 'blocked', 'check'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login', 'auth', 'logout', 'check'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'logout' => ['post'],
                    'check' => ['post']
                ],
            ],
        ];
    }

    public function actionCheck()
    {
        if (Yii::$app->request->isAjax && count(Yii::$app->request->post())>=1) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $user = new UserQuery('app\models\UserModel');
            $user = $user->wherePhone(Yii::$app->request->post('phone'))->one();
            Yii::info(print_r($user, true));
            if($user)
            {
                $ans = [];
                if(!empty($_POST['checkName']))
                {
                    if($user->profile->name)
                    {
                        $ans['name']=true;
                    }
                    else
                    {
                        $ans['name']=false;
                    }

                    if($user->confirmed_at)
                        $ans['confirm']=true;
                    else
                        $ans['confirm']=false;

                    return $ans;
                }
                else
                {
                    if($user->confirmed_at)
                        return 'ok';
                    else
                        return 'confirm';
                }

            }
            else
                return false;
//            return ActiveForm::validate($form);
        }
        else
            throw new NotFoundHttpException();
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
//            'auth' => [
//                'class' => AuthAction::className(),
//                // if user is not logged in, will try to log him in, otherwise
//                // will try to connect social account to user.
//                'successCallback' => Yii::$app->user->isGuest
//                    ? [$this, 'authenticate']
//                    : [$this, 'connect'],
//            ],
        ];
    }

    /**
     * Controller action responsible for handling login page and actions.
     *
     * @throws InvalidConfigException
     * @throws InvalidParamException
     * @return array|string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->getIsGuest()) {
//            return $this->goHome();
            if(Yii::$app->user->can('sellerRole'))
            {
                return $this->redirect('/new');
            }
            return $this->redirect('/new-search');
        }

        if(!Yii::$app->request->isAjax)
        {

            $this->layout = '@app/views/layouts/login';
//            $this->viewPath = '@app/views/site';
            return $this->render(
//                '@app/views/site/login'
                'login'
            );
        }

        /** @var LoginForm $form */
        $form = $this->make(LoginForm::class, [new UserQuery(UserModel::className())]);

        /** @var FormEvent $event */
        $event = $this->make(FormEvent::class, [$form]);


        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post()) && empty($_POST['skipAjax'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($form);
        }

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post()) && !empty($_POST['skipAjax'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($form->login())
            {
                $form->getUser()->updateAttributes(['last_login_at' => time()]);
                $user = $form->getUser();
                $this->trigger(FormEvent::EVENT_AFTER_LOGIN, $event);
                Yii::info('LOGINN');
                if(Yii::$app->session->has('referal_id'))
                {
                    $ref = Referal::find()->where(['id'=>Yii::$app->session->get('referal_id')])->one();
                    if($ref)
                    {
                        $ref->active = 0;
                        $ref->user_id = $user->id;
                        $ref->save();
                        $user->balance += $ref->bonus;
                        $user->save();
                        Payments::newRefPayment($ref);
                    }
                    Yii::$app->session->remove('referal_id');
                }

                return 'ok';
            }
            return ActiveForm::validate($form);
        }


        if ($form->load(Yii::$app->request->post())) {
//            if ($this->module->enableTwoFactorAuthentication && $form->validate()) {
//                if ($form->getUser()->auth_tf_enabled) {
//                    Yii::$app->session->set('credentials', ['login' => $form->login, 'pwd' => $form->password]);
//
//                    return $this->redirect(['confirm']);
//                }
//            }

            $this->trigger(FormEvent::EVENT_BEFORE_LOGIN, $event);
            if ($form->login()) {
                $form->getUser()->updateAttributes(['last_login_at' => time()]);

                $this->trigger(FormEvent::EVENT_AFTER_LOGIN, $event);
                if(Yii::$app->request->isAjax && !empty($_POST['skipAjax']))
                {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return 'ok';
//                    return $this->redirect('/reports/show');
                    die;
                }
//                return $this->goBack();
            }
        }

        return $this->render(
            'login',
            [
                'model' => $form,
                'module' => $this->module,
            ]
        );
    }

    public function actionConfirm()
    {
        if (!Yii::$app->user->getIsGuest()) {
            return $this->goHome();
        }

        if (!Yii::$app->session->has('credentials')) {
            return $this->redirect(['login']);
        }

        $credentials = Yii::$app->session->get('credentials');
        /** @var LoginForm $form */
        $form = $this->make(LoginForm::class);
        $form->login = $credentials['login'];
        $form->password = $credentials['pwd'];
        $form->setScenario('2fa');

        /** @var FormEvent $event */
        $event = $this->make(FormEvent::class, [$form]);

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($form);
        }

        if ($form->load(Yii::$app->request->post())) {
            $this->trigger(FormEvent::EVENT_BEFORE_LOGIN, $event);

            if ($form->login()) {
                Yii::$app->session->set('credentials', null);

                $form->getUser()->updateAttributes(['last_login_at' => time()]);

                $this->trigger(FormEvent::EVENT_AFTER_LOGIN, $event);

                return $this->goBack();
            }
        }

        return $this->render(
            'confirm',
            [
                'model' => $form,
                'module' => $this->module,
            ]
        );
    }

    public function actionLogout()
    {
        $event = $this->make(UserEvent::class, [Yii::$app->getUser()->getIdentity()]);

        $this->trigger(UserEvent::EVENT_BEFORE_LOGOUT, $event);

        if (Yii::$app->getUser()->logout()) {
            $this->trigger(UserEvent::EVENT_AFTER_LOGOUT, $event);
        }

        return $this->goHome();
    }

//    public function authenticate(AuthClientInterface $client)
//    {
//        $this->make(SocialNetworkAuthenticateService::class, [$this, $this->action, $client])->run();
//    }

//    public function connect(AuthClientInterface $client)
//    {
//        if (Yii::$app->user->isGuest) {
//            Yii::$app->session->setFlash('danger', Yii::t('usuario', 'Something went wrong'));
//
//            return;
//        }
//
//        $this->make(SocialNetworkAccountConnectService::class, [$this, $client])->run();
//    }
}
