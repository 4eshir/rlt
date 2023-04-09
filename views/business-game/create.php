<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BusinessGame $model */

$this->title = 'Создать деловую игру';
$this->params['breadcrumbs'][] = ['label' => 'Деловые игры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="business-game-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
