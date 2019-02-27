<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 09.06.2018
 * Time: 12:58
 */

namespace app\models;


use app\modules\brand\models\Brand;
use app\modules\notification\models\Notification;
use app\modules\payment\models\PaymentsOut;
use app\modules\review\models\Reviews;
use app\modules\tariff\models\Tariff;
use Da\User\Helper\SecurityHelper;
use Da\User\Model\Profile;

use Da\User\Model\SocialNetworkAccount;
use app\components\NameCaseLib\NCLNameCaseRu;
use Yii;
use yii\helpers\Html;
use yii\web\Application;
use yii\web\IdentityInterface;

/**
 * User ActiveRecord model.
 *
 * @property bool $isAdmin
 * @property bool $isBlocked
 * @property bool $isConfirmed whether user account has been confirmed or not
 *
 * Database fields:
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $unconfirmed_email
 * @property string $password_hash
 * @property string $auth_key
 * @property string $auth_tf_key
 * @property int $auth_tf_enabled
 * @property int $registration_ip
 * @property int $confirmed_at
 * @property int $blocked_at
 * @property int $flags
 * @property int $created_at
 * @property int $updated_at
 * @property int $last_login_at
 * @property int $password_changed_at
 * @property int $password_age
 * @property int $sms
 * @property int $balance
 * @property int $rating
 * @property string $skype
 * @property string $fb
 * @property string $tg
 * @property string $wa
 * @property string $vb
 * @property string $avatar
 * @property string $from
 *
 * Defined relations:
 * @property SocialNetworkAccount[] $socialNetworkAccounts
 * @property Profile $profile
 * @property Tariff[] $activeTariff
 * @property Brand $brand
 * @property Reviews[] $reviewsAbout
 */

class UserModel extends \Da\User\Model\User implements IdentityInterface
{

    public $phone;
    public $name;
    public $ava_file;
    public $selection_count;

    private $roles_types = ['seller'=>'buyer', 'buyer'=>'seller'];

    public static function anonym()
    {
        $new = new self;
        $new->rating = 0;
        $new->balance = 0;
        $profile = new Profile();
        $profile->name = 'Ваше имя';
        $new->populateRelation('profile', $profile);
        return $new;
    }

    public function rules()
    {
//        $rules = parent::rules();
        $rules = [
            ['username', 'required', 'on' => ['register', 'create', 'connect', 'update'], 'message'=>'обязательно'],
            ['username', 'unique', 'on'=>['register', 'create'], 'message'=>'юник'],
            ['username', 'match', 'pattern'=>'/^\+(\d){11,12}$/', 'message'=>'матч'],

            ['sms', 'integer', 'min'=>0, 'max'=>99999],
            ['sms', 'default', 'value'=>null],
            ['name', 'safe'],

//            'usernameRequired' => ['username', 'required', 'on' => ['register', 'create', 'connect', 'update']],
//            'usernameMatch' => ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@\+]+$/'],
//            'usernameLength' => ['username', 'string', 'min' => 3, 'max' => 255],
//            'usernameTrim' => ['username', 'trim'],
//            'usernameUnique' => [
//                'username',
//                'unique',
//                'message' => Yii::t('usuario', 'This username has already been taken'),
//            ],

            // email rules
//            'emailRequired' => ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            'emailPattern' => ['email', 'email'],
            'emailLength' => ['email', 'string', 'max' => 255],
            'emailUnique' => [
                'email',
                'unique',
                'message' => Yii::t('usuario', 'This email address has already been taken'),
                'skipOnEmpty' => true,
                'skipOnError' => true
            ],
            'emailTrim' => ['email', 'trim'],
            'emailDefault' => ['email', 'default', 'value' => null],

            // password rules
            'passwordTrim' => ['password', 'trim'],
//            'passwordRequired' => ['password', 'required', 'on' => ['register']],
            'passwordLength' => ['password', 'string', 'min' => 6, 'max' => 72, 'on' => ['register', 'create']],

            // two factor auth rules
            'twoFactorSecretTrim' => ['auth_tf_key', 'trim'],
            'twoFactorSecretLength' => ['auth_tf_key', 'string', 'max' => 16],
            'twoFactorEnabledNumber' => ['auth_tf_enabled', 'integer'],

            'balance' => ['balance', 'integer'],
            'rating' => ['rating', 'integer'],
            'profile' => [['fb', 'wa', 'tg', 'skype', 'vb'], 'string', 'max' => 255],
            'avatar'=>['avatar', 'string', 'max'=>37],
            'avatar_file'=> ['ava_file', 'file', 'extensions' => 'png, jpg', 'maxSize'=>2000000],
            'from' => ['from', 'safe'],
            'selection_count'=>['selection_count', 'safe']
        ];

//        $rules = array_merge(parent::rules(), $rules);


        return $rules;
    }

    public function attributeLabels()
    {
        $labels = [
            'phoneStr'=>'Телефон',
            'phone'=>'Телефон',
            'username'=>'Телефон',
        ];

        return array_merge(parent::attributeLabels(), $labels); // TODO: Change the autogenerated stub
    }

    public function getPhoneStr()
    {
        return $this->username[0].$this->username[1].' '.$this->username[2].$this->username[3].$this->username[4].' '.$this->username[5].$this->username[6].$this->username[7].'-'.$this->username[8].$this->username[9].'-'.$this->username[10].$this->username[11];
    }

