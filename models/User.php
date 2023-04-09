<?php

namespace app\models;

use app\models\common\AsAdmin;
use app\models\common\DocumentOrder;
use app\models\common\Feedback;
use app\models\common\Log;
use app\models\common\People;
use app\models\extended\APIConnector;
use app\models\UserRole;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $firstname
 * @property string $secondname
 * @property string|null $patronymic
 * @property int|null $role_id
 * @property int $experience_count
 * @property int $type_org_id
 *
 * @property AchievmentUser[] $achievmentUsers
 * @property BusinessGame[] $businessGames
 * @property Chat[] $chats
 * @property Chat[] $chats0
 * @property ProductUser[] $productUsers
 * @property Product[] $products
 * @property Role $role
 * @property TaskUserConfirm[] $taskUserConfirms
 * @property TaskUser[] $taskUsers
 * @property Task[] $tasks
 * @property TeamUser[] $teamUsers
 * @property Team[] $teams
 * @property TypeOrg $typeOrg
 * @property UserSalary[] $userSalaries
 * @property Wallet[] $wallets
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $personalSalaryNFT;
    public $personalSalaryDig;
    public $virtualSalaryNFT;
    public $virtualSalaryDig;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'firstname', 'secondname'], 'required'],
            [['status', 'created_at', 'updated_at', 'role_id', 'personalSalaryNFT', 'personalSalaryDig', 'virtualSalaryNFT', 'virtualSalaryDig'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['firstname', 'secondname', 'patronymic'], 'string', 'max' => 1000],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Пароль',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'firstname' => 'Имя',
            'secondname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'role_id' => 'Роль в системе',
            'roleString' => 'Роль в системе',
            'walletPersonal' => 'Личный кошелек',
            'walletVirtual' => 'Виртуальный кошелек',
            'personalSalary' => 'Ежемесячное пополнение личного кошелька',
            'virtualSalary' => 'Ежемесячное пополнение виртуального кошелька',
            'personalSalaryNFT' => 'InGameCur',
            'personalSalaryDig' => 'Rubles',
            'virtualSalaryNFT' => 'InGameCur',
            'virtualSalaryDig' => 'Rubles',
            'experience_count' => 'Очки опыта',
        ];
    }

    /**
     * Gets query for [[AchievmentUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAchievmentUsers()
    {
        return $this->hasMany(AchievmentUser::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ProductUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductUsers()
    {
        return $this->hasMany(ProductUser::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['user_creator_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * Gets query for [[TaskUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskUsers()
    {
        return $this->hasMany(TaskUser::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['user_creator_id' => 'id']);
    }

    /**
     * Gets query for [[TeamUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamUsers()
    {
        return $this->hasMany(TeamUser::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Teams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeams()
    {
        return $this->hasMany(Team::class, ['user_creator_id' => 'id']);
    }

    /**
     * Gets query for [[Wallets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWallets()
    {
        return $this->hasMany(Wallet::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserRoles]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getUserRoles()
    {
        return $this->hasMany(UserRole::className(), ['user_id' => 'id']);
    }*/

    /**
     * Finds user by username
     *
     * @param string $username
     * @return \app\models\User|null
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        //throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return \app\models\User|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getFullName()
    {
        return $this->secondname.' '.$this->firstname.' ('.$this->username.')';
    }

    public function getFullNameWithRole()
    {
        return $this->secondname.' '.$this->firstname.' ('.$this->username.' - '.$this->role->name.')';
    }


    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
        $this->save();
    }


    public function getRoleString()
    {
        return $this->role->name;
    }

    /**
     * Gets query for [[TypeOrg]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypeOrg()
    {
        return $this->hasOne(TypeOrg::class, ['id' => 'type_org_id']);
    }

    public function getLevelNumber()
    {
        $stack = 100;
        $currentExp = 0;
        while ($currentExp + $stack < $this->experience_count)
        {
            $currentExp += $stack;
            $stack += 100;
        }

        $percent = (($this->experience_count - $currentExp) * 1.0) / (($stack) * 1.0);

        return [$stack / 100, $percent * 100, $currentExp + $stack];
    }

    public function addExp($exp)
    {
        $this->experience_count += $exp;
        $this->save();
    }

    public function checkAchievment()
    {
        $achievment = new Achievment();
        $achievment->MonetaryReward($this->id);
        $achievment->TaskReward($this->id);
        $achievment->TeamReward($this->id);
        $achievment->MarketReward($this->id);
    }

    public function getWalletPersonal()
    {
        $walletNFT = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $this->id])->andWhere(['wallet.type_id' => 1])->andWhere(['currency_id' => 1])->one();
        $walletDig = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $this->id])->andWhere(['wallet.type_id' => 1])->andWhere(['currency_id' => 2])->one();
        return $walletNFT == null ? 'Отсутствует' : 'NFT-сертификаты: '.$walletNFT->count.'<br>Digital Rubles: '.$walletDig->count;
    }

    public function getWalletVirtual()
    {
        $walletNFT = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $this->id])->andWhere(['wallet.type_id' => 2])->andWhere(['currency_id' => 1])->one();
        $walletDig = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $this->id])->andWhere(['wallet.type_id' => 2])->andWhere(['currency_id' => 2])->one();
        return $walletNFT == null ? 'Отсутствует' : 'NFT-сертификаты: '.$walletNFT->count.'<br>Digital Rubles: '.$walletDig->count;
    }

    public function getPersonalSalary()
    {
        $salaryNFT = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['wallet_type_id' => 1])->andWhere(['currency_id' => 1])->one();
        $salaryDig = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['wallet_type_id' => 1])->andWhere(['currency_id' => 1])->one();
        return $salaryNFT == null ? 'Отсутствует' : 'NFT-сертификаты: '.$salaryNFT->salary.'<br>Digital Rubles: '.$salaryDig->salary;
    }

    public function getVirtualSalary()
    {
        $salaryNFT = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['wallet_type_id' => 2])->andWhere(['currency_id' => 1])->one();
        $salaryDig = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['wallet_type_id' => 2])->andWhere(['currency_id' => 1])->one();
        return $salaryNFT == null ? 'Отсутствует' : 'NFT-сертификаты: '.$salaryNFT->salary.'<br>Digital Rubles: '.$salaryDig->salary;
    }

    public function prepare()
    {
        $salary = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['currency_id' => 1])->andWhere(['wallet_type_id' => 1])->one();
        if ($salary !== null) $this->personalSalaryNFT = $salary->salary;

        $salary = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['currency_id' => 2])->andWhere(['wallet_type_id' => 1])->one();
        if ($salary !== null) $this->personalSalaryDig = $salary->salary;

        $salary = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['currency_id' => 1])->andWhere(['wallet_type_id' => 2])->one();
        if ($salary !== null) $this->virtualSalaryNFT = $salary->salary;

        $salary = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['currency_id' => 2])->andWhere(['wallet_type_id' => 2])->one();
        if ($salary !== null) $this->virtualSalaryDig = $salary->salary;
    }

    public function getAchievesNumber()
    {
        return count(AchievmentUser::find()->where(['user_id' => $this->id])->all());
    }

    public function beforeDelete()
    {
        $salary = UserSalary::find()->where(['user_id' => $this->id])->all();
        $wallets = Wallet::find()->where(['user_id' => $this->id])->all();
        $currencyWallet = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $this->id])->all();

        //foreach ($currencyWallet as $one) $one->delete();
        foreach ($salary as $one) $one->delete();
        foreach ($wallets as $one) $one->delete();

        return parent::beforeDelete();
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {

        $salary = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['currency_id' => 1])->andWhere(['wallet_type_id' => 1])->one();
        if ($salary !== null)
        {
            $salary->salary = $this->personalSalaryNFT;
            $salary->save();
        }

        $salary = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['currency_id' => 2])->andWhere(['wallet_type_id' => 1])->one();
        if ($salary !== null)
        {
            $salary->salary = $this->personalSalaryDig;
            $salary->save();
        }

        $salary = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['currency_id' => 1])->andWhere(['wallet_type_id' => 2])->one();
        if ($salary !== null)
        {
            $salary->salary = $this->virtualSalaryNFT;
            $salary->save();
        }

        $salary = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['currency_id' => 2])->andWhere(['wallet_type_id' => 2])->one();
        if ($salary !== null)
        {
            $salary->salary = $this->virtualSalaryDig;
            $salary->save();
        }

        if ($this->role_id != 1)
        {
            $wallet = new Wallet();
            if (Wallet::find()->where(['user_id' => $this->id])->andWhere(['type_id' => 1])->one() == null)
            {
                $wallet->type_id = 1;
                $wallet->user_id = $this->id;
                if ($insert)
                {
                    //создаем кошелек
                    $result = APIConnector::CreateWallet();
                    $wallet->publicKey = $result[0];
                    $wallet->privateKey = $result[1];
                    APIConnector::AddMantic(0.1, $result[0]);
                }
                $wallet->save();
                $currency_wallet = new CurrencyWallet();
                $currency_wallet->wallet_id = $wallet->id;
                $currency_wallet->currency_id = 1;
                $currency_wallet->save();

                $currency_wallet = new CurrencyWallet();
                $currency_wallet->wallet_id = $wallet->id;
                $currency_wallet->currency_id = 2;
                $currency_wallet->save();

                if (count(UserSalary::find()->where(['user_id' => $this->id])->andWhere(['wallet_type_id' => 1])->all()) == 0)
                {
                    $salary = new UserSalary();
                    $salary->user_id = $this->id;
                    $salary->currency_id = 1;
                    $salary->wallet_type_id = 1;
                    $salary->salary = $this->personalSalaryNFT;
                    $salary->save();

                    $salary = new UserSalary();
                    $salary->user_id = $this->id;
                    $salary->currency_id = 2;
                    $salary->wallet_type_id = 1;
                    $salary->salary = $this->personalSalaryDig;
                    $salary->save();
                }
            }
            

            if ($this->role_id != 4)
            {
                if (Wallet::find()->where(['user_id' => $this->id])->andWhere(['type_id' => 2])->one() == null)
                {
                    $wallet = new Wallet();
                    $wallet->type_id = 2;
                    $wallet->user_id = $this->id;
                    if ($insert)
                    {
                        $result = APIConnector::CreateWallet();
                        $wallet->publicKey = $result[0];
                        $wallet->privateKey = $result[1];
                        APIConnector::AddMantic(0.1, $result[0]);          
                    }
                    $wallet->save();
                    $currency_wallet = new CurrencyWallet();
                    $currency_wallet->wallet_id = $wallet->id;
                    $currency_wallet->currency_id = 1;
                    $currency_wallet->save();

                    $currency_wallet = new CurrencyWallet();
                    $currency_wallet->wallet_id = $wallet->id;
                    $currency_wallet->currency_id = 2;
                    $currency_wallet->save();

                    if (count(UserSalary::find()->where(['user_id' => $this->id])->andWhere(['wallet_type_id' => 2])->all()) == 0)
                    {
                        $salary = new UserSalary();
                        $salary->user_id = $this->id;
                        $salary->currency_id = 1;
                        $salary->wallet_type_id = 2;
                        $salary->salary = $this->virtualSalaryNFT;
                        $salary->save();

                        $salary = new UserSalary();
                        $salary->user_id = $this->id;
                        $salary->currency_id = 2;
                        $salary->wallet_type_id = 2;
                        $salary->salary = $this->virtualSalaryNFT;
                        $salary->save();
                    }
                }
            }
            else
            {
                $wallets = Wallet::find()->where(['user_id' => $this->id])->andWhere(['type_id' => 2])->all();
                $currencyWallet = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $this->id])->andWhere(['wallet.type_id' => 2])->all();
                foreach ($currencyWallet as $one) $one->delete();
                foreach ($wallets as $one) $one->delete();

                $salary = UserSalary::find()->where(['user_id' => $this->id])->andWhere(['wallet_type_id' => 2])->all();
                foreach ($salary as $one) $one->delete();
            }
        }
        else
        {
            $wallets = Wallet::find()->where(['user_id' => $this->id])->all();
            $currencyWallet = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $this->id])->all();
            //foreach ($currencyWallet as $one) $one->delete();
            //foreach ($wallets as $one) $one->delete();

            $salary = UserSalary::find()->where(['user_id' => $this->id])->all();
            //foreach ($salary as $one) $one->delete();
        }


        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

    }

    
}
