<?php
session_start();

//AFTER_FINISHING_LOGINを定義
include_once "def_google_config.php";

//$_POST[]から"username"を取得
$username = fi(INPUT_POST, "username");
if ($username) {
    //ユーザ名を取得できたら

    //debug
    //echo "ログイン成功";
    // echo "<pre>";
    // var_dump($_POST);
    // var_dump($_SESSION);
    // echo "</pre>";
    // die();

    //$_SESSION[]に格納
    $_SESSION["USERID"] = $username;

    //javascriptで画面遷移させるようにする
    cascade_to_home();
} else {
    //ユーザ名を取得できなかったら

    echo "ログイン失敗";
}

session_write_close();

//filter_input関数を短くしたもの
function fi($type, $elem_name)
{
    $ret = filter_input($type, $elem_name, FILTER_SANITIZE_SPECIAL_CHARS);
    return $ret;
}

function cascade_to_home()
{
    $script =
    "
    <script>
        window.location.href = 'HOME';
        console.log('HOME');
    </script>
    "
    ;

    //$script = str_replace("HOME", "samp_home.php", $script);
    $script = str_replace("HOME", AFTER_FINISHING_LOGIN, $script);

    print $script;
}
