<?php

namespace app\models\extended;

use app\models\extended\LkCommon;
use app\models\extended\LkMoney;
use app\models\extended\LkMyProduct;
use app\models\extended\LkOrders;
use app\models\extended\LkTaskTeam;
use Yii;

class LkModel extends \yii\base\Model
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
            [['commonInfo', 'taskTeamInfo', 'ordersInfo', 'myProductInfo', 'moneyInfo'], 'safe'],
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
        $this->commonInfo = new LkCommon();
        $commonInfo = $this->commonInfo->fill($id);
        $this->taskTeamInfo = new LkTaskTeam();
        $taskTeamInfo = $this->taskTeamInfo->fill($id);
        $this->ordersInfo = new LkOrders();
        $ordersInfo = $this->ordersInfo->fill($id);
        $this->myProductInfo = new LkMyProduct();
        $myProductInfo = $this->myProductInfo->fill($id);
        $this->moneyInfo = new LkMoney();
        $moneyInfo = $this->moneyInfo->fill($id);
    }

}
