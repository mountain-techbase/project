<?php

session_start();

header("Content-type: text/html; charset=utf-8");


//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//データベース接続

//エラーメッセージの初期化
$errors = array();

if(empty($_POST)) {
    header("Location: mission7_new.php");
    exit();
}else{
    //POSTされたデータを変数に入れる
    $mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;

    //メール入力判定
    if ($mail == ''){
        $errors['mail'] = "メールが入力されていません。";
    }else{
        if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
            $errors['mail_check'] = "メールアドレスの形式が正しくありません。";
        }

        /*
        ここで本登録用のmemberテーブルにすでに登録されているmailかどうかをチェックする。
        $errors['member_check'] = "このメールアドレスはすでに利用されております。";
        */
    }
}

//ソースを全部読み込ませる
    //パスは自分がPHPMailerをインストールした場所で
    require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/POP3.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/OAuth.php';
require 'PHPMailer/language/phpmailer.lang-ja.php';

//公式通り
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if (count($errors) === 0){

    $url = "https://tb-210068.tech-base.net/mission7/new.php";


    $mailTo = $_POST['mail'];


    //Return-Pathに指定するメールアドレス
    $returnMail = '';

    $name = "ゴミ箱情報.com";
    $mail = '';
    $subject = "会員登録用URLのお知らせ";
    //メールの宛先

    $body = "メールに記載されたURLからご登録下さい。\n https://tb-210068.tech-base.net/mission7/new.php";
    $from  = "From: \r\n";
    $from .= "Return-Path: ";


    mb_language("japanese");
    mb_internal_encoding("UTF-8");



    //autoloderはcomposerでのインストールじゃないとないので
    //あえて記述しません。

    //SMTPの設定
    $mailer = new PHPMailer();//インスタンス生成
    $mailer->IsSMTP();//SMTPを作成
    $mailer->Host = 'smtp.gmail.com';//Gmailを使うのでメールの環境に合わせてね
    $mailer->CharSet = 'utf-8';//文字セットこれでOK
    $mailer->SMTPAuth = TRUE;//SMTP認証を有効にする
    $mailer->Username = ''; // Gmailのユーザー名
    $mailer->Password = ''; // Gmailのパスワード
    $mailer->SMTPSecure = 'tls';//SSLも使えると公式で言ってます
    $mailer->Port = 587;//tlsは587でOK
    //$mailer->SMTPDebug = 2;//2は詳細デバッグ1は簡易デバッグ本番はコメントアウトして

    //メール本体
    $message=$body;//メール本文
    $mailer->From     = ''; //差出人の設定
    $mailer->FromName = mb_convert_encoding("ゴミ箱情報.com","UTF-8","AUTO");//表示名おまじない付…
    $mailer->Subject  = mb_convert_encoding("会員登録用URLのお知らせ","UTF-8","AUTO");//件名の設定
    $mailer->Body     = mb_convert_encoding($message,"UTF-8","AUTO");//メッセージ本体
    $mailer->AddAddress($_POST['mail']); // To宛先

    //送信する
    if($mailer->Send()){
    }
    else{
        echo "送信に失敗しました" . $mailer->ErrorInfo;
    }


}

?>

<!DOCTYPE html>



<html>
    <head>
        <title>メール確認画面</title>
        <link rel="stylesheet" type="text/css" href="mission7_style.css" />
    </head>
    <body>
        <h1>ゴミ箱情報.com(仮称)</h1>
        <table>
            <tr>
                <td class="navi1">
                    <a href="mission7_new.php">新規作成</a>
                </td>
                <td class="navi1">
                    <a href="mission7_log.php">ログイン・ログアウト</a>
                </td>
            </tr>
        </table>

        <table border>
            <tr>
                <td class="navi2">
                    <a href="mission7_index.php">ホーム</a>
                </td>
                <td class="navi2">
                    <a href="mission7_mypage.php">マイページ</a>
                </td>
                <td class="navi2">
                    <a href="mission7_review.php">投稿</a>
                </td>
            </tr>
        </table>
        <br />
        >
        <h2>メール確認画面</h2>

        <?php if (count($errors) === 0): ?>


        <p>メールを送信しました。メールに記載されているURLから本登録をお願いします。</p>


        <?php elseif(count($errors) > 0): ?>

        <?php
        foreach($errors as $value){
            echo "<p>".$value."</p>";
        }
        ?>

        <input type="button" value="戻る" onClick="history.back()">

        <?php endif; ?>

        <hr />

    </body>
    <footer>
        <p id="sitemap">サイトマップ</p>
        <ul>
            <li>
                <a href="mission7_index.php">ホーム</a>
            </li>
            <li>
                <a href="mission7_mypage.php">マイページ</a>
            </li>
            <li>
                <a href="mission7_review.php">投稿</a>
            </li>
            <li>
                <a href="mission7_help.php">ヘルプ</a>
            </li>
            <li>
                <a href="mission7_origin.php">このサイトについて</a>
            </li>
            <li>
                <a href="mission7_admin.php">管理者用ページ</a>
            </li>
        </ul>
    </footer>
</html>
