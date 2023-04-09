<?php

use app\models\Role;
use app\models\Wallet;
use app\models\CurrencyWallet;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SearchRole $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>

<style type="text/css">
    .header-text{
        font-size: 24px;
        font-weight: bold;
    }

    .div-float{
        width: 35%;
        float: left;
    }

    .div-last{
        width: 25%;
        margin-left: 1%;
        float: left;
    }

    .container{

    }

    .container:after {
        content: " ";
        display: table;
        clear: both;
    }

    IMG.displayed {
        display: block;
        margin-left: 20%;
        margin-right: 50%;
    }

    .level-span{
        display: inline-block;
        border-radius: 50%;
        background-color: gold;
        border: 2px solid black;
        max-height: 32px;
        max-width: 32px;
        min-height: 32px;
        min-width: 32px;
        align: center;
        line-height: 32px;
        text-align: center;
        margin-bottom: 20px;
        font-family: 'Bookman Old Style';
        font-size: 18px;
        font-weight: bold;
    }

    .progressbar { 
        padding-top: 20px;        
        display: inline-block;
        height: 25px;
        position: relative;
        background: #555;
        padding: 3px;
        box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
        width: 80%;
        border-radius: 7px;
    }

    .progressbar > span {
      display: block;
      height: 100%;
      background-color: gold;
      background-image: linear-gradient(
        center bottom,
        rgb(43,194,83) 37%,
        rgb(84,240,84) 69%
      );
      box-shadow: 
        inset 0 2px 9px  rgba(255,255,255,0.3),
        inset 0 -2px 6px rgba(0,0,0,0.4);
      position: relative;
      overflow: hidden;
      border-radius: 7px;
    }
</style>

<div class="container">

    <div class="div-float">
        <div style="width: 70%">
            <img src="/upload/avatar.png" height="150" class="displayed" style="border: 1px solid #DCDCDC; margin-bottom: 20px; border-radius: 15px">
            <div>
                <span class="level-span"><?php echo $model->user->levelNumber[0]; ?></span>
                <div class="progressbar">
                    <span style="width: <?php echo $model->user->levelNumber[1]; ?>%"></span>
                </div>
            </div>
            
        </div>
        <table class="table table-invisible" style="width: 80%">
            <tr style="width: 70%">
                <td><b>Фамилия</b></td>
                <td><?php echo $model->user->secondname; ?></td>
            </tr>
            <tr style="width: 70%">
                <td><b>Имя</b></td>
                <td><?php echo $model->user->firstname; ?></td>
            </tr>
            <tr style="width: 70%">
                <td><b>Логин</b></td>
                <td><?php echo $model->user->username; ?></td>
            </tr>
            <tr style="width: 70%">
                <td><b>Тип организации</b></td>
                <td><?php echo $model->user->typeOrg->name; ?></td>
            </tr>
            <tr style="width: 70%">
                <td><b>Роль в системе</b></td>
                <td><?php echo $model->user->role->name; ?></td>
            </tr>
        </table>
    </div>
    
    <div class="div-float">
        <div style="margin-bottom: 10px;">
            <span class="header-text">Достижения</span>
        </div>
        <?php

        if (count($model->achieves) > 0)
        {
            echo  '<div style="overflow-y: scroll">';
            echo '<table class="table table-condensed" style="height: 200px">';
            foreach ($model->achieves as $achieve)
                echo '<tr><td style="width: 64px;"><img src="'.$achieve->achievement->picture.'" width="64" height="64"></td>
                    <td style="padding-top: 30px;"><span title="'.$achieve->achievement->description.'">'.$achieve->achievement->name.'</span></td>
                    <td style="padding-top: 30px;"> + '.$achieve->achievement->count.' очков</td></tr>';
            echo '</table>';
            echo '</div>';
        }
        else
            echo '<span>Здесь пока ничего нет...</span>';

        ?>
    </div>

    <div class="div-last">
        <div style="margin-bottom: 10px;">
            <span class="header-text">Кошелек</span>
        </div>
        <?php
        $wallet1 = Wallet::find()->where(['type_id' => 1])->andWhere(['user_id' => $model->user->id])->one();
        $wallet2 = Wallet::find()->where(['type_id' => 2])->andWhere(['user_id' => $model->user->id])->one();

        $currencyWallet11 = CurrencyWallet::find()->where(['wallet_id' => $wallet1->id])->andWhere(['currency_id' => 1])->one();
        $currencyWallet12 = CurrencyWallet::find()->where(['wallet_id' => $wallet1->id])->andWhere(['currency_id' => 2])->one();

        if ($wallet2 !== null)
        {
            $currencyWallet21 = CurrencyWallet::find()->where(['wallet_id' => $wallet2->id])->andWhere(['currency_id' => 1])->one();
            $currencyWallet22 = CurrencyWallet::find()->where(['wallet_id' => $wallet2->id])->andWhere(['currency_id' => 2])->one();
        }
        ?>
        <table class="table table-bordered">
            <tr>
                <td>Личный кошелек</td>
                <td><?php echo $currencyWallet11->count.' IGC' ?></td>
                <td><?php echo $currencyWallet12->count.' Rub' ?></td>
            </tr>
            <?php 
            if ($wallet2 !== null) {
            ?>
                <tr>
                    <td>Виртуальный кошелек</td>
                    <td><?php echo $currencyWallet21->count.' IGC' ?></td>
                    <td><?php echo $currencyWallet22->count.' Rub' ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>





</div>