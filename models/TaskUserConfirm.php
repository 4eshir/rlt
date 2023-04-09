<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_user_confirm".
 *
 * @property int $id
 * @property int $user_hr_id
 * @property int $task_user_id
 * @property string $date
 * @property int $confirm
 *
 * @property TaskUser $taskUser
 * @property User $userHr
 */
class TaskUserConfirm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_user_confirm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_hr_id', 'task_user_id', 'date'], 'required'],
            [['user_hr_id', 'task_user_id', 'confirm'], 'integer'],
            [['date'], 'safe'],
            [['task_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskUser::class, 'targetAttribute' => ['task_user_id' => 'id']],
            [['user_hr_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_hr_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_hr_id' => 'User Hr ID',
            'task_user_id' => 'Task User ID',
            'date' => 'Date',
            'confirm' => 'Confirm',
        ];
    }

    /**
     * Gets query for [[TaskUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskUser()
    {
        return $this->hasOne(TaskUser::class, ['id' => 'task_user_id']);
    }

    /**
     * Gets query for [[UserHr]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserHr()
    {
        return $this->hasOne(User::class, ['id' => 'user_hr_id']);
    }
}
