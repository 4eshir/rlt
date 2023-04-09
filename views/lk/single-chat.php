<?php

use app\models\Role;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SearchRole $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Чаты';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="tabs">
    <?php 
    if ($model[0]->user_in_id == Yii::$app->user->identity->getId())
        echo '<h3>Входящие сообщения</h3>';
    else if ($model[0]->user_out_id == Yii::$app->user->identity->getId())
        echo '<h3>Исходящие сообщения</h3>';
    else
        echo '<h3>Нет сообщений</h3>';
    ?>

    <table class="table table-condensed" style="margin-top: 30px">
        <?php
        echo '<tr style="font-weight: bold"><td>Дата и время отправки</td><td>Сообщение</td>';
        if ($model[0]->user_in_id == Yii::$app->user->identity->getId())
            echo '<td>От кого</td>';
        if ($model[0]->user_out_id == Yii::$app->user->identity->getId())
            echo '<td>Кому адресовано</td>';
        echo '</tr>';

        foreach ($model as $message)
        {
            echo '<tr>';
            echo '<td>'.$message->datetime.'</td>';
            echo '<td>'.$message->text.'</td>';
            if ($message->user_in_id == Yii::$app->user->identity->getId())
                echo '<td>'.$message->userOut->fullName.'</td>';
            if ($message->user_out_id == Yii::$app->user->identity->getId())
                echo '<td>'.$message->userIn->fullName.'</td>';
        }
        ?>
    </table>
</div>
