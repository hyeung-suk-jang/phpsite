<?php
session_start();
//php 문법.
$username = $_REQUEST['username'];
$title = $_REQUEST['boardtitle'];
$contents = $_REQUEST['contents'];
$userid = $_SESSION['userid'];

include_once 'dbconn.php';

//file
$error = $_FILES['myfile']['error'];
$filename = $_FILES['myfile']['name'];//file name(실제 파일의 이름)
//$filename = basename($_FILES["myfile"]["name"]);
$ext = array_pop(explode('.', $filename));

// 오류 확인
if( $error != UPLOAD_ERR_OK ) {//에러가 났다면.
	switch( $error ) {
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
			echo "파일이 너무 큽니다. ($error)";
			break;
		case UPLOAD_ERR_NO_FILE:
			echo "파일이 첨부되지 않았습니다. ($error)";
			break;
		default:
			echo "파일이 제대로 업로드되지 않았습니다. ($error)";
	}
	exit;
}

$uploads_dir = './uploads';

//select , insert, update, delete. select * from board, insert into board(칼럼명) values('데이터'
//update board set name='홍길동' , age = 30 where idx = 2
//delete from board where name = '홍길동'
if($filename){
	$result = move_uploaded_file( $_FILES['myfile']['tmp_name'], "$uploads_dir/$filename");
	$result = mysqli_query($connect_db, "INSERT INTO board(userid,username, title,uploadfile, contents, reg_date,edit_date  ) values('$userid','$username', '$title','$filename','$contents',now(),now() )");
}else{
	$result = mysqli_query($connect_db, "INSERT INTO board(userid,username, title, contents, reg_date,edit_date  ) values('$userid','$username', '$title','$contents',now(),now() )");
}
echo $result;

//$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);


?>
<script>
alert('성공적으로 입력되었습니다.');
location.href= 'write.php';
</script>