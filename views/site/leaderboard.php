<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>

<style type="text/css">
    TABLE{
        min-width: 100%;
        border-spacing: 0px 8px;
        border-collapse: separate;
    }

    .header-tr{
        background-color: #424242;
        color: white;
    }

    .base-tr{
        background-color: #F5F5F5;
        color: black;
    }

    .header-td{
        padding-top: 8px;
        padding-bottom: 8px;
        text-align: center;
        font-family: 'Trebuchet MS';
        border-right: 1px dashed white;
        font-weight: bold;
    }

    .base-td{
        padding-top: 5px;
        padding-bottom: 5px;
        font-family: 'Trebuchet MS';
        border-bottom: 1px solid #D0D0D0;
        font-size: 18px;
    }

    .center-td{
        text-align: center;
    }

    .right-td{
        padding-left: 20px;
        padding-right: 10px;
    }

    .img-td{
        align: center;
    }

    .first{
        background-color: gold;
    }

    .second{
        background-color: silver;
    }

    .third{
        background-color: #CD7F32;
    }

    .level-span{
        display: inline-block;
        border-radius: 50%;
        background-color: pink;
        border: 2px solid black;
        max-height: 32px;
        max-width: 32px;
        min-height: 32px;
        min-width: 32px;
        align: center;
        line-height: 32px;
        text-align: center;
        font-family: 'Bookman Old Style';
        font-size: 18px;
        font-weight: bold;
    }

    .experience-div{
        display: inline-block;
        background-color: #E0FFFF;
        border-radius: 10px;
        width: 100%;
        border: 1px solid blue;
        padding-left: 10px;
    }

    .experience-span-first{
        font-family: Consolas;
        font-size: 20px;
        font-weight: bold;
        color: black;
    }
    .experience-span-second{
        font-family: Consolas;
        font-size: 20px;
        font-weight: bold;
        color: green;
    }

    A{
        color: black;
    }
</style>

<div class="site-index">

    <table>
        <tr class="header-tr">
            <td class="header-td"><!-- Аватар --></td>
            <td class="header-td">Логин</td>
            <td class="header-td">Фамилия</td>
            <td class="header-td">Имя</td>
            <td class="header-td">Отчество</td>
            <td class="header-td">Уровень</td>
            <td class="header-td">Очки опыта</td>
            <td class="header-td">Особые достижения</td>
        </tr>
        <?php
        $c = 0;
        foreach ($model as $user)
        {
            $strAdditionalClass = '';
            if ($c == 0) $strAdditionalClass = 'first';
            if ($c == 1) $strAdditionalClass = 'second';
            if ($c == 2) $strAdditionalClass = 'third';
            echo '<tr class="base-tr '.$strAdditionalClass.'">';
            echo '<td align="center" class="base-td img-td"><img src="/upload/avatar.png" width="50" height="50"/></td>';
            echo '<td class="base-td right-td">'.Html::a($user->username, ['user/view', 'id' => $user->id]).'</td>';
            echo '<td class="base-td right-td">'.$user->secondname.'</td>';
            echo '<td class="base-td right-td">'.$user->firstname.'</td>';
            echo '<td class="base-td right-td" style="border-right: 1px dashed black">'.$user->patronymic.'</td>';
            echo '<td class="base-td center-td"><span class="level-span">'.$user->levelNumber[0].'</span></td>';
            echo '<td class="base-td right-td"><div class="experience-div"><span class="experience-span-first">'.$user->experience_count.'</span>/<span class="experience-span-second">'.$user->levelNumber[2].'</span></div></td>';
            echo '<td class="base-td center-td" style="width: 17%">'.$user->achievesNumber.'</td>';
            echo '</tr>';
            $c++;
        }
        ?>
    </table>

</div>
