<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
?>
<?php
// セッション開始
session_start();
// 既にログインしている場合にはメインページに遷移
if (isset($_SESSION['USERID'])) {
    header('Location: mission7_index2.php');
    exit;
}
$db['host'] = 'localhost';
$db['user'] = '';
$db['pass'] = '';
$db['dbname'] = '';
$error = '';
// ログインボタンが押されたら
if (isset($_POST['signUp'])) {
    if (empty($_POST['username'])) {
        $error = 'ユーザーIDが未入力です。';
    }else if (empty($_POST['password'])) {
        $error = 'パスワードが未入力です。';
    }
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $dsn='mysql:dbname=;host=localhost';
        $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $sql = "CREATE TABLE IF NOT EXISTS user"
            ." ("
            . "id INT(11) AUTO_INCREMENT PRIMARY KEY,"
            . "name char(32),"
            . "password char(255)"
            .");";
        $stmt = $pdo->query($sql);
        // idの重複とパスワードの桁数チェック
        function cheak($id,$count){
            if($count > 0){
                throw new Exception('そのユーザーIDは既に使用されています。');
            }
            if ($id < 8) {
                throw new Exception('パスワードは8桁以上で入力してください。');
            }
        }
        try{
            //$sqlname = 'SELECT COUNT(*) FROM user WHERE `name` = $username';
            //$ss = $pdo->query($sqlname);
            //$count = $ss->fetchColumn();
            //$id = strlen($_POST['password']);
            //cheak($id,$count);
            $stmt = $pdo->prepare('INSERT INTO `user`(`name`, `password`) VALUES (:username, :password)');
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['USERID'] = $username;
            echo '<script>
    alert("登録が完了しました。");
    location.href="mission7_index2.php";
    </script>';
        } catch(Exception $e){
            $error = $e->getMessage();
        }
    }
}
?>
<html>
    <head>
        <title>会員登録画面</title>
        <link rel="stylesheet" type="text/css" href="mission7_style.css" />
        <link rel="stylesheet" href="style.css" type="text/css" />
        <link rel="stylesheet" href="mission7_style_add.css" type="text/css" />
        <style>
            html { height: 100% }
            body { height: 100% }
            #map { height: 100%; width: 100%}
        </style>

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
        >
        <h2>会員登録画面</h2>
        <main>
            <form id="loginForm" name="loginForm" action="new.php" method="POST">
                <p style="color:red;"><?php echo $error ?></p>
                <label for="username">ユーザーID<br>
                    <input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                </label><br>
                <label for="password">パスワード<br>
                    <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">※8桁以上
                </label>
                <input type="submit" id="signUp" name="signUp" value="新規登録" class="btn up">
            </form>
        </main>

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

