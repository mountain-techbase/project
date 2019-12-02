<?php
session_start();

//CRIENT_ID, CRIENT_SECRET, REDIRECT_URI, TOKEN_URIを定義
include_once "def_google_config.php";

//デバッグ
// echo "<pre>";
// echo var_dump($_SESSION);
// echo var_dump($_GET);
// echo "</pre>";

//csrf対策のトークンを取得
//$_SESSION[]からトークンを取得
if (isset($_SESSION['csrf_token'])) {
    $session_csrf_token = $_SESSION['csrf_token'];
} else {
    $session_csrf_token = "";
}


//$_GET[]からトークンを取得
//関数fiは関数filter_inputの略
$param_csrf_token = fi(INPUT_GET, "state");

if (strcmp($session_csrf_token, $param_csrf_token) == 0) {

    //javascriptでPOST
    //post_to_get_profile();

    //echo "ログインに成功しました";

    //post_to_get_profile();
    post_to_get_profile_02();
} else {
    echo "ログインに失敗しました";
    header('Location: mission7_log.php');
}

//session_write_close();

//filter_input関数を短くしたもの
function fi($type, $elem_name)
{
    $ret = filter_input($type, $elem_name, FILTER_SANITIZE_SPECIAL_CHARS);
    return $ret;
}

function redirect()
{
    $script =
    "
    <script>
        window.location.href = 'samp_home.html';
    </script>
    "
    ;

    echo $script;
    die();
}

function post_to_get_profile()
{
    $token_uri = TOKEN_URL;
    $code = fi(INPUT_GET, "code");
    $client_id = CLIENT_ID;
    $client_secret = CLIENT_SECRET;
    $redirect_uri = REDIRECT_URI;

    
    $script =

    "
    <script>
        console.log('hello');
        window.onload = function(){
        var form = document.createElement('form');

        var code = document.createElement('input');
        var client_id = document.createElement('input');
        var client_secret = document.createElement('input');
        var redirect_uri = document.createElement('input');
        var grant_type = document.createElement('input');

        form.method = 'POST';
        form.action = 'TOKEN_URI';
 
        code.type = 'hidden';
        code.name = 'code';
        code.value = 'CODE';

        client_id.type = 'hidden'; 
        client_id.name = 'client_id';
        client_id.value = 'CLIENT_ID';

        client_secret.type = 'hidden';
        client_secret.name = 'client_secret';
        client_secret.value = 'CLIENT_SECRET';

        redirect_uri.type = 'hidden';
        redirect_uri.name = 'redirect_uri';
        redirect_uri.value = 'REDIRECT_URI';

        grant_type.type = 'hidden';
        grant_type.name = 'grant_type';
        grant_type.value = 'authorization_code';
 
        form.appendChild(code);
        form.appendChild(client_id);
        form.appendChild(client_secret);
        form.appendChild(redirect_uri);
        form.appendChild(grant_type);

        document.body.appendChild(form);

        console.log('redirect_uri');
        console.log(redirect_uri.value);

        form.submit();
        }
    </script>
    ";
    
    $script = str_replace("TOKEN_URI", $token_uri, $script);
    $script = str_replace("CODE", $code, $script);
    $script = str_replace("CLIENT_ID", $client_id, $script);
    $script = str_replace("CLIENT_SECRET", $client_secret, $script);
    $script = str_replace("REDIRECT_URI", $redirect_uri, $script);

    print $script;
    die();
}

//非同期
function post_to_get_profile_02()
{
    $token_uri = TOKEN_URI;
    $code = fi(INPUT_GET, "code");
    $client_id = CLIENT_ID;
    $client_secret = CLIENT_SECRET;
    $redirect_uri = REDIRECT_URI;
    $set_username_into_session = "set_google_username_into_session.php";

    // //csrf対策
    //トークン生成
    $byte_csrf_token = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($byte_csrf_token);
    //$_SESSION[]にトークンを格納
    $_SESSION['csrf_token'] = $csrf_token;

    $script02 =
    "
    <script>

        //まず、非同期通信でユーザのプロファイルが含まれているid_tokenを受け取る

        //ただし、
        //phpでも処理ができる(get_file_content(),cURL()などの関数を用いて)。
        //しかし、借りているサーバーの設定でそれらの関数が利用できなかった。
        //そのため、今回はjavascriptを用いてユーザのプロファイルを受け取る


        //フォーム作成
        var formData = new FormData();
        
        //フォームに入力情報を追加
        //post送信かつ送らなければならない情報が決まっている。
        //詳しくはドキュメント参照。
        formData.append('code','CODE');
        formData.append('client_id','CLIENT_ID');
        formData.append('client_secret','CLIENT_SECRET');
        formData.append('redirect_uri','REDIRECT_URI');
        formData.append('grant_type','authorization_code');

        //非同期でpost
        var request = new XMLHttpRequest();
        request.open('POST','TOKEN_URI');
        request.send(formData);

        //非同期通信が終了した際に行われる処理
        //ここでユーザのプロファイルを取り出す
        request.onloadend = function(){

            //非同期通信で受け取ってきた情報をコンソール出力
            //console.log('response');
            //console.log(request.response);

            //非同期通信で受け取ってきた情報からid_tokenを取り出す
            var json_response = JSON.parse(request.response);

            //エラー処理
            if( 'error' in json_response){
                //ユーザにエラー通知
                var notice_error = document.createTextNode('ログインに失敗しました');
                document.body.appendChild(notice_error);
                return ;
            }

            var id_token = json_response.id_token;
            // console.log('id_token');
            // console.log(id_token);

            //id_tokenはJWTという方式で送られて来ている
            //そのためでコードする必要がある

            //id_token(JWT)のデコード
            var decoded_id_token = parseJwt(id_token);

            //デコードされたid_tokenを出力
            // console.log('decoded_id_token');
            // console.log(typeof decoded_id_token);
            // console.log(decoded_id_token);

            //ユーザ名を取り出す
            var get_username = decoded_id_token.name;

            //ユーザのプロファイルからユーザ名を取り出して
            //home画面にpostする
            cascade_to_setting_session_scene(get_username);         

        };

        function parseJwt (token) {
            var base64Url = token.split('.')[1];
            var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));

            return JSON.parse(jsonPayload);
        };

        function cascade_to_setting_session_scene(get_username){
            var form = document.createElement('form');

            var username = document.createElement('input');
            var csrf_token = document.createElement('input');

            form.method = 'POST';
            form.action = 'CITE_HOME';
 
            username.type = 'hidden';
            username.name = 'username';
            username.value = get_username;

            csrf_token.type = 'hidden';
            csrf_token.name = 'csrf_token';
            csrf_token.value = 'CSRF_TOKEN';

            form.appendChild(username);
            form.appendChild(csrf_token);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
    "
    ;
    
    $script02 = str_replace("TOKEN_URI", $token_uri, $script02);
    $script02 = str_replace("CODE", $code, $script02);
    $script02 = str_replace("CLIENT_ID", $client_id, $script02);
    $script02 = str_replace("CLIENT_SECRET", $client_secret, $script02);
    $script02 = str_replace("REDIRECT_URI", $redirect_uri, $script02);
    $script02 = str_replace("CITE_HOME", $set_username_into_session, $script02);
    $script02 = str_replace("CSRF_TOKEN", $csrf_token, $script02);

    echo $script02;
    die();
}
