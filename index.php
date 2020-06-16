<?php
//Задал кодировку UTF-8 для пых-пыха
header('Content-Type: text/html; charset=utf-8');
//Цвет фона
//echo "<body style='background-color:CCCC99'>";
//Запуск сессии
session_start(); 
//Подключение к MySQL базе данных FORUM 
require_once('connect.php'); 
 
//Если пользователь не авторизирован, то вывести ссылку на login.php 
if (!isset($_SESSION['autorized'])) 
{ 
  ?> 
  <p align='right'> 
  <a href='login.php'>Зайти</a><BR>
 </p> 
  <?php 
  $_SESSION['name']='guest'; 
  $_SESSION['role']='user'; 
} 
else 
{ 
//Если пользователь авторизирован, то сообщить ему об этом 
//и вывести ссылку на logout.php 
  echo "<p align='right'>Ты залогинен под ником: ".$_SESSION['name']."<BR>"; 
  echo "<a href='logout.php'>Выйти
</a></p>"; 
} 
 
//Если выполняется действие
if (isset($_GET['act'])) 
{ 
    //То подключить модуль отвечающий за это и совершить действие
    require_once('action.php'); 
} 
//Иначе просто вывод информации производится
else 
    require_once('show.php'); 
?>