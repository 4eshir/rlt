<?php

use app\models\Task;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SearchTask $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Справочник онбординга';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        $user = User::find()->where(['id' => Yii::$app->user->identity->getId()])->one();
        if ($user->role_id == 3) {
        ?>
            <?= Html::a('Создать ивент онбординга', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'currency_id',
            'price',
            'repeatString',
            //'user_creator_id',
            //'status_id',
            //'date_start',
            //'date_finish',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Task $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
