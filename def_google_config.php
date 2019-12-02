<?php
/*************************************************/
//ディレクトリに応じて、
//google api にアクセスするURI、
//defineで定義するREDIRECT_URIを必ず変更する
/**************************************************/

define(
    "CLIENT_ID",
    "823859821379-15s02f2ffltktdcs3gf3fffq2oohkchp.apps.googleusercontent.com"
);
define("CLIENT_SECRET", "YEsUsbpvTNZ0hW1hE74hhOon");
define(
    "REDIRECT_URI",
    "https://tb-210068.tech-base.net/mission7/after_google_oauth.php"
);

define("TOKEN_URI", "https://oauth2.googleapis.com/token");
//define("INFO_URL", "https://www.googleapis.com/auth/userinfo.profile");

define("AFTER_FINISHING_LOGIN", "mission7_index2.php");
