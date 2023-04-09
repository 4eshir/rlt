<?php

use app\models\Team;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\extended\PayTeamModel $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Teams';
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><u>Выплата за командную работу</u></h2>
<?php
$team = app\models\Team::find()->where(['id' => $model->id])->one();
?>
<h4 id="all_cost">Доступно к выплате: <span id="numb"><?php echo $team->summary_cost.'</span> '.$team->currency->name; ?></h4>

<div class="team-index" style="margin-top: 1em;">

    <?php $form = ActiveForm::begin([
        'id' => 'user-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-6 form-control'],
            'errorOptions' => ['class' => 'col-lg-2 invalid-feedback'],
        ],
    ]); ?>

    <?php 

    $parts = app\models\TeamUser::find()->where(['team_id' => $model->id])->orderBy(['user_id' => SORT_ASC])->all();
    foreach ($parts as $one)
    {
        $team = app\models\Team::find()->where(['id' => $model->id])->one();
        $wallet = app\models\Wallet::find()->where(['type_id' => 1])->andWhere(['user_id' => $one->user_id])->one();
        $currencyWallet = app\models\CurrencyWallet::find()->where(['wallet_id' => $wallet->id])->andWhere(['currency_id' => $team->currency_id])->one();

        $wallet2 = app\models\Wallet::find()->where(['type_id' => 2])->andWhere(['user_id' => $team->user_creator_id])->one();
        $currencyWallet2 = app\models\CurrencyWallet::find()->where(['wallet_id' => $wallet2->id])->andWhere(['currency_id' => $team->currency_id])->one();

        $history = app\models\HistoryWallet::find()->where(['currency_wallet_out_id' => $currencyWallet2->id])->andWhere(['currency_wallet_in_id' => $currencyWallet->id])->andWhere(['team_id' => $model->id])->one();

        echo $form->field($model, 'cost[]', ['options' => ['onchange' => 'ChangeCost(this)']])->textInput()->label($one->user->secondname.' '.$one->user->firstname.' ('.$one->user->username.')<br><i>Выплачено: '.$history->count.'</i>');
    }

    ?>

    <div class="form-group">
        <?= Html::submitButton('Выплатить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>


<script type="text/javascript">
    var start_cost = 0;
    window.onload = function()
    {
        let elem = document.getElementById('numb');
        start_cost = elem.innerHTML;
    }

    function ChangeCost(value)
    {
        let elem = document.getElementById('numb');
        let elems = document.getElementsByClassName('form-control');
        let sum = 0;
        for (let i = 0; i < elems.length; i++)
        {
            if (elems[i].value != '')
                sum += Number(elems[i].value);
        }
        console.log(sum);

        elem.innerHTML = start_cost - sum;
    }
</script>