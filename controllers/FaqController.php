<?php

namespace app\controllers;

use app\models\CurrencyWallet;
use app\models\extended\APIConnector;
use app\models\UserSalary;
use app\models\Wallet;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;
use app\models\ContactForm;

class FaqController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    
}
