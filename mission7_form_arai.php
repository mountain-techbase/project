<!DOCTYPE html>
<html lang = "en">

<head>
	<meta charset = "UFT-8">
	<title>投稿フォーム</title>
</head>

<body>

	<form action = "mission_7_form" method = "POST">
	
		<!-ユーザー名-->
		<input type="text" name="name" size="20" placeholder="ユーザーネーム / USER NAME"><br>
		<!-パスワード-->
		<input type="text" name="PW" size="50" placeholder="パスワード / PASSWORD"><br>
		<br>	
		<!-ゴミ箱の情報-->
		ゴミ箱の情報 / IMFORMATION
		<br><input type = "checkbox" name = "information" value = "可燃 / flammable">可燃 / FLAMMABLE
		<br><input type = "checkbox" name = "information" value = "不燃 / non-flammable">不燃 / NON-FLAMMABLE
		<br><input type = "checkbox" name = "information" value = "ペットボトル / PET bottles">ペットボトル / PET BOTTLES
		<br><input type = "checkbox" name = "information" value = "缶 / cans">	缶 / CANS
		<br><input type = "checkbox" name = "information" value = "ビン / BOTTLES">ビン / BOTTLES	
		<br><input type = "checkbox" name = "information" value = "その他 / OTHER">その他 / OTHER
		<br><br>
		<!-清潔感-->
		清潔感 / Was it clean?
		<br><input type = "radio" name = "cleanliness" value = "good">良い / GOOD!
		<br><input type = "radio" name = "cleanliness" value = "not bad">まあまあ / NOT BAD
		<br><input type = "radio" name = "cleanliness" value = "bad">悪い / BAD
		
		<br><br>
		<!-コメント-->
		<input type="text" name = "comment" size="50" placeholder="コメント/COMMENT"><br>	
		<br>
		<!-送信ボタン-->
		 <input type = "submit" name = "button1" value = "送信">
	           
 	</form>

</body>

</html>