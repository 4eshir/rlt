<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SearchProduct $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Маркетплейс';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .product-wrapper {
        display: block;
        width: 100%;
        float: left;
        transition: width .2s;
    }

    @media only screen and (min-width: 450px) {
        .product-wrapper {
            width: 50%;
        }
        .title {
            margin-bottom: 30%;
        }
    }

    @media only screen and (min-width: 768px) {
        .product-wrapper {
            width: 33.333%;
        }
        .title {
            margin-bottom: 30%;
        }
    }

    @media only screen and (min-width: 1000px) {
        .product-wrapper {
            width: 25%;
        }
        .title {
            margin-bottom: 30%;
        }
    }

    .product {
        display: block;
        border: 3px solid #0000B6;
        border-radius: 15px;
        position: relative;
        background: #fff;
        margin: 0 20px 20px 0;
        text-decoration: none;
        color: #474747;
        z-index: 0;
        height: auto;
        padding: 10px;
    }

    .products {
        list-style: none;
        margin: 0 -20px 0 0;
        padding: 0;
    }

    .product-photo {
        position: relative;
        /*padding-bottom: 100%;*/
        padding-bottom: 60%;
        overflow: hidden;
        border-radius: 10px;
    }

    .product-photo img {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        max-width: 100%;
        max-height: 100%;
        /*margin: auto;*/
        margin: 0 auto;
        transition: transform .4s ease-out;
    }

    .product:hover .product-photo img {
        transform: scale(1.3);
    }

    .product p {
        position: relative;
        margin: 0;
        font-size: 1em;
        line-height: 1.4em;
        height: 5.6em;
        overflow: hidden;
    }

    /*.product p:after {
        content: '';
        display: inline-block;
        position: absolute;
        bottom: 0;
        right: 0;
        width: 4.2em;
        height: 1.6em;
        background: linear-gradient(to left top, #fff, rgba(255, 255, 255, 0));
    }*/

    .product:hover .product-preview {
        transform: translateY(0);
        opacity: 1;
    }

    .product-buttons-wrap {
        position: absolute;
        top: 0;
        left: -1px;
        right: -1px;
        bottom: 0;
        visibility: hidden;
        opacity: 0;
        transform: scaleY(.8);
        transform-origin: top;
        transition: transform .2s ease-out;
        z-index: -1;
        backface-visibility: hidden;
    }

    .product-buttons-wrap:before {
        content: "";
        float: left;
        height: 100%;
        width: 100%;
    }

    .buttons {
        position: relative;
        top: -1px;
        padding: 20px;
        background: #fff;
        box-shadow: 0 0 20px rgba(0, 0, 0, .5);
        border: 1px solid #56bd4b;
        border-radius: 3px;
    }

    span {
        line-height: 20px;
        display:block;
    }

    .product-wrapper a {
        text-decoration: none;
    }

    .product-wrapper a:hover :not(h3, span){
        color: black;
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

    .title {
        margin-bottom: 35px;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<body style="background-color: #E1BEFE;">
<div class="product-index">


    <div class="title">
        <div><h1 style="float: left; height: 50px"><?= Html::encode($this->title) ?></h1></div>
        <div style="text-align: right; height: 50px;"><?= Html::a('Добавить товар на площадку', ['create'], ['class' => 'btn btn-success', 'style' => 'height: 50px; line-height: 33px']) ?></div>
    </div>
    

    <?php
        $products = Product::find()->all();

        echo '<div>';
        echo '<ul class="products clearfix">';
        foreach ($products as $product)
        {
            echo '<li class="product-wrapper">';
            echo '<a href="'.\yii\helpers\Url::to(['product/view', 'id' => $product->id]).'" class="product">';

            echo '<div class="product-photo">';
            echo $product->getPhotosView();

            echo '</div>';

            echo '<div class="product-description">';
            echo '<p style="font-family: Franklin Gothic Medium; height: auto; font-size: 24px; font-weight: bold; margin-bottom: 5px">';
            echo $product->name;
            echo '</p>';
            echo '<div>';
            echo '<span style="margin-bottom: 5px; min-height: 50px; max-height: 50px"><i>';
            if (strlen($product->description) > 50)
                echo substr($product->description,0,50).'...'; // описание
            else
                echo $product->description;
            echo '</i></span>';

            if ($product->status_id == 1)
            {
                echo '<span class="product-status-ok"><i class="bi bi-check-circle-fill" style="font-size: 1rem; color: #28a745"></i> '.$product->getStatusString().'</span>';
                echo '<span style="display: inline-block; margin-left: 10px">Остаток: '.$product->count.' шт.</span>';
            }
            else
                echo '<span class="product-status-no"><i class="bi bi-x-circle-fill" style="font-size: 1rem; color: #dc3545;"></i> '.$product->getStatusString().'</span>';
            echo '<hr style="margin-bottom: 10px; margin-top: 15px; border-color: black">';
            echo '<span>';
            echo '<span style="font-size: 18px; display: inline-block">Цена:</span> <b>'.$product->getPriceString().'</b>'; // стоимость
            echo '</span>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
            echo '</li>';
        }
        echo '</ul>';
        echo '</div>';
    ?>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php /*echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'nameView', 'format' => 'html'],
            ['attribute' => 'photosView', 'format' => 'html'],
            'currencyString',
            'price',
            'statusString',
        ],
    ]);*/ ?>


</div>
</body>
