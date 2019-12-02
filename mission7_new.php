
<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

?>
<html>
    <head>
        <title>アカウント新規作成</title>
        <link rel="stylesheet" type="text/css" href="mission7_style.css" />
        <link rel="stylesheet" type="text/css" href="mission7_style_add.css" />
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body>
        <h1><a class="title" href="mission7_index.php">ゴミ箱情報.com(仮称)</a></h1>
   <ul class="menu">
       <li>
           <a href="mission7_new.php">新規作成 / CREATE ACCOUNT</a>
       </li>
       <li class="login">
           <a href="mission7_log.php">ログイン / LOGIN</a>
       </li>
       <li>
           <a href="mission7_review.php">投稿 / POST</a>
       </li>
       <li>
           <a href="mission7_mypage.php">マイページ / MY PAGE</a>
       </li>
       <li>
           <a href="mission7_logout.php">ログアウト / LOGOUT</a>
       </li>
     </ul>
        <br />
        <h2>アカウント新規作成 / CREATE NEW ACCOUNT</h2>
        <br>
        登録したいメールアドレスを入力してください。
        <br>
        Enter your email adress.
        <br>

        <form action="registration_mail_check.php" method="post">

            <p class="mail">メールアドレス / MAIL ADDRESS<br><input type="text" name="mail" size="50"></p>

            <input type="hidden" name="token" value="<?=$token?>">
            <input type="submit" value="登録する / SIGN UP">

        </form>

        <hr />

    </body>
    <footer>
    <p id="sitemap">サイトマップ / SITE MAP</p>
        <ul>
            <li>
                <a href="mission7_index.php">ホーム / HOME</a>
            </li>
            <li>
                <a href="mission7_mypage.php">マイページ / MY PAGE</a>
            </li>
            <li>
                <a href="mission7_review.php">投稿 / POST</a>
            </li>
            <li>
                <a href="mission7_help.php">ヘルプ / HELP</a>
            </li>
            <li>
                <a href="mission7_origin.php">このサイトについて / ABOUT THIS SITE</a>
            </li>
            <li>
                <a href="mission7_admin.php">管理者用ページ / MANAGER PAGE</a>
            </li>
        </ul>
    </footer>
</html>