    public function getSmsStr()
    {
        return str_pad($this->sms, 5, "0", STR_PAD_LEFT);
    }

    public function beforeSave($insert)
    {
        $security = $this->make(SecurityHelper::class);
        if ($insert) {
//            $this->setAttribute('auth_key', rand(0, 99999));
            if (Yii::$app instanceof Application) {
                $this->setAttribute('registration_ip', Yii::$app->request->getUserIP());
            }
        }

        if (!empty($this->password)) {
            $this->setAttribute(
                'password_hash',
                $security->generatePasswordHash($this->password, $this->getModule()->blowfishCost)
            );
            $this->password_changed_at = time();
        }

        if(Yii::$app->has('session'))
        {
            $from = Yii::$app->session->get('utm_source', null);
            if($from)
            {
                $this->from = $from;
            }
        }


        return parent::beforeSave($insert);
    }

    public function getNameString($container = 'p', $class=false, $strong = true)
    {
        $fio = explode(' ', $this->profile->name);
        $name = array_shift($fio);
        if($strong)
            $name = '<strong>'.$name.'</strong>';
        return '<'.$container.($class?(' class="'.$class.'"'):'').'>'.$name.' '.implode(' ', $fio).'</'.$container.'>';
    }

    public function getNameArray()
    {
        if($this->primaryKey==null && $this->profile->name!==null)
            return [$this->profile->name];
        $fio = explode(' ', $this->profile->name);
        return [array_shift($fio), implode(' ', $fio)];
    }

    public static function checkEditAdmin($user_id)
    {
        if(!Yii::$app->user->can('admin'))
        {
            return !Yii::$app->authManager->checkAccess($user_id, 'admin');
        }
        return true;
    }

    public function beforeValidate()
    {
        if(!empty($this->phone))
            $this->username = $this->phone;
        $this->username = str_replace(['-', ' '], '', $this->username);
        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    public function fillBalance($amount)
    {
        $this->balance += $amount;
        $this->save();
    }

    /**
     * @param $amount
     * @param PaymentsOut $reason
     * @return bool
     */
    public function spentBalance($amount, PaymentsOut $reason): bool
    {
        if($this->balance>= $amount && $reason)
        {
            $this->balance-=$amount;
            return $this->save();
        }
        return false;
    }

    public function getRating($white=true)
    {
        if($white)
        {
            return 'star'.$this->rating.'-white.png';
        }
        else{
            return 'star'.$this->rating.'-mint.png';
        }
    }

    public function addRating($value)
    {
        $this->rating = $value;
        $this->save();
    }

    public function getLink()
    {
        return Html::a($this->username, ['/user/admin/update', 'id'=>$this->primaryKey]);
    }

    public function getFName()
    {
        $name = explode(' ', $this->profile->name);
        return $name[0];

    }

    public function getNamesArr()
    {
        $nc = new NCLNameCaseRu();
        return $nc->q($this->getFName());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewsAbout()
    {
        return $this->hasMany(Reviews::class, ['user_id'=>'id'])->andWhere(['not', ['moderated'=>null]]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveTariff()
    {
        return $this->hasMany(Tariff::class, ['user_id'=>'id'])->andWhere([Tariff::tableName().'.active'=>1])->andWhere(Tariff::tableName().'.open_count<='.Tariff::tableName().'.tariff')->orderBy(['id'=>SORT_ASC]);
    }

    public function getRemainShows()
    {
        $tariffs = $this->activeTariff;
        $out = 0;
        foreach ($tariffs as $tariff) {
            $out += $tariff->tariff-$tariff->open_count;
        }
        return $out;
    }

    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['user_id'=>'id']);
    }

    public function getPreferredTransport()
    {
        return Notification::TRANSPORT_SMS;
    }

    public function getPreferredDestination()
    {
        return 'daniellz@ya.ru';
    }

    public function getAvatarPic()
    {
        return $this->avatar?'/uploads/ava/'.$this->avatar:'/img/default_userpic.svg';
    }

    public function whoAmI()
    {
        if(Yii::$app->user->can('sellerRole'))
        {
            return 'seller';
        }
        if(Yii::$app->user->can('buyerRole'))
        {
            return 'buyer';
        }

        return false;
    }

    public function opposite()
    {
        return $this->roles_types[$this->whoAmI()];
    }

    public function getActiveSelections()
    {
        $roles = $this->getRoles();
        $count = 0;
        if(array_key_exists('sellerRole', $roles))
        {
            $count = Yii::$app->db->createCommand('select count(s.id) from selection s
  left join objects o on s.object_id = o.id
  left join negotiations n on n.search_id = s.search_id and n.object_id = s.object_id
where o.author_id = '.$this->id.' and n.cancelled is null and n.declined is null;')->queryScalar();
        }
        if(array_key_exists('buyerRole', $roles))
        {
            $count = Yii::$app->db->createCommand('select count(s.id) from selection s
  left join search o on s.object_id = o.id
  left join negotiations n on n.search_id = s.search_id and n.object_id = s.object_id
where o.user_id = '.$this->id.' and n.cancelled is null and n.declined is null;')->queryScalar();
        }
//        die;
        return $count;
    }

    private function getRoles()
    {
        $id = $this->id;
        $data = Yii::$app->cache->getOrSet('userRoles.'.$this->id, function () use ($id) {
            return Yii::$app->authManager->getRolesByUser($id);
        }, '3600');
        return $data;
    }
}