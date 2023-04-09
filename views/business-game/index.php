<?php

use app\models\BusinessGame;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Деловые игры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="business-game-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            //'id',
            'start_date',
            'end_date',
            //'type_participation_id',
            //'description',
            //'role_participant_id',
            //'type_participant_id',
            //'target',
            //'count_participant',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, BusinessGame $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
