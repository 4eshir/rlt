<?php


use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form" style="margin-top: 1.5em;">

    <?php $form = ActiveForm::begin([
        'id' => 'user-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-6 form-control'],
            'errorOptions' => ['class' => 'col-lg-2 invalid-feedback'],
        ],
    ]); ?>

    <?= $form->field($model, 'firstname')->textInput() ?>
    <?= $form->field($model, 'secondname')->textInput() ?>
    <?= $form->field($model, 'patronymic')->textInput() ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <?php
    if ($model->password_hash === NULL)
        echo $form->field($model, 'password_hash')->textInput(); ?>
    <?php
    $role = \app\models\Role::find()->all();
    $items = \yii\helpers\ArrayHelper::map($role,'id','name');
    $params = [];
    echo $form->field($model, "role_id")->dropDownList($items,$params);

    ?>
    <h5 style="margin-top: 20px"><u>Ежемесячное пополнение личного кошелька</u></h5>
    <?= $form->field($model, 'personalSalaryNFT')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'personalSalaryDig')->textInput(['type' => 'number']) ?>
    <h5 style="margin-top: 20px"><u>Ежемесячное пополнение виртуального кошелька</u></h5>
    <?= $form->field($model, 'virtualSalaryNFT')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'virtualSalaryDig')->textInput(['type' => 'number']) ?>
    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
