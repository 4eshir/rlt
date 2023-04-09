<?php

namespace app\models\extended;

use app\models\CurrencyWallet;
use app\models\TeamUser;
use app\models\Wallet;
use app\models\HistoryWallet;
use app\models\Team;

use yii\httpclient\Client;

use Yii;

class APIConnectorRostorg
{
    public static $baseUrl = "";

    public static $private_key = "";
    public static $public_key = "";

    public static function ConnectRostorg()
    {
        /*
        * Функция для подключения к API Росэлторга
        * Использует public_key, получает private_key
        */
        return 0;
    }

    public static function GetUserRate($user_id)
    {
        /*
        * Функция для получения информации о рейтинге пользователя
        * Использует user_id для поиска пользователя в БД
        * Возвращает рейтинг в формате ???
        */
        return 0;
    }

    public static function GetReviews($product_id, $seller_id)
    {
        /*
        * Функция для получения отзывов на товар
        * Использует product_id для получения товара
        * Использует seller_id для уточнения по продавцу
        * Возвращает массив отзывов
        */
        return [];
    }

    public static function GetAvgProductMark($product_id, $seller_id)
    {
        /*
        * Функция для получения отзывов на товар
        * Использует product_id для получения товара
        * Использует seller_id для уточнения по продавцу
        * Возвращает среднюю оценку в формате float
        */
        return 0.0;
    }

    public static function GetEarlyAccessData($deal_id)
    {
        /*
        * Функция для получения информации о товаре, которую можно предоставить в раннем доступе
        * Использует deal_id для получения сделки
        * Возвращает данные в формате ???
        */
        return 0;
    }
}
