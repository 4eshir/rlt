<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "step_user".
 *
 * @property int $id
 * @property int $step_id
 * @property int $user_id
 * @property string $log
 * @property int $end_key
 *
 * @property Step $step
 * @property User $user
 */
class StepUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'step_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['step_id', 'user_id', 'log', 'end_key'], 'required'],
            [['step_id', 'user_id', 'end_key'], 'integer'],
            [['log'], 'string'],
            [['step_id'], 'exist', 'skipOnError' => true, 'targetClass' => Step::class, 'targetAttribute' => ['step_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'step_id' => 'Step ID',
            'user_id' => 'User ID',
            'log' => 'Log',
            'end_key' => 'End Key',
        ];
    }

    /**
     * Gets query for [[Step]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStep()
    {
        return $this->hasOne(Step::class, ['id' => 'step_id']);
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
}
