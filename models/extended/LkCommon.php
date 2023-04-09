<?php

namespace app\models\extended;

use app\models\User;
use app\models\AchievmentUser;

use Yii;

class LkCommon extends \yii\base\Model
{
    public $user; // пользователь из БД
    public $achieves; // достижения
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
    }

    public function fill($id)
    {
        $user = User::find()->where(['id' => $id])->one();
        $achieves = AchievmentUser::find()->where(['user_id' => $id])->all();
        $this->user = $user;
        $this->achieves = $achieves;
    }

}
