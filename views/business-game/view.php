<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\BusinessGame $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Деловые игры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="business-game-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        $opt = $model->id == 1 ? ['gameup', 'id' => $model->id] : ['gamedown', 'id' => $model->id];
        ?>
        <?= Html::a('Начать игру', $opt, ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'start_date',
            'end_date',
            'name',
            'description',
            'target',
            'count_participant',
        ],
    ]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            ['attribute' => 'stepsString', 'format' => 'raw'],
        ],
    ]) ?>

</div>
