<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace app\controllers;

use Da\User\Event\UserEvent;
use Da\User\Factory\MailFactory;
use Da\User\Filter\AccessRuleFilter;
use Da\User\Model\Profile;
use Da\User\Model\AbstractAuthItem;

use Da\User\Model\User;
use Da\User\Query\UserQuery;

use Da\User\Search\UserSearch;
use Da\User\Service\PasswordExpireService;
use Da\User\Service\PasswordRecoveryService;
use Da\User\Service\SwitchIdentityService;
use Da\User\Service\UserBlockService;
use Da\User\Service\UserConfirmationService;
use Da\User\Service\UserCreateService;
use Da\User\Traits\ContainerAwareTrait;
use Da\User\Validator\AjaxRequestModelValidator;
use Yii;
use yii\base\Module;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

class AdminController extends \Da\User\Controller\AdminController
{
    public $layout = '@app/views/layouts/admin';
}
