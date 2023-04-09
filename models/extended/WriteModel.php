<?php

namespace app\models\extended;

use app\models\TeamUser;
use app\models\TaskUser;
use app\models\Task;
use app\models\Chat;

use Yii;

class WriteModel extends \yii\base\Model
{
    public $user_id;
    public $text;

    public function rules()
    {
        return [
            [['user_id', 'text'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
    }

    public function save($query)
    {
        $message = new Chat();
        $message->user_out_id = Yii::$app->user->identity->getId();
        $message->user_in_id = $query["WriteModel"]["user_id"];
        $message->datetime = date('Y-m-d h:i:s');
        $message->text = $query["WriteModel"]["text"];
        $message->save();
        var_dump($message->getErrors());
    }
    
}
