<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "achievment".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $count
 * @property string|null $picture
 * @property int $level_id
 *
 * @property AchievmentUser[] $achievmentUsers
 * @property Level $level
 */
class Achievment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'achievment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'count', 'level_id'], 'required'],
            [['count', 'level_id'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['description', 'picture'], 'string', 'max' => 1000],
            [['level_id'], 'exist', 'skipOnError' => true, 'targetClass' => Level::class, 'targetAttribute' => ['level_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'count' => 'Count',
            'picture' => 'Picture',
            'level_id' => 'Level ID',
        ];
    }

    /**
     * Gets query for [[AchievmentUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAchievmentUsers()
    {
        return $this->hasMany(AchievmentUser::class, ['achievment_id' => 'id']);
    }

    /**
     * Gets query for [[Level]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Level::class, ['id' => 'level_id']);
    }

    public function TrophyNo($user_id, $achievment_id)
    {
        $trophy = AchievmentUser::find()->where(['achievment_id' => $achievment_id])->andWhere(['user_id' => $user_id])->all();
        if (empty($trophy))
            return true;   // ачивки нет
        else
            return false;
    }

    public function Beggar($user_id)
    {
        if ($this->TrophyNo($user_id, 15))
        {
            $wallet = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $user_id])->andWhere(['wallet.type_id' => 1])->all();
            $moneyCount = 0;
            $flag = false;
            foreach ($wallet as $purse)
            {
                $moneyCount += $purse->count;
                if (!$flag)
                {
                    $history = HistoryWallet::find()->where(['currency_wallet_out_id' => $purse->id])->orWhere(['currency_wallet_in_id' => $purse->id])->all();
                    if (!empty($history))
                        $flag = true;
                }
            }

            if ($flag && $moneyCount == 0)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 15;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Rich($user_id)
    {
        if ($this->TrophyNo($user_id, 16))
        {
            $wallet = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $user_id])->andWhere(['wallet.type_id' => 1])->all();
            $moneyCount = 0;
            $flag = false;
            foreach ($wallet as $purse)
            {
                $moneyCount += $purse->count;
                if (!$flag)
                {
                    $history = HistoryWallet::find()->where(['currency_wallet_out_id' => $purse->id])->orWhere(['currency_wallet_in_id' => $purse->id])->all();
                    if (!empty($history))
                        $flag = true;
                }
            }

            if ($flag && $moneyCount >= 1000)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 16;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Spender($user_id)
    {
        if ($this->TrophyNo($user_id, 18))
        {
            $wallet = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $user_id])->andWhere(['wallet.type_id' => 1])->all();
            $walletID = [];
            foreach ($wallet as $current)
                $walletID[] = $current->id;
            $history = HistoryWallet::find()->where(['IN','currency_wallet_out_id', $walletID])->andWhere(['operation_id' => 8])->all();
            $moneyCount = 0;

            foreach ($history as $transaction)
                $moneyCount += $transaction->count;

            if ($moneyCount >= 1000)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 18;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Fire($user_id)
    {
        if ($this->TrophyNo($user_id, 14))
        {
            if (count(AchievmentUser::find()->where(['user_id' => $user_id])->all()) >= 15)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 14;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Apprentice($user_id)    // 1 проект обучения
    {
        if ($this->TrophyNo($user_id, 1))
        {
            if (count(TaskUserConfirm::find()->joinWith(['taskUser taskUser'])->where(['taskUser.user_id' => $user_id])->andWhere(['confirm' => 1])->all()) >= 1)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 1;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Student($user_id)      // 5 проектов обучения
    {
        if ($this->TrophyNo($user_id, 6))
        {
            if (count(TaskUserConfirm::find()->joinWith(['taskUser taskUser'])->where(['taskUser.user_id' => $user_id])->andWhere(['confirm' => 1])->all()) >= 5)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 6;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Professor($user_id)      // 10 проектов обучения
    {
        if ($this->TrophyNo($user_id, 11))
        {
            if (count(TaskUserConfirm::find()->joinWith(['taskUser taskUser'])->where(['taskUser.user_id' => $user_id])->andWhere(['confirm' => 1])->all()) >= 10)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 11;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Researcher($user_id)    // 1 командная работа
    {
        if ($this->TrophyNo($user_id, 2))
        {
            if (count(TeamUser::find()->joinWith(['team team'])->where(['user_id' => $user_id])->andWhere(['<=', 'team.date_finish', date("Y-m-d")])->andWhere(['team.status_id' => 2])->all()) >= 1)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 2;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Specialist($user_id)    // 5 команд работ
    {
        if ($this->TrophyNo($user_id, 7))
        {
            if (count(TeamUser::find()->joinWith(['team team'])->where(['user_id' => $user_id])->andWhere(['<=', 'team.date_finish', date("Y-m-d")])->andWhere(['team.status_id' => 2])->all()) >= 5)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 7;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        
        }
    }

    public function TeamSoul($user_id)    // 10 командная работа
    {
        if ($this->TrophyNo($user_id, 12))
        {
            if (count(TeamUser::find()->joinWith(['team team'])->where(['user_id' => $user_id])->andWhere(['<=', 'team.date_finish', date("Y-m-d")])->andWhere(['team.status_id' => 2])->all()) >= 10)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 12;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
            
        }
    }

    public function Dealer($user_id)    // продать 1 товар
    {
        if ($this->TrophyNo($user_id, 3))
        {
            if (count(ProductUser::find()->joinWith(['product product'])->select('product_id')->distinct()->where(['product.user_creator_id' => $user_id])->all()) >= 1)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 3;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Seller($user_id)    // продать 5 товар
    {
        if ($this->TrophyNo($user_id, 8))
        {
            if (count(ProductUser::find()->joinWith(['product product'])->select('product_id')->distinct()->where(['product.user_creator_id' => $user_id])->all()) >= 1)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 8;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Trader($user_id)    // продать 10 товар
    {
        if ($this->TrophyNo($user_id, 13))
        {
            if (count(ProductUser::find()->joinWith(['product product'])->select('product_id')->distinct()->where(['product.user_creator_id' => $user_id])->all()) >= 1)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 13;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Samaritan($user_id)
    {
        if ($this->TrophyNo($user_id, 17))
        {
            $wallet = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $user_id])->andWhere(['wallet.type_id' => 1])->all();
            $walletID = [];
            foreach ($wallet as $current)
                $walletID[] = $current->id;
            $history = HistoryWallet::find()->where(['IN','currency_wallet_out_id', $walletID])->andWhere(['operation_id' => 2])->all();
            $moneyCount = 0;

            foreach ($history as $transaction)
                $moneyCount += $transaction->count;

            if ($moneyCount >= 1000)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 17;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Mentor($user_id)        // создать 1 команду
    {
        if ($this->TrophyNo($user_id, 4))
        {
            if (count(Team::find()->where(['user_creator_id' => $user_id])->andWhere(['<=', 'date_finish', date("Y-m-d")])->andWhere(['status_id' => 2])->all()) >= 1)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 4;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Dux($user_id)        // создать 10 команду
    {
        if ($this->TrophyNo($user_id, 9))
        {
            if (count(Team::find()->where(['user_creator_id' => $user_id])->andWhere(['<=', 'date_finish', date("Y-m-d")])->andWhere(['status_id' => 2])->all()) >= 10)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 9;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Instigator($user_id)        // создать 1 проект обучения
    {
        if ($this->TrophyNo($user_id, 5))
        {
            if (count(TaskUserConfirm::find()->joinWith(['taskUser taskUser'])->joinWith(['taskUser.task task'])
                    ->where(['confirm' => 1])->andWhere(['task.user_creator_id' => $user_id])->all()) >= 1)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 5;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Ringleader($user_id)        // создать 10 проект обучения
    {
        if ($this->TrophyNo($user_id, 10))
        {
            if (count(TaskUserConfirm::find()->joinWith(['taskUser taskUser'])->joinWith(['taskUser.task task'])
                    ->where(['confirm' => 1])->andWhere(['task.user_creator_id' => $user_id])->all()) >= 10)
            {
                $reward = new AchievmentUser();
                $reward->achievment_id = 5;
                $reward->user_id = $user_id;
                $reward->save();
                $reward->addExp();
            }
        }
    }

    public function Fast($user_id)        // забрать последний товар
    {
        if ($this->TrophyNo($user_id, 20))
        {
            $reward = new AchievmentUser();
            $reward->achievment_id = 20;
            $reward->user_id = $user_id;
            $reward->save();
            $reward->addExp();
        }
    }

    public function Desperate($user_id)        // нехватает средств на покупку
    {
        if ($this->TrophyNo($user_id, 19))
        {
            $reward = new AchievmentUser();
            $reward->achievment_id = 19;
            $reward->user_id = $user_id;
            $reward->save();
            $reward->addExp();
        }
    }

    public function SpecialReward($user_id)
    {
        $this->Fast($user_id);
        $this->Desperate($user_id);
        $this->Fire($user_id);
    }

    public function MarketReward($user_id)
    {
        $this->Dealer($user_id);
        $this->Seller($user_id);
        $this->Trader($user_id);
        $this->Spender($user_id);
        $this->Fast($user_id);
        $this->Desperate($user_id);
        $this->Fire($user_id);
    }

    public function TeamReward($user_id)
    {
        $this->Researcher($user_id);
        $this->Specialist($user_id);
        $this->TeamSoul($user_id);
        $this->Mentor($user_id);
        $this->Dux($user_id);
        $this->Fire($user_id);
    }

    public function TaskReward($user_id)
    {
        $this->Apprentice($user_id);
        $this->Student($user_id);
        $this->Professor($user_id);
        $this->Instigator($user_id);
        $this->Ringleader($user_id);
        $this->Fire($user_id);
    }

    public function MonetaryReward($user_id)
    {
        $this->Beggar($user_id);
        $this->Rich($user_id);
        $this->Samaritan($user_id);
        $this->Fire($user_id);
    }
}
