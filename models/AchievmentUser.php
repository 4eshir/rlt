<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "achievment_user".
 *
 * @property int $id
 * @property int $achievment_id
 * @property int $user_id
 *
 * @property Achievment $achievment
 * @property User $user
 */
class AchievmentUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'achievment_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['achievment_id', 'user_id'], 'required'],
            [['achievment_id', 'user_id'], 'integer'],
            [['achievment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Achievment::class, 'targetAttribute' => ['achievment_id' => 'id']],
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
            'achievment_id' => 'Achievment ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Achievment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAchievement()
    {
        return $this->hasOne(Achievment::class, ['id' => 'achievment_id']);
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

    public function addExp()
    {
        $user = User::find()->where(['id' => $this->user_id])->one();
        $user->addExp($this->achievement->count);
    }
}
