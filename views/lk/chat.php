<?php

use app\models\Role;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SearchRole $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Чаты';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="task-form" style="margin-top: 30px">

    <?php $form = ActiveForm::begin([
        'id' => 'team-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-6 form-control'],
            'errorOptions' => ['class' => 'col-lg-2 invalid-feedback'],
        ],
    ]); ?>

    <?php
    $items = ['0' => 'Входящие', '1' => 'Исходящие'];
    $params = [];
    echo $form->field($model, "type")->dropDownList($items,$params)->label('Тип сообщений');

    ?>

    <div class="form-group">
        <?= Html::submitButton('Показать сообщения', ['class' => 'btn btn-success']) ?>
    </div>

    <a class="button button-primary" href="index.php?r=lk/write">Написать сообщение</a>

    <?php ActiveForm::end(); ?>

</div>