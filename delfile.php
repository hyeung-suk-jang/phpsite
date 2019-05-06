<?php
include_once 'dbconn.php';
$idx = $_REQUEST['idx'];
$file = $_REQUEST['filename'];

$result = mysqli_query($connect_db, "UPDATE board SET UPLOADFILE='' WHERE idx=".$idx);

//파일삭제.
if($file){
unlink("./uploads/".$file);
}
?>
{"result":"S","msg":"성공적으로 삭제되었습니다."}
