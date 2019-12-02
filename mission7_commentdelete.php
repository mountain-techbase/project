<html>
	<head>
		<title>コメントの削除</title>
		<link rel="stylesheet" type="text/css" href="mission7_style.css" />
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

				$sql = 'SELECT * FROM 7_comment_tb';
				$stmt = $pdo->query($sql);
				$results = $stmt->fetchAll();
				foreach($results as $row){

					//削除元の投稿番IDとパスワードが一致したときに削除
					if($row['id']==$d_id && $row['pass']==$d_pass){

						$sql = 'delete from 7_comment_tb where id=:id';
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
		<h2>コメントの削除</h2>

		<!-必須・任意の注意書き-->
		「<span class="attention">※</span>」は入力・選択<span class="attention">必須</span><br />

		<form action="mission7_commentdelete.php">

			<!-コメントID入力フォーム-->
			<h3>削除したいコメントID</h3>
			<input type="tel" name="delete_id" size="32" maxlength="32" /><span class="attention">※</span><br />

			<!-パスワード入力フォーム-->
			<h3>パスワード</h3>
			<?php echo $error; ?>
			<input type="password" name="delete_pass" size="32" maxlength="32" /><span class="attention">※</span><br />

			<br />

			<!-削除ボタン-->
			<input type="submit" name="delete_send" value="削除" />

			<!-リセットボタン-->
			<input type="submit" name="reset" value="リセット" />
		</form>
		<hr />
	</body>
	<footer>
	<p sitemap>サイトマップ</p>
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
