<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history_wallet".
 *
 * @property int $id
 * @property int|null $currency_wallet_out_id
 * @property int|null $currency_wallet_in_id
 * @property int $operation_id
 * @property int $count
 * @property string $date_time
 *
 * @property CurrencyWallet $currencyWalletIn
 * @property CurrencyWallet $currencyWalletOut
 * @property Operation $operation
 */
class HistoryWallet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history_wallet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currency_wallet_out_id', 'currency_wallet_in_id', 'operation_id', 'count'], 'integer'],
            [['operation_id', 'count', 'date_time'], 'required'],
            [['date_time'], 'safe'],
            [['currency_wallet_in_id'], 'exist', 'skipOnError' => true, 'targetClass' => CurrencyWallet::class, 'targetAttribute' => ['currency_wallet_in_id' => 'id']],
            [['currency_wallet_out_id'], 'exist', 'skipOnError' => true, 'targetClass' => CurrencyWallet::class, 'targetAttribute' => ['currency_wallet_out_id' => 'id']],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::class, 'targetAttribute' => ['operation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency_wallet_out_id' => 'Currency Wallet Out ID',
            'currency_wallet_in_id' => 'Currency Wallet In ID',
            'operation_id' => 'Operation ID',
            'count' => 'Count',
            'date_time' => 'Date Time',
        ];
    }

    /**
     * Gets query for [[CurrencyWalletIn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyWalletIn()
    {
        return $this->hasOne(CurrencyWallet::class, ['id' => 'currency_wallet_in_id']);
    }

    /**
     * Gets query for [[CurrencyWalletOut]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyWalletOut()
    {
        return $this->hasOne(CurrencyWallet::class, ['id' => 'currency_wallet_out_id']);
    }

    /**
     * Gets query for [[Operation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Operation::class, ['id' => 'operation_id']);
    }
}
