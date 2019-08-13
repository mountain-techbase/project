
<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
?>
<?php
// セッション開始
session_start();
// 既にログインしている場合にはメインページに遷移
if (isset($_SESSION['USERID'])) {
    header('Location: signUp.php');
    exit;
}
$db['host'] = 'localhost';
$db['user'] = 'tb-210065';
$db['pass'] = 'z9GcJDXP4d';
$db['dbname'] = 'tb210065db';
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
        $dsn='mysql:dbname=tb210065db;host=localhost';
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
    location.href="mission7_log.php";
    </script>';
        } catch(Exception $e){
            $error = $e->getMessage();
        }
    }
}
?>
<html>
    <head>
        <title>アカウント新規作成</title>
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
        <h2>アカウント新規作成</h2>
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
