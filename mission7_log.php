<?php
session_start();

$db['host'] = 'localhost';
$db['user'] = 'tb-210065';
$db['pass'] = 'z9GcJDXP4d';
$db['dbname'] = 'tb210065db';
$error = '';
// ログインボタンが押されたら
if (isset($_POST['login'])) {
    if (empty($_POST['username'])) {
        $error = 'ユーザーIDが未入力です。';
    } else if (empty($_POST['password'])) {
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
                header('Location: mission7_review.php');
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
        <title>ログイン・ログアウト</title>
        <link rel="stylesheet" type="text/css" href="mission7_style.css" />
        <script src="js/final1.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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
        <h2>ログイン・ログアウト</h2>
        <main>
            <div class="container">
                <div class="login-container">
                    <div id="output"></div>
                    <div class="avatar">
                    </div>
                    <div class="form-box">
                        <form id="loginForm" name="loginForm" action="signUp.php" method="POST">
                            <p style="color:red;"><?php echo $error ?></p>
                            <br>
                            <input type="text" id="username" name="username" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                            <br>
                            <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                            <button class="btn btn-info btn-block login" type="submit" id="login" name="login">ログイン</button>
                        </form>
                    </div>
                </div>

            </div>


        </main>

        <a href="mission7_logout.php">ログアウト画面へ</a>

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
