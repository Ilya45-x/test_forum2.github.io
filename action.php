<?php
//Кодировка для подключения к БД MySQL
mysql_set_charset('utf8');
echo "<body style='background-color:CCCC99'>";
//Добавление темы
if ($_GET['act']=='add_topic') 
{
	//Обработка названия темы в целях безопасности
    $safe_topic=mysql_escape_string($_POST['name_topic']); 
    //SQL-запрос для добавления темы 
    $sSQL="INSERT INTO TOPIC SET 
kodofrazdel=".$_GET['numrazdel'].", name='".$safe_topic."', 
name_creater='".$_SESSION['name']."', 
date_last_answer='".date('Y-m-d')."'"; 
    //Выполнение запроса 
    mysql_query($sSQL)or die(mysql_error()); 
    //Обработка нтекста сообщения в целях безопасности
    $safe_message=mysql_escape_string($_POST['message']); 
    //Определение номера созданной темы
    $id=mysql_insert_id(); 
    //SQL-запрос для создания сообщения в вновь созданной теме 
    $sSQL="INSERT INTO MESSAGE  SET kodoftopic=".$id.", 
text_message='".$safe_message."', name_man='".$_SESSION['name']."', 
date_answer='".date('Y-m-d')."'"; 
    //Выполнение запроса 
    mysql_query($sSQL)or die(mysql_error()); 
    //Вывод надписи и ссылки на список тем для текущего раздела 
    echo "Тред создан<BR>"; 
    echo "<a href='index.php?show=topic&numrazdel= 
".$_GET['numrazdel']."'>"; 
    echo "Назад к списку тредов</a>"; 
} 
 
//Изменение названия треда
if ($_GET['act']=='edit_topic') 
{ 
    //Обработка названия темы в целях безопасности
    $safe_topic=mysql_escape_string($_POST['name_topic']); 
    //SQL-запрос, который изменит название треда
    $sSQL="UPDATE TOPIC SET name='".$safe_topic."'  
WHERE id=".$_GET['numtopic']; 
    //Выполнение запроса 
    mysql_query($sSQL)or die(mysql_error()); 
    //Выбор кода раздела чтобы можно было перенаправить пользователя 
    //на список тем для этого раздела
    $sSQL="SELECT kodofrazdel FROM TOPIC  
WHERE id=".$_GET['numtopic'];
//Выполнение запроса 
    $data=mysql_query($sSQL); 
    //Получение результата - одна запись 
    $line=mysql_fetch_row($data); 
    //Вывод надписи и ссылки на список тем для тем этого раздела 
    echo "Название треда изменено<BR>"; 
    echo "<a href='index.php?show=topic&numrazdel=$line[0]'>"; 
    echo "Назад к списку тредов</a>"; 
} 
 
//Удаление тем и всех её сообщений 
if ($_GET['act']=='del_topic') 
{ 
    //Выбор кода раздела, чтобы можно было вернутся в него 
    $sSQL="SELECT kodofrazdel FROM TOPIC  
WHERE id=".$_GET['numtopic']; 
    $data=mysql_query($sSQL); 
    //Получаем результат - одна запись
    $line=mysql_fetch_row($data); 
    //Выпилить все сообщения для этой темы 
    $sSQL="DELETE FROM MESSAGE WHERE kodoftopic=".$_GET['numtopic']; 
    mysql_query($sSQL)or die(mysql_error()); 
    //Удаление самой темы
    $sSQL="DELETE FROM TOPIC WHERE id=".$_GET['numtopic']; 
    mysql_query($sSQL)or die(mysql_error()); 
   //Вывод надписи и ссылок на темы для текущего треда 
    echo "Тред выпилен"; 
    echo "<a href='index.php?show=topic&numrazdel=$line[0]'>Назад к списку тредов</a>"; 
} 
 
//Добавление нового сообщения 
if ($_GET['act']=='add_message') 
{ 
   //Обработка текста в целях безопасности 
   $safe_message=mysql_escape_string($_POST['message']); 
   //Запрос для добавления сообщения
$sSQL="INSERT INTO MESSAGE  SET kodoftopic=".$_GET['numtopic'].", 
text_message='".$safe_message."', name_man='".$_SESSION['name']."', 
date_answer='".date('Y-m-d')."'"; 
   //Выполнение запроса 
   mysql_query($sSQL)or die(mysql_error()); 
 
   //Теперь добавление информации об нике посетителя и дате 	 
   //размещенного сообщения для темы, которй принадлежит сообщение	 
   $sSQL="UPDATE TOPIC SET name_last_answer='".$_SESSION['name']."', 
date_last_answer='".date('Y-m-d')."' WHERE id=".$_GET['numtopic']; 
   mysql_query($sSQL)or die(mysql_error()); 
   //Вывод надписи и ссылки на список тредов для текущего раздела
   echo "Ответ принят<BR>"; 
   echo "<a href='index.php?show=message&numtopic= 
".$_GET['numtopic']."'>"; 
   echo "Назад к треду</a>"; 
} 
 
//Изменение поста 
if ($_GET['act']=='edit_message') 
{ 
    //!Обрабатывается название в целях безопасности 
    $safe_message=mysql_escape_string($_POST['message']); 
    //#	Тут меняем текст поста 
    $sSQL="UPDATE MESSAGE SET text_message='".$safe_message."' 
WHERE id=".$_GET['nummessage']; 
    mysql_query($sSQL)or die(mysql_error()); 
    //Выбор кода темы чтобы можно было перенаправить пользователяна 
    //список сообщений для этой темы
    $sSQL="SELECT kodoftopic FROM MESSAGE  
WHERE id=".$_GET['nummessage']; 
    $data=mysql_query($sSQL); 
    //Получаем результат - одна запись  
    $line=mysql_fetch_row($data); 
    //Вывод надписи и ссылок на список постов этого треда 
    echo "Название поста изменено<BR>"; 
    echo "<a href='index.php?show=message&numtopic=".$line[0]."'>"; 
    echo "Вернуться к треду</a>"; 
}
//Удаление поста
if ($_GET['act']=='del_message') 
{ 
    //Выбор кода треда, чтобы можно было вернутся к списку постов этого треда 
$sSQL="SELECT kodoftopic FROM MESSAGE". 
      " WHERE id=".$_GET['nummessage']; 
    $data=mysql_query($sSQL); 
    //Получение результата - одна запись 
    $line=mysql_fetch_row($data); 
    //Удаление выбранного сообщения 
    $sSQL="DELETE FROM MESSAGE WHERE id=".$_GET['nummessage']; 
    //Выполнение запроса
    mysql_query($sSQL)or die(mysql_error()); 
   //Вывод надписи и ссылки на список постов текущего треда 
    echo "Пост выпилен<BR>"; 
    echo "<a href='index.php?show=message&numtopic=".$line[0]."'>"; 
    echo "Вернутся назад к списку постов </a>"; 
} 
?>