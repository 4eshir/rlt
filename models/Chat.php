<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $user_out_id
 * @property int $user_in_id
 * @property string $text
 * @property string $datetime
 * 
 * @property User $userOut
 * @property User $userIn
 */
class Chat extends \yii\db\ActiveRecord
{
    public $type; //входящие/исходящие сообщения
    public $user_id; //id пользователя для поиска сообщений
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_out_id', 'user_in_id', 'text', 'datetime'], 'required'],
            [['user_out_id', 'user_in_id'], 'integer'],
            [['datetime', 'type', 'user_id'], 'safe'],
            [['text'], 'string', 'max' => 2000],
        ];
    }


    public function getUserOut()
    {
        return $this->hasOne(User::class, ['id' => 'user_out_id']);
    }

    public function getUserIn()
    {
        return $this->hasOne(User::class, ['id' => 'user_in_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_out_id' => 'User Out ID',
            'user_in_id' => 'User In ID',
            'text' => 'Text',
            'datetime' => 'Datetime',
        ];
    }

    public function saveNew($query)
    {
        return $query;
    }
}
