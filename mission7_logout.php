<html>
    <head>
        <title>ログイン・ログアウト</title>
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
                <a href="mission7_new.php">新規作成</a>
            </li>
            <li class="login">
                <a href="mission7_log.php">ログイン</a>
            </li>
            <li>
                <a href="mission7_review.php">投稿</a>
            </li>
            <li>
                <a href="mission7_mypage.php">マイページ</a>
            </li>
            <li>
                <a href="mission7_logout.php">ログアウト</a>
            </li>
        </ul>
        <br />
>
        <h2>ログアウト</h2>
        <?php
        session_start();

        header("Content-type: text/html; charset=utf-8");

        //セッション変数を全て解除
        $_SESSION = array();

        //セッションクッキーの削除
        if (isset($_COOKIE["PHPSESSID"])) {
            setcookie("PHPSESSID", '', time() - 1800, '/');
        }

        //セッションを破棄する
        session_destroy();

        echo "<p>ログアウトしました。</p>";

        echo "<a href='mission7_index.php'>ホームへ</a>";
        ?>


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
