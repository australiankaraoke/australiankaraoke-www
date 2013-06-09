<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_karaoke_db = "localhost";
$database_karaoke_db = "karaoke_db2";
$username_karaoke_db = "root";
$password_karaoke_db = "root";
$karaoke_db = mysql_pconnect($hostname_karaoke_db, $username_karaoke_db, $password_karaoke_db) or trigger_error(mysql_error(),E_USER_ERROR); 
?>