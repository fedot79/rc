<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 21.01.2019
 * Time: 11:54
 */


use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\Pjax;
use yii\base\BaseObject;

;

/**
 * @var $this         yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel  Da\User\Search\UserSearch
 *
 * @var $module       Da\User\Module
 */

$this->title = Yii::t('usuario', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;

$module = Yii::$app->getModule('user');
?>

<?php $this->beginContent('@Da/User/resources/views/shared/admin_layout.php') ?>

<?php Pjax::begin() ?>

<?= GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            'username',
            [
                'attribute' => 'email',
                'value' => 'profile.public_email',
                'format' => 'email',
            ],
            [
                'attribute' => 'name',
                'value' => 'profile.name',
                'label' => 'Имя'
            ],
            [
                'attribute' => 'role',
                'value' =>function($dataProvider){
                                $role=Yii::$app->authManager->getRolesByUser($dataProvider["id"]);

                                var_dump($role);
                                return ($role->array(0));

                                },
                'label' => 'Назначение'

            ],
            [
                'attribute' => 'bio',
                'value' => 'profile.bio',
                'label' => 'О себе'
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    if (extension_loaded('intl')) {
                        return Yii::t('usuario', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
                    }

                    return date('Y-m-d G:i:s', $model->created_at);
                },
            ],
            [
                'attribute' => 'last_login_at',
                'value' => function ($model) {
                    if (!$model->last_login_at || $model->last_login_at == 0) {
                        return Yii::t('usuario', 'Never');
                    } elseif (extension_loaded('intl')) {
                        return Yii::t('usuario', '{0, date, MMMM dd, YYYY HH:mm}', [$model->last_login_at]);
                    } else {
                        return date('Y-m-d G:i:s', $model->last_login_at);
                    }
                },
            ],
            [
//                'label'=>'Пересечения',
//                'attribute' => 'selection_count',
                'header'=>'Пересечения',
                'value'=>function($model){
                    return $model->getActiveSelections();
                },
                'format' => 'raw'
            ],
//            [
//                'header' => Yii::t('usuario', 'Confirmation'),
//                'value' => function ($model) {
//                    if ($model->isConfirmed) {
//                        return '<div class="text-center">
//                                <span class="text-success">' . Yii::t('usuario', 'Confirmed') . '</span>
//                            </div>';
//                    }
//
//                    return Html::a(
//                        Yii::t('usuario', 'Confirm'),
//                        ['confirm', 'id' => $model->id],
//                        [
//                            'class' => 'btn btn-xs btn-success btn-block',
//                            'data-method' => 'post',
//                            'data-confirm' => Yii::t('usuario', 'Are you sure you want to confirm this user?'),
//                        ]
//                    );
//                },
//                'format' => 'raw',
//                'visible' => Yii::$app->getModule('user')->enableEmailConfirmation,
//            ],
//            'password_age',
            [
                'header' => Yii::t('usuario', 'Block status'),
//                'attribute' => 'blocked_at',
                'value' => function ($model) {
                    if ($model->isBlocked) {
                        return Html::a(
                            Yii::t('usuario', 'Unblock'),
                            ['block', 'id' => $model->id],
                            [
                                'class' => 'btn btn-xs btn-success btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('usuario', 'Are you sure you want to unblock this user?'),
                            ]
                        );
                    }

                    return Html::a(
                        Yii::t('usuario', 'Block'),
                        ['block', 'id' => $model->id],
                        [
                            'class' => 'btn btn-xs btn-danger btn-block',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('usuario', 'Are you sure you want to block this user?'),
                        ]
                    );
                },
                'format' => 'raw',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{switch} {reset} {force-password-change} {update} {delete}',
                'buttons' => [
                    'switch' => function ($url, $model) use ($module) {
                        if ($model->id != Yii::$app->user->id && $module->enableSwitchIdentities) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-user"></span>',
                                ['/user/admin/switch-identity', 'id' => $model->id],
                                [
                                    'title' => Yii::t('usuario', 'Impersonate this user'),
                                    'data-confirm' => Yii::t(
                                        'usuario',
                                        'Are you sure you want to switch to this user for the rest of this Session?'
                                    ),
                                    'data-method' => 'POST',
                                ]
                            );
                        }

                        return null;
                    },
                    'reset' => function ($url, $model) use ($module) {
                        if(!$module->allowPasswordRecovery && $module->allowAdminPasswordRecovery) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-flash"></span>',
                                ['/user/admin/password-reset', 'id' => $model->id],
                                [
                                    'title' => Yii::t('usuario', 'Send password recovery email'),
                                    'data-confirm' => Yii::t(
                                        'usuario',
                                        'Are you sure you wish to send a password recovery email to this user?'
                                    ),
                                    'data-method' => 'POST',
                                ]
                            );
                        }

                        return null;
                    },
                    'force-password-change' => function ($url, $model) use ($module) {
                        if (is_null($module->maxPasswordAge)) {
                            return null;
                        }
                        return Html::a(
                            '<span class="glyphicon glyphicon-time"></span>',
                            ['/user/admin/force-password-change', 'id' => $model->id],
                            [
                                'title' => Yii::t('usuario', 'Force password change at next login'),
                                'data-confirm' => Yii::t(
                                    'usuario',
                                    'Are you sure you wish the user to change their password at next login?'
                                ),
                                'data-method' => 'POST',
                            ]
                        );
                    },
                ]
            ],
        ],
    ]
); ?>

<?php Pjax::end() ?>

<?php $this->endContent() ?>
