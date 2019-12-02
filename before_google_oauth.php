<?php
//作成にあたり,主に参考にしたサイト
//google公式ドキュメント
//https://developers.google.com/identity/protocols/OpenIDConnect
//一番わかりやすかったサイト
//https://komiyak.hatenablog.jp/entry/20141103/1415016929


session_start();

//CRIENT_ID, REDIRECT_URIを定義
include_once "def_google_config.php";

//csrf対策
//トークン生成
$byte_csrf_token = openssl_random_pseudo_bytes(16);
$csrf_token = bin2hex($byte_csrf_token);
//$_SESSION[]にトークンを格納
$_SESSION['csrf_token'] = $csrf_token;

//urlの組み立て
//ベース
$base_url =
"https://accounts.google.com/o/oauth2/v2/auth?";
//google api consoleで設定
$client_id = CLIENT_ID;
//よくわからない
$response_type = "code";
//よくわからない
$scope = "openid%20profile";
//認証後のurl
$redirect_uri = REDIRECT_URI;
//csrf対策のトークン
$state = $csrf_token;

$url =
$base_url.
"client_id=".$client_id.
"&response_type=".$response_type.
"&scope=".$scope.
"&redirect_uri=".$redirect_uri.
"&state=".$state
;

//認証ページにリダイレクト
header("Location: ".$url);

exit();
