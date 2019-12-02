<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
?>
<?php
session_start();
// 既にログインしている場合にはメインページに遷移
if (isset($_SESSION["USERID"])) {
    header('Location: mission7_index2.php');
    exit;
}
$db['host'] = 'localhost';
$db['user'] = '';
$db['pass'] = '';
$db['dbname'] = '';
$error = '';
// ログインボタンが押されたら
if (isset($_POST['login'])) {
    if (empty($_POST['username'])) {
        $error = 'ユーザーIDが未入力です。';
    } elseif (empty($_POST['password'])) {
        $error = 'パスワードが未入力です。';
    }
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $stmt = $pdo->prepare('SELECT * FROM user WHERE name = ?');
            $stmt->execute(array($username));
            $password = $_POST['password'];
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $result['password'])) {
                $_SESSION['USERID'] = $username;
                header('Location: mission7_index2.php');
                exit();
            } else {
                $error = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>
<html>

    <head>
        <title>ログイン</title>
        <link rel="stylesheet" type="text/css" href="mission7_style.css" />
        <!--ここから-->
        <link rel="stylesheet" href="style.css" type="text/css" />
        <link rel="stylesheet" href="mission7_style_add.css" type="text/css" />
        <style>
            html { height: 100% }
            body { height: 100% }
            #map { height: 100%; width: 100%}
        </style>

        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
        <!--ここまでコピペ-->
    </head>

    <body>
       <!--ここから-->
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
        <!--ここまでコピペ-->
        <br />
        <h2>ログイン</h2>
        <main>
            <div class="container">
                <div class="login-container">
                    <div id="output"></div>
                    <div class="avatar">
                    </div>
                    <div class="form-box">
                        <form id="loginForm" name="loginForm" action="mission7_log.php" method="POST">
                            <p style="color:red;"><?php echo $error ?>
                            </p>
                            <br>
                            <input type="text" id="username" name="username" size=40 placeholder="ユーザーIDを入力  / ENTER USER ID" value="<?php if (!empty($_POST["username"])) {
    echo htmlspecialchars($_POST["username"], ENT_QUOTES);
} ?>">
                            <br>
                            <input type="password" id="password" name="password" size=40 value="" placeholder="パスワードを入力 / ENTER YOUR PW">
                            <button class="btn btn-info btn-block login" type="submit" id="login"
                                name="login">ログイン / LOGIN </button>
                        </form>
                    </div>
                </div>

            </div>


        </main>
        <?php

        header("Content-type: text/html; charset=utf-8");

        if (!isset($_SESSION['access_token'])) {
            echo "<a href='login.php'>Twitterでログイン / Login with twitter</a>";

            //追記(鈴木圭)
            //グーグルアカウントでログインするためのページへの遷移
            echo "<br>";
            echo "<a href='before_google_oauth.php'>googleでログイン / Login with goolge</a>";
        }
        ?>


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
