<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_salary".
 *
 * @property int $id
 * @property int $user_id
 * @property int $currency_id
 * @property int $wallet_type_id
 * @property int $salary
 *
 * @property Currency $currency
 * @property User $user
 * @property TypeWallet $walletType
 */
class UserSalary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_salary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'currency_id', 'wallet_type_id'], 'required'],
            [['user_id', 'currency_id', 'wallet_type_id', 'salary'], 'integer'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['wallet_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeWallet::class, 'targetAttribute' => ['wallet_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'currency_id' => 'Currency ID',
            'wallet_type_id' => 'Wallet Type ID',
            'salary' => 'Salary',
        ];
    }

    /**
     * Gets query for [[Currency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[WalletType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWalletType()
    {
        return $this->hasOne(TypeWallet::class, ['id' => 'wallet_type_id']);
    }
}
