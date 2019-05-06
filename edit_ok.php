<?php
$username = $_REQUEST['username'];
$title = $_REQUEST['boardtitle'];
$contents = $_REQUEST['contents'];
$idx =  $_REQUEST['idx'];

//파일이 새로 넘어왔느냐.
//file
$error = $_FILES['myfile']['error'];
$filename = $_FILES['myfile']['name'];//file name(실제 파일의 이름)
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


include_once 'dbconn.php';

echo $username ."<br>";
echo $title ."<br>";
echo $contents ."<br>";


//select , insert, update, delete. select * from board, insert into board(칼럼명) values('데이터'
//update board set name='홍길동' , age = 30 where idx = 2
//delete from board where name = '홍길동'
//echo  "UPDATE board SET username= '$username', title='$title', contents='$contents', edit_date = now() where idx= $idx)";
//exit;
if($filename){
	//기존파일삭제.
	$result = mysqli_query($connect_db, "SELECT * FROM BOARD WHERE IDX=".$idx);
	$row = mysqli_fetch_array($result);
	$prevfilename = $row['uploadfile'];
	if($prevfilename){
		unlink("./uploads/".$prevfilename);
	}

	$result = move_uploaded_file( $_FILES['myfile']['tmp_name'], "$uploads_dir/$filename");
	$result = mysqli_query($connect_db, "UPDATE board SET username= '$username', title='$title', contents='$contents', edit_date = now(),uploadfile='$filename' where idx= $idx");
}else{
	$result = mysqli_query($connect_db, "UPDATE board SET username= '$username', title='$title', contents='$contents', edit_date = now() where idx= $idx");
}


?>
<script>
alert('성공적으로 변경되었습니다.');
location.href= 'edit.php?idx=<?=$idx;?>';
</script>