<?php

use app\models\Role;
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

    .div-float1{
        width: 55%;
        float: left;
        margin-right: 5%;
    }

    .div-float2{
        width: 35%;
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

    <div class="container">
        <div class="div-float1">
            <div style="margin-bottom: 10px;">
                <span class="header-text">Ивенты онбординга</span>
            </div>
            <?php 

            if (count($model->tasks) > 0)
            {
                echo '<table class="table table-striped">';
                foreach ($model->tasks as $task)
                {
                    $strFinish = '';
                    $taskUsers = app\models\TaskUser::find()->where(['task_id' => $task->id])->all();
                    $confirm = app\models\TaskUserConfirm::find()->joinWith(['taskUser taskUser'])->where(['taskUser.task_id' => $task->id])->andWhere(['taskUser.user_id' => Yii::$app->user->identity->getId()])->orderBy(['id' => SORT_DESC])->all();
                    if (count($confirm) > 1 && $confirm[0]->confirm == 0)
                        $strFinish = '<span style="color:green">Выполнение подтверждено: '.(count($confirm) - 1).'</span><br><span style="color:orange">Ожидает подтверждения: 1</span><br><span style="color:blue">Выполняется: '.(count($taskUsers) - count($confirm)).'</span>';
                    else if (count($confirm) > 1)
                        $strFinish = '<span style="color:green">Выполнение подтверждено: '.count($confirm).'</span><br><span style="color:blue">Выполняется: '.(count($taskUsers) - count($confirm)).'</span>';
                    else
                    {
                        if (count($confirm) == 0)
                            $strFinish = '<span style="color:blue">Выполняется</span>';
                        else if ($confirm[0]->confirm == 0) $strFinish = '<span style="color:orange">Ожидает подтверждения</span>';
                        else $strFinish = '<span style="color:green">Выполнение подтверждено</span>';
                    }

                    echo '<tr><td style="width: 30%">'.Html::a($task->name, ['task/view', 'id' => $task->id]).'</td><td style="width: 25%">'.explode(" ", $task->date_start)[0].' &mdash; '.explode(" ", $task->date_finish)[0].'</td><td style="width: 45%">'.$strFinish.'</td></tr>';
                }
                echo '</table>';
            }

            ?>
        </div>

        <div class="div-float2">
            <div style="margin-bottom: 10px;">
                <span class="header-text">Деловые игры</span>
            </div>
            <?php 

            if (count($model->teams) > 0)
            {
                echo '<table class="table table-striped">';
                foreach ($model->teams as $team)
                {
                    $strfinish = '<span style="color:green">Игра завершена</span>';
                    echo '<tr><td>'.Html::a($team->name, ['business-game/view', 'id' => $team->id]).'</td><td>'.explode(" ", $team->start_date)[0].' &mdash; '.explode(" ", $team->end_date)[0].'</td><td>'.$strfinish.'</td></tr>';
                }
                echo '</table>';
            }

            ?>
        </div>
    </div>





</div>