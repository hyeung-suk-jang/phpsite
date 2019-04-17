<?php
session_start();
//receiver : 데이터를 받아들임.
$sendid = $_REQUEST['sendid'];
$sendpw = $_REQUEST['sendpw'];

include_once 'dbconn.php';

// ==, 
$sql = "select * from user where userid = '$sendid'";
$row = mysqli_query($connect_db,$sql);
$rowcount=mysqli_num_rows($row);
if($rowcount>0){
	$sql = "SELECT * FROM user WHERE userid = '$sendid' and userpw = '$sendpw' ";
	$row = mysqli_query($connect_db,$sql);
	$rowcount=mysqli_num_rows($row);
	if($rowcount>0){//정상 로그인 유저.
		$arraytrans = mysqli_fetch_array($row);
		$_SESSION['userid'] = $arraytrans['userid'];
		$_SESSION['username'] = $arraytrans['username'];
		$userid = $arraytrans["userid"];
		echo '{"result":"S","msg":"성공적으로 조회되었습니다.","userid":"$userid"}';
	}else{//아이디 맞았지만, 패스워드는 틀린 유저.
		echo '{"result":"F","msg":"패스워드가 틀렸습니다."}';
	}
}else{
	echo '{"result":"F","msg":"아이디가 틀렸습니다."}';
}

?>
