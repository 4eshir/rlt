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
    $role = \app\models\User::find()->all();
    $items = \yii\helpers\ArrayHelper::map($role,'id','fullNameWithRole');
    $params = [];
    echo $form->field($model, "user_id")->dropDownList($items,$params)->label('Кому');
    ?>

    <?= $form->field($model, 'text')->textInput()->label('Текст сообщения') ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить сообщение', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
