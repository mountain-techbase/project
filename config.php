<?php
    //アプリケーションの Consumer Key と Consumer Secret
$sTwitterConsumerKey = ''; //Consumer Key (API Key)
$sTwitterConsumerSecret = ''; //Consumer Secret (API Secret)

//アプリケーションのコールバックURL
$sTwitterCallBackUri = 'https://tb-210068.tech-base.net/mission7/callback.php'; //コールバックURL

//変数初期化
$objTwitterConection = NULL; //TwitterOAuthクラスのインスタンス化
$aTwitterRequestToken = array(); //リクエストトークン
$sTwitterRequestUrl = ''; //認証用URL
$objTwitterAccessToken = NULL; //アクセストークン
$objTwUserInfo = NULL; //ユーザー情報
?>

