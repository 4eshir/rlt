<?php

use app\models\Role;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/** @var yii\web\View $this */
/** @var app\models\SearchRole $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>

<style type="text/css">
    .header-text{
        font-size: 24px;
        font-weight: bold;
    }

    .div-float1{
        width: 45%;
        float: left;
        margin-right: 5%;
    }

    .div-float2{
        width: 45%;
        float: left;
        margin-right: 5%;
    }

    .container{

    }

    .container:after {
        content: " ";
        display: table;
        clear: both;
    }
</style>

<div class="lk-index">

    <div class="container" style="overflow-y: scroll; height: 400px">
        <div class="div-float1">
            <div style="margin-bottom: 10px;">
                <span class="header-text">История зачислений</span>
            </div>
            <?php 

            if (count($model->historyIn) > 0)
            {
                echo '<table class="table table-bordered"><tr><th>Перевод от пользователя</th><th>Тип операции</th><th>Сумма зачисления</th><th>Дата/Время</th></tr>';
                foreach ($model->historyIn as $his)
                {
                    $strCurrency = $his->currencyWalletOut->currency->name;
                    if ($his->operation_id == 6 && $his->currency_wallet_out_id == null) //резерв денег руководителем на выплаты за командную работу
                    {
                        echo '<tr><td>Начисление средств администратором</td>';
                        $strCurrency = $his->currencyWalletIn->currency->name;
                    }
                    else
                        echo '<tr><td>'.$his->currencyWalletIn->wallet->user->fullName.'</td>';

                    echo '<td>'.$his->operation->name.'</td><td>'.$his->count.' '.$strCurrency.'</td><td>'.$his->date_time.'</td></tr>';
                }
                echo '</table>';
            }
            else
                echo '<span>Здесь пока ничего нет...</span>';

            ?>
        </div>

        <div class="div-float2">
            <div style="margin-bottom: 10px;">
                <span class="header-text">История списаний</span>
            </div>
            <?php 

            if (count($model->historyOut) > 0)
            {
                echo '<table class="table table-bordered"><tr><th>Перевод пользователю</th><th>Тип операции</th><th>Сумма списания</th><th>Дата/Время</th></tr>';
                foreach ($model->historyOut as $his)
                {
                    $strCurrency = $his->currencyWalletIn->currency->name;
                    if ($his->operation_id == 4 && $his->currency_wallet_in_id == null) //резерв денег руководителем на выплаты за командную работу
                    {
                        echo '<tr><td>Резерв средств на выплаты</td>';
                        $strCurrency = $his->currencyWalletOut->currency->name;
                    }
                    else if ($his->operation_id == 6 && $his->currency_wallet_in_id == null) // списание средств администратором
                    {
                        echo '<tr><td>Списание средств администратором</td>';
                        $strCurrency = $his->currencyWalletOut->currency->name;
                    }
                    else
                        echo '<tr><td>'.$his->currencyWalletIn->wallet->user->fullName.'</td>';

                    echo '<td>'.$his->operation->name.'</td><td>'.$his->count.' '.$strCurrency.'</td><td>'.$his->date_time.'</td></tr>';
                }
                echo '</table>';
            }
            else
                echo '<span>Здесь пока ничего нет...</span>';

            ?>
        </div>
    </div>

    <div>
        <hr>
    </div>

    <div>
        <span class="header-text">Перевод другому сотруднику</span>
        <?php $form = ActiveForm::begin([
            'id' => 'user-form',
            'layout' => 'horizontal',
            'options' => ['style' => 'margin-top: 15px'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-2 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-4 form-control'],
                'errorOptions' => ['class' => 'col-lg-2 invalid-feedback'],
            ],
        ]); ?>

        <?php
        $role = \app\models\Currency::find()->all();
        $items = \yii\helpers\ArrayHelper::map($role,'id','name');
        $params = [];
        echo $form->field($model, "currency")->dropDownList($items,$params);

        ?>

        <?php
        $role = \app\models\User::find()->all();
        $items = \yii\helpers\ArrayHelper::map($role,'id','fullName');
        $params = [];
        echo $form->field($model, "user_id")->dropDownList($items,$params);

        ?>

        <?= $form->field($model, 'count')->textInput(['type' => 'number']) ?>
        

        <div class="form-group">
            <?= Html::submitButton('Перевести', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>





</div>