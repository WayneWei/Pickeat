<?php
	$host="localhost";//please modify as "140.116.245.148" when you upload
	$user="root";//your student id.
	$pw="root";//your pw.
	$db="Pickeat";//your student id.
	
	if(!@mysql_connect($host, $user, $pw))
        die("無法對資料庫連線");
    mysql_query("SET NAMES UTF8");  
	if(!@mysql_select_db($db))
        die("無法使用資料庫");
?>