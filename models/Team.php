<?php

namespace app\models;
use yii\helpers\Html;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string $name
 * @property int $user_creator_id
 * @property int $currency_id
 * @property int $max_count
 * @property int $summary_cost
 * @property int $status_id
 * @property string $date_start
 * @property string $date_finish
 *
 * @property Currency $currency
 * @property Status $status
 * @property TeamUser[] $teamUsers
 * @property User $userCreator
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'user_creator_id', 'currency_id', 'max_count', 'summary_cost', 'status_id', 'date_start', 'date_finish'], 'required'],
            [['user_creator_id', 'currency_id', 'max_count', 'summary_cost'], 'integer'],
            [['date_start', 'date_finish', 'status_id'], 'safe'],
            [['name'], 'string', 'max' => 1000],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_creator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название команды',
            'user_creator_id' => 'Создатель команды',
            'creatorString' => 'Создатель команды',
            'currency_id' => 'Валюта для выплаты участникам',
            'currencyString' => 'Валюта для выплаты участникам',
            'max_count' => 'Максимум участников',
            'summary_cost' => 'Общая сумма вознаграждений',
            'status_id' => 'Статус командной работы',
            'statusString' => 'Запись в команду',
            'date_start' => 'Дата начала командной работы',
            'date_finish' => 'Дата окончания командной работы',
            'participants' => 'Члены команды',
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
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[TeamUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamUsers()
    {
        return $this->hasMany(TeamUser::class, ['team_id' => 'id']);
    }

    /**
     * Gets query for [[UserCreator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCreator()
    {
        return $this->hasOne(User::class, ['id' => 'user_creator_id']);
    }


    public function getCurrencyString()
    {
        return $this->currency->name;
    }

    public function getStatusString()
    {
        return $this->status_id == 1 ? 'Открыта' : 'Завершена';
    }

    public function getCreatorString()
    {
        return Html::a($this->userCreator->fullName, \yii\helpers\Url::to(['user/view', 'id' => $this->user_creator_id]));
    }


    public function getParticipants()
    {
        $teamUsers = TeamUser::find()->where(['team_id' => $this->id])->all();
        $res = '';
        foreach ($teamUsers as $one)
            $res .= Html::a($one->user->fullName, ['user/view', 'id' => $one->user_id]).'<br>';
        return $res;
    }

    public function beforeSave($insert)
    {
        if (!$insert)
        {
            $wallet = Wallet::find()->where(['type_id' => 2])->andWhere(['user_id' => $this->user_creator_id])->one();
            $currencyWallet = CurrencyWallet::find()->where(['wallet_id' => $wallet->id])->andWhere(['currency_id' => $this->currency_id])->one();
            $history = HistoryWallet::find()->where(['currency_wallet_out_id' => $currencyWallet->id])->andWhere(['is', 'currency_wallet_in_id', new \yii\db\Expression('null')])->andWhere(['team_id' => $this->id])->one();
            
            $prev = $history->count;
            $diff = $prev - $this->summary_cost;
            if ($currencyWallet->count + $diff < 0)
            {
                Yii::$app->session->setFlash('danger', 'Недостаточно средств на виртуальном кошельке!');
                return false;
            }
            $currencyWallet->count += $diff;
            $currencyWallet->save();
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (count($changedAttributes) > 1) //если не выплата денег
        {
            $wallet = Wallet::find()->where(['type_id' => 2])->andWhere(['user_id' => Yii::$app->user->identity->getId()])->one();
            $currencyWallet = CurrencyWallet::find()->where(['wallet_id' => $wallet->id])->andWhere(['currency_id' => $this->currency_id])->one();
            $history = HistoryWallet::find()->where(['currency_wallet_out_id' => $currencyWallet->id])->andWhere(['is', 'currency_wallet_in_id', new \yii\db\Expression('null')])->andWhere(['team_id' => $this->id])->one();

            $prev = 0;
            if ($history == null)
            {
                $history = new HistoryWallet();
                $history->currency_wallet_out_id = $currencyWallet->id;
                $history->currency_wallet_in_id = null;
                $history->operation_id = 4;
                $history->team_id = $this->id;
            }
            else
                $prev = $history->count;


            $history->count = $this->summary_cost;
            $history->date_time = date('Y-m-d h:i:s');

            $history->save();



            parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        }
        
    }
}
