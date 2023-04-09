<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    $user = app\models\User::find()->where(['username' => Yii::$app->user->identity->username])->one();

    if (Yii::$app->user->identity == null)
    {
        NavBar::begin([
            'brandLabel' => 'РОСЭЛТОРГ Fun'/*Yii::$app->name*/,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Войти', 'url' => ['/site/login']],
            ]
        ]);
        NavBar::end(); 
    }

    else if ($user->role_id == 1)
    {
       NavBar::begin([
            'brandLabel' => 'РОСЭЛТОРГ Fun'/*Yii::$app->name*/,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Лидеры', 'url' => ['/site/leaderboard']],
                ['label' => 'Пользователи', 'url' => ['/user/index']],
                ['label' => 'Деловые игры', 'url' => ['/business-game/index']],
                ['label' => 'Справочник онбординга', 'url' => ['/task/index']],
                ['label' => 'Маркетплейс', 'url' => ['/product/market']],
                ['label' => 'FAQ', 'url' => ['/faq/index']],
                Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/site/login']]
                ) : (
                    '<li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown" aria-expanded="false">Мой профиль ('.Yii::$app->user->identity->username.')</a><div id="w2" class="dropdown-menu">'
                    .'<a class="dropdown-item" href="'.Url::to(['/lk/index', 'id' => Yii::$app->user->identity->getId()]).'">Личный кабинет</a>'
                    .'<a class="dropdown-item" href="'.Url::to(['/lk/chat', 'id' => Yii::$app->user->identity->getId()]).'">Чаты</a>'
                    .'<a class="dropdown-item" href="'.Url::to(['/site/logout', 'from' => '1']).'">Выйти</a></div></li>'
                    .'</li>'
                    
                )
            ],
        ]);
        NavBar::end(); 
    }
    else
    {
       NavBar::begin([
            'brandLabel' => 'РОСЭЛТОРГ Fun'/*Yii::$app->name*/,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Лидеры', 'url' => ['/site/leaderboard']],
                ['label' => 'Деловые игры', 'url' => ['/business-game/index']],
                ['label' => 'Справочник онбординга', 'url' => ['/task/index']],
                ['label' => 'Маркетплейс', 'url' => ['/product/market']],
                ['label' => 'FAQ', 'url' => ['/faq/index']],
                Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/site/login']]
                ) : (
                    '<li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown" aria-expanded="false">Мой профиль ('.Yii::$app->user->identity->username.')</a><div id="w2" class="dropdown-menu">'
                    .'<a class="dropdown-item" href="'.Url::to(['/lk/index', 'id' => Yii::$app->user->identity->getId()]).'">Личный кабинет</a>'
                    .'<a class="dropdown-item" href="'.Url::to(['/lk/chat', 'id' => Yii::$app->user->identity->getId()]).'">Чаты</a>'
                    .'<a class="dropdown-item" href="'.Url::to(['/site/logout', 'from' => '1']).'">Выйти</a></div></li>'
                    .'</li>'
                    
                )
            ],
        ]);
        NavBar::end(); 
    }
    
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; Oompa-Loompas <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
