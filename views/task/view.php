<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Task $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ивенты онбординга', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->identity->getId() == $model->user_creator_id) {
            echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]); 
        } ?>
        <?php 

        $joins = app\models\TaskUser::find()->where(['user_id' => Yii::$app->user->identity->getId()])->andWhere(['task_id' => $model->id])->orderBy(['id' => SORT_DESC])->all();
        $complete = app\models\TaskUserConfirm::find()->joinWith(['taskUser taskUser'])->where(['taskUser.task_id' => $model->id])->andWhere(['taskUser.user_id' => Yii::$app->user->identity->getId()])->all();
        $f_check = true;
        foreach ($complete as $one)
            if ($one->confirm == false)
                $f_check = false;


        if (count($joins) == 0 || count($complete) == count($joins) && $f_check)
            echo Html::a('Участвовать в ивенте', ['join', 'id' => $model->id], ['class' => 'btn btn-success']);
        else if ((count($complete) == 0 || count($complete) < count($joins)) && $f_check)
        {
            echo Html::a('Выйти из ивента', ['quit', 'id' => $model->id], ['class' => 'btn btn-warning']);
            echo Html::a('Завершить ивент', ['complete', 'id' => $model->id], ['class' => 'btn btn-success', 'style' => 'margin-left: 5px']);
        }
        else if (!$f_check)
        {
            echo Html::a('Выйти из ивента', ['quit', 'id' => $model->id], ['class' => 'btn btn-warning']);
        }
        else if ($model->repeat == 1)
            echo Html::a('Участвовать в ивенте', ['join', 'id' => $model->id], ['class' => 'btn btn-success']);
        else
            echo '<span style="color: red; margin-left: 10px">Вы уже выполнили этот ивент</span>';


        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'currencyString',
            'price',
            'repeatString',
            ['attribute' => 'creatorString', 'format' => 'raw'],
            'statusString',
            'date_start',
            'date_finish',
        ],
    ]) ?>

    <?php

    $join = app\models\TaskUser::find()->where(['task_id' => $model->id])->all();
    if (count($join) > 0)
    {
        echo '<h5><u>В ивенте</u></h5>';
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                ['attribute' => 'joiners', 'format' => 'raw'],
            ],
        ]);
    }

    ?>



    <?php

    $join = app\models\TaskUserConfirm::find()->joinWith(['taskUser taskUser'])->where(['taskUser.task_id' => $model->id])->all();
    if (count($join) > 0)
    {
        echo '<h5><u>Выполнили ивент</u></h5>';
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                ['attribute' => 'completed', 'format' => 'raw'],
            ],
        ]);
    }

    ?>

</div>
