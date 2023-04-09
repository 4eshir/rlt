<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Team $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Командные задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="team-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->identity->getId() == $model->user_creator_id) { ?>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php
            if ($model->status_id == 2)
                echo Html::a('Выплатить вознаграждение', ['pay', 'id' => $model->id], ['class' => 'btn btn-info']);
            ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
        <?php

        $teamUsers = app\models\TeamUser::find()->where(['team_id' => $model->id])->all();
        $ids = [];
        foreach ($teamUsers as $one) $ids[] = $one->user_id;
        if (count($teamUsers) < $model->max_count && gettype(array_search(Yii::$app->user->identity->getId(), $ids)) == 'boolean')
            echo Html::a('Вступить в команду', ['join', 'id' => $model->id], ['class' => 'btn btn-success']);
        else if (gettype(array_search(Yii::$app->user->identity->getId(), $ids)) == 'integer')
            echo Html::a('Покинуть команду', ['quit', 'id' => $model->id], ['class' => 'btn btn-warning']);
        
        if (count($teamUsers) >= $model->max_count)
            echo '<span style="color: red; margin-left: 10px">Запись в команду окончена</span>';

        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            ['attribute' => 'creatorString', 'format' => 'raw'],
            'currencyString',
            'max_count',
            'summary_cost',
            'statusString',
            'date_start',
            'date_finish',
        ],
    ]) ?>

    <?php

    if (count($teamUsers) > 0)
    {
        echo '<h5><u>Члены команды</u></h5>';
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                ['attribute' => 'participants', 'format' => 'raw'],
            ],
        ]);
    }

    ?>

</div>
