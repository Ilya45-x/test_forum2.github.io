<?php
	header('Content-Type: text/html; charset=utf-8'); 
	//Задал кодировку UTF-8 для пых-пыха

	//Этот модуль возвращает в $_SESSION['autorized'] значение TRUE, 
	//если авторизация пройдена 
 
	//Начинаем сессию
	session_start(); 
	//Проверка, как запещен скрипт - обработчик? или может как форма для авторизации?
	if (!isset($_POST['enter']))
	{ 
	//Вывод формы авторизации
?> 
 
<html>
	<body>
		<font size="3" color="0000CC" face="Arial">
			<form method='post' action=''> Зайти на форум<BR><BR> 
			имя: <input type='text' name='name' value=''><BR><BR> 
			пароль: <input type='password' name='pass'><BR><BR> 
			<input name='enter' type='submit' value='Залогинится'>
		</font>
	</body>
</html>
 
<?php
	//header('Content-Type: text/html; charset=utf-8'); 
	}
	//Если как обработчик, то пытаемся авторизировать пользователя
	else 
	{ 
	//Проверка ввел ли пользователь имя и пароль 
	if ($_POST['name']!='' and $_POST['pass']!='') 
	{ 
		//Защита от взлома 
		$safe_name=mysql_escape_string($_POST['name']); 
		$safe_pass=mysql_escape_string($_POST['pass']); 
		//Преобразование пароля в хеш 
		$safe_pass=md5($safe_pass); 
		//Подключение к MySQL и базе данных 
		require_once('connect.php');  
		//формирование запроса 
		$sql="SELECT name,pass,role FROM USERS WHERE name='".$safe_name."' and pass='".$safe_pass."'"; 
		//Получение результата запроса в переменную $result 
		$result=mysql_query($sql); 
		//Проверка существования такого пользователя 
		if (!mysql_num_rows($result)) 
			//Если такого "Васька" нет, то отказываем ему в доступе 
			die("Косячок в логине или пароле <a href='index.php'> Отбой</a>"); 
			//Иначе пишем факт авторизации в сессию 
		else 
		{ 
			//получение результата запроса 
			$line=mysql_fetch_row($result); 
			//Запись факта авторизации в сессию
			$_SESSION['autorized']=true; 
           //Сохранить имя пользователя 
			$_SESSION['name']=$_POST['name']; 
			//Сохранить роль пользователя	
			$_SESSION['role']=$line[2]; 
			//Выводим пользователю инфу, что он нормально авторизировался как бы 
			echo "Авторизация успешна! <a href=index.php>Вернутся на форум</a>"; 
     } 
 } 
	//Если пользователь не ввел данные	 
	else 
	{ 
         //Отказать ему в доступе		 
         die("Косячок в логине или пароле <a href='index.php'> Назад!</a>"); 
	} 
} 
?>