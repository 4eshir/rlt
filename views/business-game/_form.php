<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/** @var yii\web\View $this */
/** @var app\models\BusinessGame $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="business-game-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'php:Y-m-d',
        'language' => 'ru',
        'options' => [
            'class'=> 'form-control',
            'autocomplete'=>'off'
        ],
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
            'yearRange' => '2000:2050',
        ]]) ?>

    <?= $form->field($model, 'end_date')->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'php:Y-m-d',
        'language' => 'ru',
        'options' => [
            'class'=> 'form-control',
            'autocomplete'=>'off'
        ],
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
            'yearRange' => '2000:2050',
        ]]) ?>

    <?= $form->field($model, 'type_participation_id')->radioList(array('1' => 'Начальный уровень',
    '2' => 'Средний уровень', '3' => 'Продвинутый уровень')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role_participant_id')->radioList(array('1' => 'Заказчик',
        '2' => 'Продавец', '3' => 'Заказчик+Продавец')) ?>

    <?= $form->field($model, 'type_participant_id')->radioList(array('1' => 'Соло с компьютером',
        '2' => 'Команда с компьютером', '3' => 'Команда с командой')) ?>

    <?= $form->field($model, 'target')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count_participant')->textInput() ?>

    <div class="panel-body">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items2', // required: css class selector
            'widgetItem' => '.item2', // required: css class
            'limit' => 100, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-item2', // css class
            'deleteButton' => '.remove-item2', // css class
            'model' => $modelStep[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'eventExternalName',
            ],
        ]); ?>

        <div class="container-items2" ><!-- widgetContainer -->
            <?php foreach ($modelStep as $i => $modelStepOne): ?>
                <div class="item2 panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Ступень</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item2 btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item2 btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (! $modelStepOne->isNewRecord) {
                            echo Html::activeHiddenInput($modelStepOne, "[{$i}]id");
                        }
                        ?>
                        <div class="col-xs-2">
                            <?= $form->field($modelStepOne, "[{$i}]name")->textInput()->label('Название шага') ?>
                        </div>


                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
