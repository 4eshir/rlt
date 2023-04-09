<?php

namespace app\models\extended;

use app\models\CurrencyWallet;

use Yii;

class AddCoinsModel extends \yii\base\Model
{
    public $walletType;
    public $currencyType;
    public $count;
    public $user_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['walletType', 'currencyType', 'count', 'user_id'], 'required'],
            [['walletType', 'currencyType', 'count', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'walletType' => 'Тип кошелька',
            'currencyType' => 'Тип валюты',
            'count' => 'Кол-во NFT-сертификатов/монет',
        ];
    }

    /**
     * Gets query for [[Achievments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function save()
    {
        $wallet = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $this->user_id])->andWhere(['wallet.type_id' => $this->walletType])->andWhere(['currency_id' => $this->currencyType])->one();

        if ($wallet !== null)
        {
            $wallet->count += $this->count;
            $wallet->save();
        }
    }
}
