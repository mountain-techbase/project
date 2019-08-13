<?php
session_start();
// セッションクリア
session_destroy();
$error = "ログアウトしました。";
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
        <div><?php echo $error; ?></div>
        <ul>
            <li><a href="mission7_index.php">ホームへ</a></li>
        </ul>

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
