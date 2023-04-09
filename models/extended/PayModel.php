<?php

namespace app\models\extended;

use app\models\CurrencyWallet;
use app\models\TeamUser;
use app\models\Wallet;
use app\models\HistoryWallet;
use app\models\Team;

use Yii;

class PayModel extends \yii\base\Model
{
    public $cost; //TeamUser - участники команды
    public $id; //идентификатор команды

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cost', 'id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cost' => 'Оплата',
        ];
    }

    /**
     * Gets query for [[Achievments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function save()
    {
        for ($i = 0; $i < count($this->cost); $i++)
            if ($this->cost[$i] == '')
                $this->cost[$i] = 0;

        $sum = 0;
        for ($i = 0; $i < count($this->cost); $i++)
            $sum += $this->cost[$i];

        $team = Team::find()->where(['id' => $this->id])->one();
        if ($sum > $team->summary_cost)
        {
            Yii::$app->session->setFlash('danger', 'Введеное количество валюты превышает максимально допустимое количество для текущей командной работы');
            return;
        }
        $parts = TeamUser::find()->where(['team_id' => $this->id])->orderBy(['user_id' => SORT_ASC])->all();
        for ($i = 0; $i < count($parts); $i++)
        {
            $user = Wallet::find()->where(['user_id' => $parts[$i]->user_id])->andWhere(['type_id' => 1])->one();
            $wallet = CurrencyWallet::find()->where(['wallet_id' => $user->id])->andWhere(['currency_id' => $parts[$i]->team->currency_id])->one();

            if ($wallet != null)
            {
                $wallet->count += $this->cost[$i];
                $wallet->save();
            }

            $team->summary_cost -= $this->cost[$i];
            $team->save();

            //запись в историю транзакций
            $team = Team::find()->where(['id' => $this->id])->one();
            $wallet = Wallet::find()->where(['type_id' => 2])->andWhere(['user_id' => $team->user_creator_id])->one();
            $currencyWallet = CurrencyWallet::find()->where(['wallet_id' => $wallet->id])->andWhere(['currency_id' => $team->currency_id])->one();

            $wallet2 = Wallet::find()->where(['type_id' => 1])->andWhere(['user_id' => $parts[$i]->user_id])->one();
            $currencyWallet2 = CurrencyWallet::find()->where(['wallet_id' => $wallet2->id])->andWhere(['currency_id' => $team->currency_id])->one();


            APIConnector::ExchangeCoins($this->cost[$i], $wallet->privateKey, $wallet->publicKey, $wallet2->publicKey, $parts[$i]->team->currency_id);


            $history = HistoryWallet::find()->where(['currency_wallet_out_id' => $currencyWallet->id])->andWhere(['currency_wallet_in_id' => $currencyWallet2->id])->andWhere(['team_id' => $this->id])->one();


            if ($history == null)
            {
                $history = new HistoryWallet();
                $history->currency_wallet_out_id = $currencyWallet->id;
                $wallet1 = Wallet::find()->where(['type_id' => 1])->andWhere(['user_id' => $parts[$i]->user_id])->one();
                $currencyWallet1 = CurrencyWallet::find()->where(['wallet_id' => $wallet1->id])->andWhere(['currency_id' => $team->currency_id])->one();
                $history->currency_wallet_in_id = $currencyWallet1->id;
                $history->operation_id = 4;
                $history->team_id = $this->id;
                $history->count = $this->cost[$i];
            }
            else
                $history->count += $this->cost[$i];
            $history->date_time = date('Y-m-d h:i:s');
            $history->save();
        }
    }
}
