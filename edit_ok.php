<?php
$username = $_REQUEST['username'];
$title = $_REQUEST['boardtitle'];
$contents = $_REQUEST['contents'];
$idx =  $_REQUEST['idx'];
include_once 'dbconn.php';

echo $username ."<br>";
echo $title ."<br>";
echo $contents ."<br>";


//select , insert, update, delete. select * from board, insert into board(칼럼명) values('데이터'
//update board set name='홍길동' , age = 30 where idx = 2
//delete from board where name = '홍길동'
//echo  "UPDATE board SET username= '$username', title='$title', contents='$contents', edit_date = now() where idx= $idx)";
//exit;

$result = mysqli_query($connect_db, "UPDATE board SET username= '$username', title='$title', contents='$contents', edit_date = now() where idx= $idx");


?>
<script>
alert('성공적으로 변경되었습니다.');
location.href= 'edit.php?idx=<?=$idx;?>';
</script>