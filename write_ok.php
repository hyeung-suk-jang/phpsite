<?php
$username = $_REQUEST['username'];
$title = $_REQUEST['boardtitle'];
$contents = $_REQUEST['contents'];

include_once '/board/dbconn.php';


//select , insert, update, delete. select * from board, insert into board(칼럼명) values('데이터'
//update board set name='홍길동' , age = 30 where idx = 2
//delete from board where name = '홍길동'
$result = mysqli_query($connect_db, "INSERT INTO board(username, title, contents, reg_date  ) values('$username', '$title','$contents',now() )");
echo $result;

//$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);



echo $username.$title.$contents;

?>
<script>
alert('성공적으로 입력되었습니다.');
location.href= 'write.php';
</script>