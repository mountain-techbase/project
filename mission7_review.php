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
		$sql = "CREATE TABLE IF NOT EXISTS 7_review_tb"
		." ("
		."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
		."name char(32),"
		."pass char(32),"
		."information cher(1),"	//要編集
		."clean cher(1),"
		."review TEXT,"
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

		//ゴミ箱のチェックボックス
		$information = ($_POST['information']);

		//清潔感のラジオボタン
		$clean = ($_POST['clean']);

		//レビュー
		$review = ($_POST['review']);

		//日付データ
		$date = date("Y年m月d日 H:i:s");

		//送信ボタン
		$send = ($_POST['send']);

		//送信ボタンが押されたとき
		if(isset($send)){

			//名前、パスワード、ゴミ箱の情報、清潔感が入力されているとき
			if(!empty($name) && !empty($pass) && !empty($information) && !empty($clean)){

				//投稿データを入力
				$sql = $pdo -> prepare("INSERT INTO 5_tb (name, pass, information, clean, review, date) VALUES (:name, :pass, :garbage, :clean, :review, :date)");
				$sql -> bindParam(':name', $name, PDO::PARAM_STR);
				$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
				$sql -> bindParam(':information', $information, PDO::PARAM_STR);
				$sql -> bindParam(':clean', $clean, PDO::PARAM_STR);
				$sql -> bindParam(':review', $comment, PDO::PARAM_STR);
				$sql -> bindParam(':date', $date, PDO::PARAM_STR);
				$sql -> execute();

			//記入漏れがあるとき
			}else if(empty($name) || empty($pass) || empty($information) || empty($clean)){
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

		<h2>投稿用フォーム</h2>

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

		<form action="mission7_review.php" method="POST">

			<!-必須・任意の注意書き-->
			「<span class="attention">※</span>」は入力・選択<span class="attention">必須</span>

			<!-ユーザーネーム-->
			<h3>ユーザーネーム / User Name</h3>
			<input type="text" name="name" size="20" value="名無しさん" /><br />

			<br />

			<!-レビュー-->
			<h3>レビュー / Review</h3><span class="attention2">任意</span>
			<textarea name="review" placeholder="例：中がいっぱいになることが多いです。" cols="180" rows="10"></textarea><br />

			<br />

			<!-ゴミ箱の情報-->
			ゴミ箱の情報 / IMFORMATION
			<br><input type = "checkbox" name = "information" value = "可燃 / flammable">可燃 / FLAMMABLE
			<br><input type = "checkbox" name = "information" value = "不燃 / non-flammable">不燃 / NON-FLAMMABLE
			<br><input type = "checkbox" name = "information" value = "ペットボトル / PET bottles">ペットボトル / PET BOTTLES
			<br><input type = "checkbox" name = "information" value = "缶 / cans">	缶 / CANS
			<br><input type = "checkbox" name = "information" value = "ビン / BOTTLES">ビン / BOTTLES
			<br><input type = "checkbox" name = "information" value = "その他 / OTHER">その他 / OTHER

			<br>

			<!-清潔感-->
			清潔感 / Was it clean?
			<br><input type = "radio" name = "clean" value = "good">良い / GOOD!
			<br><input type = "radio" name = "clean" value = "not bad">まあまあ / NOT BAD
			<br><input type = "radio" name = "clean" value = "bad">悪い / BAD

			<br />

			<!-送信ボタン-->
			<input type="submit" name="send" value="送信" />

			<!-リセットボタン-->
			<input type="reset" name="reset" value="入力リセット" />
		</form>
		<hr />
		<?php
			//投稿内容を表示
			$sql = 'SELECT * FROM 7_tb';
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach($results as $row){
				echo $row['id'].' / ';
				echo $row['name'].' / ';
				echo $row['information'].' / ';
				echo $row['clean'].' / ';
				echo $row['review'].' / ';
				echo $row['date'].'<br>';
				echo "<hr>";
			}
		?>
	</body>
	<footer>
	<p ="sitemap">サイトマップ</p>
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