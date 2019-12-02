<html lang="ja">
    <head>
        <title>ゴミ箱・ゴミ箱情報なら【ゴミ箱情報.com(仮称)】</title>
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

    <?php
    //データベースに接続
    //データベース名
    $dsn = 'mysql:dbname=;host=localhost';

    //ユーザ名
    $user = '';

    //パスワード
    $password = '';

    //データベース上のエラーを表示
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    //テーブルの作成
    $sql = "CREATE TABLE IF NOT EXISTS 7_comment_tb"
        ." ("
        ."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
        ."name char(32),"
        ."pass char(32),"
        ."comment VARCHAR( 200 ),"
        ."date char(32)"
        .");";
    $stmt = $pdo->query($sql);

    //エラー「Notice」を表示しない。
    error_reporting(E_ALL & ~E_NOTICE);

    //データの受け取り
    //名前
    $name = ($_POST['name']);

    //パスワード
    $pass = ($_POST['pass']);

    //コメント
    $comment = ($_POST['comment']);

    //日付データ
    $date = date("Y年m月d日 H:i:s");

    //送信ボタン
    $send = ($_POST['send']);

    //送信ボタンが押されたとき
    if(isset($send)){

        //名前、パスワード、ゴミ箱の情報、清潔感が入力されているとき
        if(!empty($name) && !empty($pass) && !empty($garbage) && !empty($clean)){

            //投稿データを入力
            $sql = $pdo -> prepare("INSERT INTO 7_comment_tb (name, pass, comment, date) VALUES (:name, :pass, :comment, :date)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql -> execute();

            //記入漏れがあるとき
        }else if(empty($name) || empty($comment) || empty($pass)){
            echo "記入漏れがあります。 / There is an omission.";
        }
    }
    ?>

    <?php
    $dsn='mysql:dbname=;host=localhost';
    $user = '';
    $password = '';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    //$sql = "DROP TABLE IF EXISTS markers";
    //$pdo -> exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS markers"
        ." ("
        . "id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"
        . "info VARCHAR( 200 ) NOT NULL, "
        . "clean VARCHAR( 60 ) NOT NULL,"
        . "lat FLOAT( 10, 6 ) NOT NULL,"
        . "lng FLOAT( 10, 6 ) NOT NULL,"
        . "comment VARCHAR( 200 ) NOT NULL"
        .") ENGINE = MYISAM;";
    $stmt = $pdo->query($sql);
    if(!empty($_POST["sub"])){
        $sql = $pdo -> prepare("INSERT INTO markers (    info, clean, lat ,  lng, comment  ) VALUES (    :info, :clean, :lat ,  :lng, :comment  )");
        $sql -> bindParam(':info', $info, PDO::PARAM_STR);
        $sql -> bindParam(':clean', $clean, PDO::PARAM_STR);

        $sql -> bindParam(':lat', $lat, PDO::PARAM_STR);
        $sql -> bindParam(':lng', $lng, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $info = implode("　", $_POST["information"]);
        $clean = $_POST["cleanliness"];
        $comment = $_POST["comment"];
        $lat = $_POST["lat"];
        $lng = $_POST["lng"];
        $sql -> execute();

    }



    ?>

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
        <?php
        session_start();
        echo "<h2>ようこそ　" . $_SESSION['USERID'] . "　さん</h2>";
        ?>

        <br><br>

        <a href="mission7_review.php" class="btn-border-bottom">位置情報登録画面へ / REGISTER POSITION INFORMATION</a>
        <br>
        <br>
        <br>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div id="map"></div>
        <script type="text/javascript" src="script.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6FWqAGLasQ17ZFjUt5wLY_Jw28jWpMmg&libraries=places&callback=initAutocomplete"
                async defer></script>

        <form action="mission7_index.php" method="POST">
<div class="box12">
            <!-必須・任意の注意書き-->
            「<span class="attention">※</span>」は入力・選択<span class="attention">必須</span><br />
            Items marked with <span class="attention">※</span> are essential.<br />


            ユーザーネーム / User Name<br />
            <input type="text" name="name" size="32" maxlength="32" value="名無しさん / NAMELESS" /><span class="attention">※</span><br />

            コメント / Comment<br />
            <textarea name="comment" placeholder="例：その場所は初知りです！ / I've never knew it!" cols="90" rows="10" maxlength="200"></textarea><span class="attention">※</span><br />

            パスワード / Password<br />
            <input type="password" name="pass" size="32" maxlength="32" /><span class="attention">※</span><br />

            <!-送信ボタン-->
            <input type="submit" name="send" value="送信 / SUBMIT" />

            <!-リセットボタン-->
            <input type="reset" name="reset" value="入力リセット / RESET" />
            </div>
        </form>
        <hr />
        <?php
        //    //投稿内容を表示
        //    $sql = 'SELECT * FROM 7_comment_tb';
        //    $stmt = $pdo->query($sql);
        //    $results = $stmt->fetchAll();
        //    foreach($results as $row){
        //        echo $row['id'].' / ';
        //        echo $row['name'].' / ';
        //        echo $row['comment'].' / ';
        //        echo $row['date'].'<br>';
        //        echo "<hr>";
        //    }

        ?>
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
