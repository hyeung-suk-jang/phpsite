<?php
//db 서버에 저장.
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_password = '';
$mysql_db = 'vimeodb';

//$db = new PDO('mysql:host=localhost;dbname=vimeodb;charset=utf8mb4', $mysql_user, $mysql_password);
//$result = $db -> exec("INSERT INTO board(username, title, reg_date, contents ) VAULES('$username', '$title','$contents',now())");
//echo $result;

$connect_db = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db) or die("<meta http-equiv='content-type' content='text/html; charset=utf-8'><script language='JavaScript'> alert('DB 접속 오류'); </script>");

//db서버에 전송하는 명령어.
mysqli_query($connect_db,"SET NAMES 'utf8'");
?>
