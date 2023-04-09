<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currency_wallet".
 *
 * @property int $id
 * @property int $wallet_id
 * @property int $currency_id
 * @property int $count
 *
 * @property Currency $currency
 * @property HistoryWallet[] $historyWallets
 * @property HistoryWallet[] $historyWallets0
 * @property Wallet $wallet
 */
class CurrencyWallet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency_wallet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wallet_id', 'currency_id'], 'required'],
            [['wallet_id', 'currency_id', 'count'], 'integer'],
            [['wallet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wallet::class, 'targetAttribute' => ['wallet_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wallet_id' => 'Wallet ID',
            'currency_id' => 'Currency ID',
            'count' => 'Count',
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
     * Gets query for [[HistoryWallets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryWallets()
    {
        return $this->hasMany(HistoryWallet::class, ['currency_wallet_in_id' => 'id']);
    }

    /**
     * Gets query for [[HistoryWallets0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryWallets0()
    {
        return $this->hasMany(HistoryWallet::class, ['currency_wallet_out_id' => 'id']);
    }

    /**
     * Gets query for [[Wallet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWallet()
    {
        return $this->hasOne(Wallet::class, ['id' => 'wallet_id']);
    }
}
