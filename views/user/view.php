<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Начислить NFT/монеты', ['add-coins', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Списать NFT/монеты', ['delete-coins', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            'firstname',
            'secondname',
            'patronymic',
            'roleString',
            'experience_count',
        ],
    ]) ?>


    <h5><u>Внутрикорпоративные кошельки сотрудника</u></h5>
    <?php 

    if (count(\app\models\Wallet::find()->where(['user_id' => $model->id])->all()) > 0)
    {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                ['attribute' => 'walletPersonal', 'format' => 'raw'],
                ['attribute' => 'walletVirtual', 'format' => 'raw'],
                ['attribute' => 'personalSalary', 'format' => 'raw'],
                ['attribute' => 'virtualSalary', 'format' => 'raw'],
            ],
        ]);
    }

    ?>

</div>
