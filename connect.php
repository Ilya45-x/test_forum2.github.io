<?php
	//хостинг 
	$sqlhost="localhost";
	//$sqlhost="forum.ru";
	//имя пользователя
	//$sqluser="mysql";
	$sqluser="mysql";
	//пароль
	$sqlpass="mysql";
	//имя базы данных 
	$db="FORUM"; 
	//Подключение к MySQL 
	mysql_connect($sqlhost, $sqluser,$sqlpass)or die("MySQL не доступен! ".mysql_error()); 
	//Подключение к базе данных 
	mysql_select_db($db)or die("Нет соединения с базой данных! ".mysql_error()); 
?> 