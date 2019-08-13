<html lang="ja">
	<head>
		<title>ゴミ箱がどこにあるのか知りたくなったら「ゴミ箱情報.com(仮称)」</title>
		<link rel="stylesheet" type="text/css" href="mission7_style.css" />

		<script src="https://maps.google.com/maps/api/js?key=AIzaSyC7bsOVUzPKA_ReCMKAfV69lBM3soX08og&language=ja"></script>

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

		<div id="map"></div>

		<script>
			var MyLatLng = new google.maps.LatLng(35.675947, 139.733383);
			var Options = {
				zoom: 15,      //地図の縮尺値
				center: MyLatLng,    //地図の中心座標
				mapTypeId: 'roadmap'   //地図の種類
			};
			var map = new google.maps.Map(document.getElementById('map'), Options);
		</script>

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