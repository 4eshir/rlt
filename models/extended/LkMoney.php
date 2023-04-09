<?php

namespace app\models\extended;

use app\models\Wallet;
use app\models\CurrencyWallet;
use app\models\HistoryWallet;
use app\models\extended\APIConnector;

use Yii;

class LkMoney extends \yii\base\Model
{
    public $historyIn; // история зачислений на счета пользователя
    public $historyOut; // история списаний со счета пользователя

    public $count; //количество средств для перевода
    public $currency; //тип переводимых средств
    public $user_id; //id пользователя, которому переводятся средства

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count', 'currency', 'user_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'count' => 'Кол-во InGameCur/Rubles',
            'currency' => 'Тип валюты',
            'user_id' => 'Сотрудник',
        ];
        
    }

    public function fill($id)
    {
        $wallet = Wallet::find()->where(['user_id' => $id])->all();
        $currencyWallet = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $id])->all();
        $this->historyIn = HistoryWallet::find()->joinWith(['currencyWalletIn currencyWalletIn'])->joinWith(['currencyWalletIn.wallet wallet'])->where(['wallet.user_id' => $id])->all();
        $this->historyOut = HistoryWallet::find()->joinWith(['currencyWalletOut currencyWalletOut'])->joinWith(['currencyWalletOut.wallet wallet'])->where(['wallet.user_id' => $id])->all();
    }

    public function save($query)
    {
        $wallet1 = Wallet::find()->where(['user_id' => Yii::$app->user->identity->getId()])->andWhere(['type_id' => 1])->one();
        $currencyWallet1 = CurrencyWallet::find()->where(['wallet_id' => $wallet1->id])->andWhere(['currency_id' => $query["LkMoney"]["currency"]])->one();


        $wallet2 = Wallet::find()->where(['user_id' => $query["LkMoney"]["user_id"]])->andWhere(['type_id' => 1])->one();
        $currencyWallet2 = CurrencyWallet::find()->where(['wallet_id' => $wallet2->id])->andWhere(['currency_id' => $query["LkMoney"]["currency"]])->one();


        $currencyWallet1->count -= $query["LkMoney"]["count"];
        $currencyWallet2->count += $query["LkMoney"]["count"];

        $currencyWallet1->save();
        $currencyWallet2->save();

        APIConnector::ExchangeCoins($query["LkMoney"]["count"], $wallet1->privateKey, $wallet1->publicKey, $wallet2->publicKey, $query["LkMoney"]["currency"]);

        $history = new HistoryWallet();

        $history->currency_wallet_out_id = $currencyWallet1->id;
        $history->currency_wallet_in_id = $currencyWallet2->id;
        $history->operation_id = 2;
        $history->count = $query["LkMoney"]["count"];
        $history->date_time = date('Y-m-d h:i:s');
        $history->save();
    }
}
