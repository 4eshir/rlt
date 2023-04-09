<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Маркетплейс', 'url' => ['market']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?php
        if ($model->status_id == 1)
            echo Html::encode($this->title);
        else
            echo '<s>'.Html::encode($this->title).'</s>'.' <i style="color: red;">Товар закончился </i>'
        ?>
    </h1>

    <p>
        <?php
        if ($model->user_creator_id == Yii::$app->user->identity->getId()) {
            echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary', 'style' => 'margin-right: 4px;']);
            echo Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить товар с маркетплейса?',
                    'method' => 'post',
                ],]);
        }
        else {
            $buyInfo = $model->getButton($model->id);
            if (empty($buyInfo))
                echo Html::a('Отменить покупку', ['revocation', 'id' => $model->id], ['class' => 'btn btn-warning']);
            else if ($model->status_id == 1)
                echo Html::a('Купить', ['buy', 'id' => $model->id], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'description',
            ['attribute' => 'photosView', 'format' => 'html'],
            //'currency_id',
            'priceString',
            //'user_creator_id',
            'count',
            //'status_id',
        ],
    ]) ?>

    <?php

    if (count(\app\models\ProductUser::find()->where(['product_id' => $model->id])->all()) > 0)
    {
        if ($model->user_creator_id == Yii::$app->user->identity->getId())
        {
            echo '<h5><u>История продаж</u></h5>';
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    ['attribute' => 'acquisition', 'format' => 'raw'],
                ],
            ]);
        }
    }

    ?>

</div>
