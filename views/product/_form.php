<?php

//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<style>
    .form-control-file {width: 70%;}
</style>

<div class="product-form" style="margin-top: 1.5em;">

    <?php $form = ActiveForm::begin([
        'id' => 'user-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-6 form-control'],
            'errorOptions' => ['class' => 'col-lg-2 invalid-feedback'],
        ],
    ]);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photosFile[]')->fileInput(['multiple' => true]) ?>
    <?php
    if (strlen($model->photo) > 2)
    {
        $split = explode(" ", $model->photo);
        echo '<table>';
        for ($i = 0; $i < count($split) - 1; $i++)
        {
            echo '<tr><td><h5>Загруженный файл: '.Html::a($split[$i], \yii\helpers\Url::to(['training-group/get-file', 'fileName' => $split[$i]])).'</h5></td>
                    <td style="padding-left: 10px">'.Html::a('X', \yii\helpers\Url::to(['training-group/delete-file', 'fileName' => $split[$i], 'modelId' => $model->id])).'</td></tr>';
        }
        echo '</table>';
    }
    ?>

    <?php
    $role = \app\models\Currency::find()->all();
    $items = \yii\helpers\ArrayHelper::map($role,'id','name');
    $params = [];
    echo $form->field($model, "currency_id")->dropDownList($items,$params);

    ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
