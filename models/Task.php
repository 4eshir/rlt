<?php

namespace app\models;
use yii\helpers\Html;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $name
 * @property int $currency_id
 * @property int $price
 * @property int $repeat
 * @property int $user_creator_id
 * @property int $status_id
 * @property string $date_start
 * @property string|null $date_finish
 *
 * @property Currency $currency
 * @property Status $status
 * @property TaskUser[] $taskUsers
 * @property User $userCreator
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'currency_id', 'price', 'repeat', 'user_creator_id', 'status_id', 'date_start'], 'required'],
            [['currency_id', 'price', 'repeat', 'user_creator_id', 'status_id'], 'integer'],
            [['date_start', 'date_finish'], 'safe'],
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
            'name' => 'Название ивента',
            'currency_id' => 'Валюта для выплаты участникам',
            'currencyString' => 'Валюта для выплаты участникам',
            'price' => 'Сумма вознаграждения',
            'repeat' => 'Возможность повторного выполнения',
            'repeatString' => 'Возможность повторного выполнения',
            'user_creator_id' => 'Создатель ивента',
            'creatorString' => 'Создатель ивента',
            'status_id' => 'Статус ивента',
            'statusString' => 'Статус ивента',
            'date_start' => 'Дата начала',
            'date_finish' => 'Дата окончания',
            'joiners' => 'Проходят ивент',
            'completed' => 'Завершили ивент',
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
     * Gets query for [[TaskUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskUsers()
    {
        return $this->hasMany(TaskUser::class, ['task_id' => 'id']);
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

    public function getRepeatString()
    {
        return $this->repeat == 1 ? 'Присутствует' : 'Отсутствует';
    }

    public function getStatusString()
    {
        return $this->status_id == 1 ? 'Открыта' : 'Завершена';
    }

    public function getCreatorString()
    {
        return Html::a($this->userCreator->fullName, \yii\helpers\Url::to(['user/view', 'id' => $this->user_creator_id]));
    }


    public function getJoiners()
    {
        $taskUsers = TaskUser::find()->where(['task_id' => $this->id])->all();
        $res = '';
        foreach ($taskUsers as $one)
            $res .= Html::a($one->user->secondname.' '.$one->user->firstname.' ('.$one->user->username.')', ['user/view', 'id' => $one->user_id]).'<br>';
        return $res;
    }

    public function getCompleted()
    {
        $taskUsers = TaskUserConfirm::find()->joinWith(['taskUser taskUser'])->where(['taskUser.task_id' => $this->id])->all();
        $res = '';
        foreach ($taskUsers as $one)
        {
            $user =  User::find()->where(['id' => Yii::$app->user->identity->getId()])->one();
            $str = $one->confirm == 0 ? '<span style="color: red"><i>(не подтверждено)</i></span>' : '<span style="color: green"><i>(подтверждено)</i></span>';
            if ($user->role_id == 1 && $one->confirm == 0)
                $str .= '<a class="btn btn-success" href="/index.php?r=task/confirm&id='.$one->id.'" style="margin-left: 10px">Подтвердить</a>';
            $res .= Html::a($one->taskUser->user->secondname.' '.$one->taskUser->user->firstname.' ('.$one->taskUser->user->username.')', ['user/view', 'id' => $one->taskUser->user_id]).' '.$str.'<br>';
        }
        return $res;
    }
}
