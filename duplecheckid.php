<?php
//receiver : 데이터를 받아들임.
$userid = $_REQUEST['userid'];

include_once 'dbconn.php';

// ==, 
$row = mysqli_query($connect_db, "SELECT * FROM user WHERE userid = '$userid'  ");
$rowcount = 0;
$rowcount=mysqli_num_rows($row);

$arraytrans = mysqli_fetch_array($row);

if($rowcount >0){
?>
{"result":"duple","msg":"존재하는 아이디입니다."}
<?php
}else{
?>
{"result":"notduple","msg":"사용할 수 있는 아이디입니다."}
<?php
}
?>
