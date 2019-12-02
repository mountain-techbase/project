<?php
/*
// セッション開始

session_start();

// セッションのライフタイム変更

// セッションが存在していない(タイムアウトもしくはログアウトされている)
if(empty($_SESSION['USERID'])) {
    header('Location:mission7_admin.php');
    // ここにログイン処理を書く（ログイン画面に遷移させる）

    // セッションが存在している場合はセッションのライフタイムを更新
} else {
    unset($_SESSION['USERID']);
    $_SESSION['USERID'] = true;
}
*/
?>
<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
$dsn='mysql:dbname=;host=localhost';
$user = '';
$pass = '';
$pdo = new PDO($dsn, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
if (!empty($_POST["delete"]) && isset($_POST["delbtn"])) {
    $id = ($_POST["delete"]);
    $sql = 'SELECT * FROM markers';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        if($id == $row['id']){
            $sql = 'delete from markers where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
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
<html lang="ja">

<head>
    <title>管理者用ページ</title>
    <link rel="stylesheet" type="text/css" href="mission7_style.css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
	<link rel="stylesheet" href="mission7_style_add.css" type="text/css" />
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">



    <style>
        html {
            height: 100%
        }

        body {
            height: 100%
        }

        #map {
            height: 100%;
            width: 100%
        }

    </style>
</head>


<body>
    <h1><a class="title" href="mission7_index.php">ゴミ箱情報.com(仮称)</a></h1>
		<ul class="menu">
			<li>
				<a href="mission7_mypage.php">マイページ / MY PAGE</a>
			</li>
			<li>
				<a href="mission7_logout.php">ログアウト / LOGOUT</a>
			</li>
		</ul>
    </table>

    <table border>
        <tr>
            <td class="navi2">
                <a href="mission7_index.php">ホーム / HOME</a>
            </td>
            <td class="navi2">
                <a href="mission7_mypage.php">マイページ / MY PAGE</a>
            </td>
            <td class="navi2">
                <a href="mission7_review.php">投稿 / POST</a>
            </td>
        </tr>
    </table>
    <br />

    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map"></div>
    <script type="text/javascript" src="admin.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6FWqAGLasQ17ZFjUt5wLY_Jw28jWpMmg&libraries=places&callback=initAutocomplete" async defer></script>

    <form action="mission7_admin2.php" method = "post">
        <h3>削除フォーム</h3>
        削除対象番号<br>
        <input type="text" name="delete"><br>
        <input type="submit" value="削除" name="delbtn"><br>

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
