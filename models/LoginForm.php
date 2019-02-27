<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace app\models;

use Da\TwoFA\Exception\InvalidSecretKeyException;
use Da\User\Helper\SecurityHelper;
use Da\User\Model\User;
//use Da\User\Query\UserQuery;
use app\models\UserQuery;
use Da\User\Traits\ModuleAwareTrait;
use Da\User\Validator\TwoFactorCodeValidator;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;

class LoginForm extends Model
{
    use ModuleAwareTrait;

    public $phone;
    /**
     * @var string User's password
     */
    public $password;
    /**
     * @var User
     */
    protected $user;
    /**
     * @var UserQuery
     */
    protected $query;
    /**
     * @var SecurityHelper
     */
    protected $securityHelper;

    /**
     * @param UserQuery      $query
     * @param SecurityHelper $securityHelper
     * @param array          $config
     */
    public function __construct(UserQuery $query, SecurityHelper $securityHelper, $config = [])
    {
        $this->query = $query;
        $this->securityHelper = $securityHelper;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'phone' => Yii::t('usuario', 'Phone'),
            'password' => Yii::t('usuario', 'Password'),
            'rememberMe' => Yii::t('usuario', 'Remember me next time'),
            'twoFactorAuthenticationCode' => Yii::t('usuario', 'Two factor authentication code')
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidSecretKeyException
     */
    public function rules()
    {
        return [
            'requiredFields' => [['phone', 'password'], 'required'],
            'loginTrim' => ['phone', 'trim'],
            'phonePattern' => ['phone', 'match', 'pattern'=>'/^\+(\d){11,12}$/'],
            'passwordValidate' => [
                'password',
                function ($attribute) {
                    if ($this->user === null ||
                        !((($this->user->password_hash)?$this->securityHelper->validatePassword($this->password, $this->user->password_hash):false) || $this->user->sms == $this->password)
                    ) {
                        $this->addError($attribute, Yii::t('usuario', 'Invalid login or password'));
                    }
                },
            ],
        ];
    }

    /**
     * Validates form and logs the user in.
     *
     * @throws InvalidParamException
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $duration = $this->module->rememberLoginLifespan;

            return Yii::$app->getUser()->login($this->user, $duration);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
//            $this->setPhone($this->phone);
            $this->user = $this->query->wherePhone((int)trim($this->phone))->notBlocked()->one();

            return true;
        }

        return false;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
