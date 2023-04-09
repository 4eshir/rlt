<?php

use app\models\Product;
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

    .product-status-buy{
        border: 2px solid gold;
        display: inline-block;
        padding: 5px;
        border-radius: 5px;
        color: #ff9b00;
        margin-left: 20px;
    }

    h1 {
        margin: 20px 0 40px 15px;
    }

    .product_photo {
        margin-right: 70px;
        margin-left: 50px;
        width: 250px;
    }
</style>

<div class="lk-index">

    <h1>Мои товары</h1>

    <?php
        $products = Product::find()->where(['user_creator_id' => Yii::$app->user->identity->getId()])->all();

        if (count($products) > 0)
        {
            echo '<div class="product-list">';
            foreach ($products as $product)
            {
                echo '<div class="one-product">';
                echo '<div class="product_photo">'.$product->getPhotosView().'</div>';// picture
                echo '<div style="padding-top: 20px; width: 300px;">';
                echo '<p style="font-family: Franklin Gothic Medium; height: auto; font-size: 24px; font-weight: bold; margin-bottom: 5px">';
                echo '<a href="'.\yii\helpers\Url::to(['product/view', 'id' => $product->id]).'">'.$product->name.'</a>';
                echo '</p>';
                echo '<hr style="margin-bottom: 10px; margin-top: 15px; border-color: black">';
                echo '<span>';
                echo '<span style="font-size: 18px; display: inline-block">Цена:</span> <b>'.$product->getPriceString().'</b>'; // стоимость
                echo '</span>';
                echo '<span style="display: block; line-height: 40px;">Остаток: '.$product->count.' шт.</span>';
                echo '</div>';
                echo '<div style="margin-left: 70px; padding-top: 65px;">';
                if ($product->status_id == 1)
                    echo '<span class="product-status-ok" title="Товар доступен в маркетплейсе"><i class="bi bi-check-circle-fill" style="font-size: 1rem; color: #28a745"></i> '.$product->getStatusString().'</span>';
                else
                    echo '<span class="product-status-no" title="Пополните запасы товара"><i class="bi bi-x-circle-fill" style="font-size: 1rem; color: #dc3545;"></i> '.$product->getStatusString().'</span>';
                if ($product->getBuyInfo($product->id))
                    echo '<span class="product-status-buy" title="Одобрите покупку Вашего товара"><i class="bi bi-check-circle-fill" style="font-size: 1rem; color: #28a745"></i> '. 'Новый покупатель' .'</span>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
        else
            echo '<span style="margin-left: 15px;">Здесь пока ничего нет...</span>';

    ?>

</div>