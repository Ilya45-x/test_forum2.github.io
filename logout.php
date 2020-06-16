<?php
header('Content-Type: text/html; charset=utf-8');
//Уничтожение сессии
session_start(); 
session_unset(); 
session_destroy(); 
//Перенаправление пользователя на index.php 
header('location:index.php'); 
?>