<?php


use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/** @var yii\web\View $this */
/** @var app\models\extended\AddCoinsModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $user = app\models\User::find()->where(['id' => $model->user_id])->one(); ?>
<h1><?= Html::encode('Начисление средств для ' . $user->username) ?></h1>

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

    <?php
    $role = \app\models\TypeWallet::find()->all();
    $items = \yii\helpers\ArrayHelper::map($role,'id','name');
    $params = [];
    echo $form->field($model, "walletType")->dropDownList($items,$params);

    ?>

    <?php
    $role = \app\models\Currency::find()->all();
    $items = \yii\helpers\ArrayHelper::map($role,'id','name');
    $params = [];
    echo $form->field($model, "currencyType")->dropDownList($items,$params);

    ?>

    <?= $form->field($model, 'count')->textInput(['type' => 'number']) ?>
    

    <div class="form-group">
        <?= Html::submitButton('Начислить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
