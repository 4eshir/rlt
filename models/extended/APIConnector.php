<?php

namespace app\models\extended;

use app\models\CurrencyWallet;
use app\models\TeamUser;
use app\models\Wallet;
use app\models\HistoryWallet;
use app\models\Team;

use yii\httpclient\Client;

use Yii;

class APIConnector
{
    public static $baseUrl = "";

    public static $mainWallet_private = "";
    public static $mainWallet_public = "";

    public static function CreateWallet()
    {
        $client = new Client();
        /*$response = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setMethod('post')
            ->setUrl(APIConnector::$baseUrl.'/v1/wallets/new')

            ->setHeaders(['Content-Type' => 'application/json'])
            ->addHeaders(['Authorization' => ''])
            ->addHeaders(['X-Secret' => ''])

            ->send();
        */
        return 0;
        //return [$response->data["publicKey"], $response->data["privateKey"]];
    }

    public static function AddMantic($amount, $publicKey)
    {
        $client = new Client();
        /*
        $response = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setMethod('post')
            ->setUrl(APIConnector::$baseUrl.'/v1/transfers/matic')

            ->setHeaders(['Content-Type' => 'application/json'])
            ->setContent('{"fromPrivateKey": "'.APIConnector::$mainWallet_private.'", "toPublicKey": "'.$publicKey.'", "amount": '.$amount.'}')

            ->send();
        */
    }

    //type 2 - ruble, type 1 - nft
    public static function AddCoins($amount, $publicKey, $type)
    {
        $client = new Client();

        if ($type == 2)
        {
            /*
            $response = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setMethod('post')
            ->setUrl(APIConnector::$baseUrl.'/v1/transfers/ruble')

            ->setHeaders(['Content-Type' => 'application/json'])
            ->setContent('{"fromPrivateKey": "'.APIConnector::$mainWallet_private.'", "toPublicKey": "'.$publicKey.'", "amount": '.$amount.'}')

            ->send();
            */
        }
        if ($type == 1)
        {
            /*
            $response = $client->createRequest()
                ->setFormat(Client::FORMAT_JSON)
                ->setMethod('post')
                ->setUrl(APIConnector::$baseUrl.'/v1/nft/generate')

                ->setHeaders(['Content-Type' => 'application/json'])
                ->setContent('{"toPublicKey": "'.$publicKey.'", "uri": "ipfs://bafybeifesqvvmmtcjlmeso3zaqh56mhttgza2eglw7zwy4ryuyifduy4i/images/star.png", "nftCount": '.$amount.'}')

                ->send();
            */
        }
    }

    //type 2 - ruble, type 1 - nft
    public static function ExchangeCoins($amount, $privateKey_out, $publicKey_out, $publicKey_in, $type)
    {
        $client = new Client();

        if ($type == 2)
        {
            /*
            $response = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setMethod('post')
            ->setUrl(APIConnector::$baseUrl.'/v1/transfers/ruble')

            ->setHeaders(['Content-Type' => 'application/json'])
            ->setContent('{"fromPrivateKey": "'.$privateKey_out.'", "toPublicKey": "'.$publicKey_in.'", "amount": '.$amount.'}')

            ->send();
            */
        }
        if ($type == 1)
        {
            /*
            $response1 = $client->createRequest()
                ->setFormat(Client::FORMAT_JSON)
                ->setMethod('get')
                ->setUrl(APIConnector::$baseUrl.'/v1/wallets/'.$publicKey_out.'/nft/balance')
                
                ->send();



            for ($i = 0; $i < $amount; $i++)
            {
                $response = $client->createRequest()
                    ->setFormat(Client::FORMAT_JSON)
                    ->setMethod('post')
                    ->setUrl(APIConnector::$baseUrl.'/v1/transfers/nft')

                    ->setHeaders(['Content-Type' => 'application/json'])
                    ->setContent('{"fromPrivateKey": "'.$privateKey_out.'", "toPublicKey": "'.$publicKey_in.'", "tokenId": '.$response1->data["balance"][0]["tokens"][$i].'}')

                    ->send();

            }

            
            */
        }
    }
}
