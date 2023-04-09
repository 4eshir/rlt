<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;
use app\models\ContactForm;
use app\models\extended\APIConnector;

class SiteController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        return $this->render('index');
    }


    public function actionLogin()
    {
        if (Yii::$app->session->get('userSessionTimeout') !== 60 * 60 * 24 * 100)
            Yii::$app->session->set('userSessionTimeout', 60 * 60 * 24 * 100);

        //if (!Yii::$app->user->isGuest) {
        //    return $this->goHome();
        //}

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->render('index');
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionErrorAccess()
    {
        return $this->render('error-access');
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout($from = null)
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionLeaderboard()
    {
        $model = User::find()->where(['!=', 'role_id', 1])->orderBy(['experience_count' => SORT_DESC])->all();
        return $this->render('leaderboard', [
            'model' => $model,
        ]);
    }

}
