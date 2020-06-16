<?php
//Кодировка для подключения к к БД MySQL
mysql_set_charset('utf8');
echo "<body style='background-color:CCCC99'>";
//echo '<i style="color:blue;font-size:30px;font-family:calibri ;"></i> ';
//echo '<span style="color: red">'.$res['inf'].'</span>'; // v1

//Запуск этого скрипта без параметра show, переданного в GET–строке, приведет к выводу разделов 
if (!isset($_GET['show'])) 
{ 
    //Задание SQL запроса 
    $sql="SELECT id, name FROM TOPIC WHERE kodofrazdel=0"; 
    //Выполнение этого запроса
    $data=mysql_query($sql); 
    //Надпись "Список разделов" 
    echo "<BIG><B>Список разделов</B></BIG><BR><BR>"; 
    //Вывод списка разделов
    while($line=mysql_fetch_row($data)) 
    { 
?> 
       
<table BORDER=1 cellpadding=20 width=100%>
	<tr> 
		<td>
          <?php 
          //Ссылка на index.php только с параметром show=topic 
          echo '<a href="?show=topic&numrazdel= '.$line[0].'">'.$line[1]."</a>"; 
          ?>
        </td>
     </tr>
</table>

<?php
    } 
    //Больше ничего выполнять не надо 
    exit; 
}// end - if (!isset($_GET['show'])) 
 
 
//Если задан параметр show, то в зависимости от него вывод соответствующей информации. 
switch ($_GET['show']) 
{ 
//Если надо вывести темы выбранного раздела 
case 'topic': 
     require_once('SHOW_MODULE/show_topic.php'); 
     break;
//Если надо вывести сообщения для выбранной темы 
case 'message': 
     require_once('SHOW_MODULE/show_message.php'); 
     break;
//Если нужно вывести форму создания темы 
case 'add_topic': 
     require_once('SHOW_MODULE/show_addtopic.php'); 
     break; 
//Если нужно вывести форму редактирования темы
case 'edit_topic': 
     require_once('SHOW_MODULE/show_edittopic.php'); 
     break;
//Если надо удалить тему 
case 'del_topic': 
     require_once('SHOW_MODULE/show_deltopic.php'); 
     break; 
//Если нужно вывести форму редактирования сообщения 
case 'edit_message': 
     require_once('SHOW_MODULE/show_editmessage.php'); 
     break;
//Если надо удалить 
case 'del_message': 
     require_once('SHOW_MODULE/show_delmessage.php'); 
     break; 
}//end - case 
?> 