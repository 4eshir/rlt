<?php

namespace app\models\extended;

use Yii;

class LkMyProduct extends \yii\base\Model
{
    public $commonInfo; //данные для вкладки "Общая информация"
    public $taskTeamInfo; // данные для вкладки "Задачи и команды"
    public $ordersInfo; // данные для вкладки "Мои заказы"
    public $myProductInfo; // данные для вкладки "Мои товары"
    public $moneyInfo; // данные для вкладки "История и переводы"
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['commonInfo', 'taskTeamInfo', 'ordersInfo', 'myProductInfo', 'moneyInfo'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
    }

    public function fill($id)
    {
    }
}
