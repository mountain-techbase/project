<html lang="ja">
    <head>
        <title>ゴミ箱がどこにあるのか知りたくなったら「ゴミ箱情報.com(仮称)」</title>
        <link rel="stylesheet" type="text/css" href="mission7_style.css" />
        <link rel="stylesheet" href="style.css" type="text/css" />



        <style>
            html { height: 100% }
            body { height: 100% }
            #map { height: 100%; width: 100%}
        </style>
    </head>

    <?php
        //データベースに接続
        //データベース名
        $dsn = 'mysql:dbname=tb210068db;host=localhost';

        //ユーザ名
        $user = 'tb-210068';

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
        ."comment TEXT,"
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
            }else if(empty($name) || empty($pass) || empty($garbage) || empty($clean)){
                echo "記入漏れがあります。";
            }
        }
    ?>

    <?php
    $dsn='mysql:dbname=tb210065db;host=localhost';
    $user = 'tb-210065';
    $password = 'z9GcJDXP4d';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    //$sql = "DROP TABLE IF EXISTS markers";
    //$pdo -> exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS markers"
        ." ("
        . "id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"
        . "info VARCHAR( 200 ) NOT NULL, "
        . "clean VARCHAR( 60 ) NOT NULL,"
        . "lat FLOAT( 10, 6 ) NOT NULL,"
        . "lng FLOAT( 10, 6 ) NOT NULL"
        //. "type VARCHAR( 30 ) NOT NULL"
        .") ENGINE = MYISAM;";
    $stmt = $pdo->query($sql);
    if(!empty($_POST["sub"])){
        $sql = $pdo -> prepare("INSERT INTO markers (    info, clean, lat ,  lng  ) VALUES (    :info, :clean, :lat ,  :lng  )");
        $sql -> bindParam(':info', $info, PDO::PARAM_STR);
        $sql -> bindParam(':clean', $clean, PDO::PARAM_STR);

        $sql -> bindParam(':lat', $lat, PDO::PARAM_STR);
        $sql -> bindParam(':lng', $lng, PDO::PARAM_STR);
        //$sql -> bindParam(':type', $type, PDO::PARAM_STR);
        $info = implode("|", $_POST["information"]);
        $clean = $_POST["cleanliness"];
        $type = 'bar';
        $lat = $_POST["lat"];
        $lng = $_POST["lng"];
        $sql -> execute();

    }



    ?>

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

        <a href="mission7_review.php">位置情報登録画面へ</a> <br>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div id="map"></div>
        <script type="text/javascript" src="script.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places&callback=initAutocomplete"
                async defer></script>

        <form action="mission7_index.php" method="POST">

            <!-必須・任意の注意書き-->
            「<span class="attention">※</span>」は入力・選択<span class="attention">必須</span><br />

            ユーザーネーム / User Name<br />
            <input type="text" name="name" size="20" value="名無しさん" /><br />

            コメント / Comment<br />
            <textarea name="comment" placeholder="例：その場所は初知りです！" cols="90" rows="10"></textarea>

            <!-送信ボタン-->
            <input type="submit" name="send" value="送信" />

            <!-リセットボタン-->
            <input type="reset" name="reset" value="入力リセット" />
        </form>
        <hr />
        <?php
            //投稿内容を表示
            $sql = 'SELECT * FROM 7_comment_tb';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach($results as $row){
                echo $row['id'].' / ';
                echo $row['name'].' / ';
                echo $row['comment'].' / ';
                echo $row['date'].'<br>';
                echo "<hr>";
            }
        ?>
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
