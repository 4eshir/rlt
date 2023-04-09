<?php

use app\models\Product;
use app\models\ProductUser;
use app\models\Role;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SearchRole $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>
<style>
    .product-list {
        margin: 1em;
    }

    .one-product {
        display: flex;
        margin-bottom: 24px;
        overflow: hidden;
        position: relative;
        transition: all .3s;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 15px;
        max-height: 200px;
    }

    .product-status-ok{
        border: 1px solid green;
        display: inline-block;
        padding: 5px;
        border-radius: 5px;
        color: green;
    }

    .product-status-no{
        border: 1px solid red;
        display: inline-block;
        padding: 5px;
        border-radius: 5px;
        color: red;
    }

    .product-status-old{
        border: 1px solid black;
        display: inline-block;
        padding: 5px;
        border-radius: 5px;
        color: black;
    }

    h1 {
        margin: 20px 0 40px 15px;
    }

    .product_photo {
        margin-right: 70px;
        margin-left: 50px;
        width: 250px;
    }

    .product_info {
        padding-top: 30px;
        width: 300px;
        height: 170px;
    }
</style>

<div class="lk-index">

    <h1>Мои заказы</h1>

    <?php
    $products = ProductUser::find()->where(['user_id' => Yii::$app->user->identity->getId()])->orderBy(['date' => SORT_DESC])->all();

    if (count($products) > 0)
    {
        echo '<div class="product-list">';
        foreach ($products as $product)
        {
            echo '<div class="one-product">';
            echo '<div class="product_photo">'.$product->product->getPhotosView().'</div>';// picture
            echo '<div class="product_info">';
            echo '<p style="font-family: Franklin Gothic Medium; height: auto; font-size: 24px; font-weight: bold; margin-bottom: 5px">';
            echo '<a href="'.\yii\helpers\Url::to(['product/view', 'id' => $product->product->id]).'">'.$product->product->name.'</a>';
            echo '</p>';
            echo '<hr style="margin-bottom: 10px; margin-top: 15px; border-color: black">';
            echo '<span>';
            echo '<span style="font-size: 18px; display: inline-block">Стоимость:</span> <b>'.$product->product->getPriceString().'</b>'; // стоимость
            echo '</span>';
            echo '<span style="font-size: 18px; display: inline-block">'.'Дата покупки: ' . $product->date . '</span>';
            echo '</div>';
            echo '<div style="margin-left: 70px; padding-top: 65px;">';
            if ($product->confirm_id == 1)
                echo '<span class="product-status-ok" title="Товар оплачен. Ожидайте подтверждение продавца"><i class="bi bi-check-circle-fill" style="font-size: 1rem; color: #28a745"></i> '.$product->confirm->name.'</span>';
            else if ($product->confirm_id == 4)
                echo '<span class="product-status-no" title="Продавец отклонил Ваш запрос покупки"><i class="bi bi-x-circle-fill" style="font-size: 1rem; color: #dc3545;"></i> '.$product->confirm->name.'</span>';
            else
                echo '<span class="product-status-old" title="Пополните запасы товара"><i class="bi bi-x-circle-fill" style="font-size: 1rem; color: #dc3545;"></i> '.$product->confirm->name.'</span>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
    else
        echo '<span style="margin-left: 15px;">Здесь пока ничего нет...</span>';

    ?>
</div>