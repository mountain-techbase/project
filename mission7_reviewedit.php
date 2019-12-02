<html>
	<head>
		<title>レビューの編集</title>
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
		<h2>レビューの編集 / EDIT REVIWE</h2>

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