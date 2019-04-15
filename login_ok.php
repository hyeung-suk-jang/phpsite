<?php
session_start();
$sendid = $_REQUEST['sendid'];
$sendpw = $_REQUEST['sendpw'];

include_once 'dbconn.php';


$row = mysqli_query($connect_db, "SELECT * FROM user WHERE userid = '$sendid' and userpw='$sendpw' ");
$rowcount = 0;
$rowcount=mysqli_num_rows($row);

$arraytrans = mysqli_fetch_array($row);

if($rowcount >0){
	$_SESSION['userid'] = $arraytrans['userid'];
?>
{"result":"S","msg":"성공적으로 조회되었습니다.","userid":"<?=$arraytrans['userid'];?>"}
<?php
}else{
?>
{"result":"F","msg":"조회 실패"}
<?php
}
?>
