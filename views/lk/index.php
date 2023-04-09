<?php

use app\models\Role;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SearchRole $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
    @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


    /* Базовый контейнер табов */
    .tabs {
            min-width: 320px;
            /*max-width: 800px;*/
            padding: 0px;
            margin: 0 auto;
    }
    /* Стили секций с содержанием */
    .tabs>section {
            display: none;
            padding: 15px;
            background: #fff;
     border: 1px solid #ddd;
    }
    .tabs>section>p {
            margin: 0 0 5px;
            line-height: 1.5;
            color: #383838;
     /* прикрутим анимацию */
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
            -webkit-animation-name: fadeIn;
            animation-name: fadeIn;
    }
    /* Описываем анимацию свойства opacity */
     
    @-webkit-keyframes fadeIn {
            from {
                    opacity: 0;
            }
            to {
                    opacity: 1;
            }
    }
    @keyframes fadeIn {
            from {
                    opacity: 0;
            }
            to {
                    opacity: 1;
            }
    }
    /* Прячем чекбоксы */
    .tabs>input {
            display: none;
            position: absolute;
    }
    /* Стили переключателей вкладок (табов) */
    .tabs>label {
            display: inline-block;
            margin: 0 0 -1px;
            padding: 15px 25px;
            font-weight: 600;
            text-align: center;
            color: #aaa;
     border: 0px solid #ddd;
     border-width: 1px 1px 1px 1px;
            background: #f1f1f1;
     border-radius: 3px 3px 0 0;
    }
    /* Шрифт-иконки от Font Awesome в формате Unicode */
    .tabs>label:before {
            font-family: fontawesome;
            font-weight: normal;
            margin-right: 10px;
    }
    .tabs>label[for*="1"]:before {
        font-family: FontAwesome;
        content: "\f007";
    }
    .tabs>label[for*="2"]:before {
        font-family: FontAwesome;
        content: "\f0ae";
    }
    .tabs>label[for*="3"]:before {
        font-family: FontAwesome;
        content: "\f218";
    }
    .tabs>label[for*="4"]:before {
        font-family: FontAwesome;
        content: "\f291";
    }
    .tabs>label[for*="5"]:before {
        font-family: FontAwesome;
        content: "\f1da";
    }
    /* Изменения стиля переключателей вкладок при наведении */
     
    .tabs>label:hover {
            color: #888;
     cursor: pointer;
    }
    /* Стили для активной вкладки */
    .tabs>input:checked+label {
            color: #555;
     border-top: 1px solid #009933;
     border-bottom: 1px solid #fff;
     background: #fff;
    }
    /* Активация секций с помощью псевдокласса :checked */
    #tab1:checked~#content-tab1, #tab2:checked~#content-tab2, #tab3:checked~#content-tab3, #tab4:checked~#content-tab4, #tab5:checked~#content-tab5 {
     display: block;
    }
    /* Убираем текст с переключателей 
    * и оставляем иконки на малых экранах
    */
     
    @media screen and (max-width: 680px) {
            .tabs>label {
                    font-size: 0;
            }
            .tabs>label:before {
                    margin: 0;
                    font-size: 18px;
            }
    }
    /* Изменяем внутренние отступы 
    *  переключателей для малых экранов
    */
    @media screen and (max-width: 400px) {
            .tabs>label {
                    padding: 15px;
            }
    }
</style>

<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Вкладка 1">Общая информация</label>
 
    <input id="tab2" type="radio" name="tabs">
    <label for="tab2" title="Вкладка 2">Ивенты и игры</label>
 
    <input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Вкладка 3">Мои заказы</label>
 
    <input id="tab4" type="radio" name="tabs">
    <label for="tab4" title="Вкладка 4">Мои товары</label>

    <input id="tab5" type="radio" name="tabs">
    <label for="tab5" title="Вкладка 5">История и переводы</label>
 
    <section id="content-tab1">
        <p>
            <?= $this->render('common', [
                'model' => $model->commonInfo,
            ]) ?>
        </p>
    </section>  
    <section id="content-tab2">
        <p>
          <?= $this->render('task-team', [
                'model' => $model->taskTeamInfo,
            ]) ?>
        </p>
    </section> 
    <section id="content-tab3">
        <p>
            <?= $this->render('orders', [
                'model' => $model->ordersInfo,
            ]) ?>
        </p>
    </section> 
    <section id="content-tab4">
        <p>
            <?= $this->render('my-product', [
                'model' => $model->myProductInfo,
            ]) ?>
        </p>
    </section>
    <section id="content-tab5">
        <p>
            <?= $this->render('money', [
                'model' => $model->moneyInfo,
            ]) ?>
        </p>
    </section>
</div>
