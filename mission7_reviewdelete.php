<html>
	<head>
		<title>レビューの削除</title>
		<link rel="stylesheet" type="text/css" href="mission7_style.css" />
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="mission7_style_add.css" type="text/css" />
		<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	</head>

	<?php
		// セッション開始

		session_start();

		// セッションのライフタイム変更

		// セッションが存在していない(タイムアウトもしくはログアウトされている)
		if(empty($_SESSION['USERID'])) {
		    header('Location:mission7_log.php');
 			// ここにログイン処理を書く（ログイン画面に遷移させる）

			// セッションが存在している場合はセッションのライフタイムを更新
		} else {
			unset($_SESSION['USERID']);
			$_SESSION['USERID'] = true;
		}
	?>

	<?php
		$dsn='mysql:dbname=;host=localhost';
		$user = '';
		$password = '';
		$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

		//エラー「Notice」を表示しない。
		error_reporting(E_ALL & ~E_NOTICE);

		//削除したい投稿ID
		$d_id = ($_POST['delete_id']);

		//削除したい投稿のパスワード
		$d_pass = ($_POST['delete_pass']);

		//送信ボタン
		$d_send = ($_POST['delete_send']);

		//送信ボタンを押されたとき
		if(isset($d_send)){

			if(!empty($d_id) && !empty($d_pass)){

				$sql = 'SELECT * FROM markers';
				$stmt = $pdo->query($sql);
				$results = $stmt->fetchAll();
				foreach($results as $row){

					//削除元の投稿番IDとパスワードが一致したときに削除
					if($row['id']==$d_id && $row['pass']==$d_pass){

						$sql = 'delete from markers where id=:id';
						$stmt = $pdo->prepare($sql);
						$stmt -> bindParam(':id', $d_pass, PDO::PARAM_INT);
						$stmt -> execute();

					//指定した投稿のパスワードが一致しないときの警告
					}else if($row['id']==$d_id && $row['pass']!=$d_pass){
						$error = "パスワードが誤っています";
					}

				}

			}

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
		</table>
		<br />
		<h2>レビューの削除 / DELETE REVIEW</h2>

		<!-必須・任意の注意書き-->
		「<span class="attention">※</span>」は入力・選択<span class="attention">必須</span><br />
		 Items marked with <span class="attention">※</span> are essential.

		<form action="mission7_reviewdelete.php">

			<!-ID入力フォーム-->
			<h3>削除したい投稿ID / ID to Delete</h3>
			<input type="tel" name="delete_id" size="32" maxlength="32" /><span class="attention">※</span><br />

			<!-パスワード入力フォーム-->
			<h3>パスワード/ PW</h3>
			<?php echo $error; ?>
			<input type="password" name="delete_pass" size="32" maxlength="32" /><span class="attention">※</span><br />

			<br />

			<!-削除ボタン-->
			<input type="submit" name="delete_send" value="削除 / DELETE" />

			<!-リセットボタン-->
			<input type="submit" name="reset" value="リセット / RESET" />
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
