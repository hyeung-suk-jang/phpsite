<?php
//php 문법.
$username = $_REQUEST['username'];
$userid = $_REQUEST['userid'];
$userpw = $_REQUEST['userpw'];
$gender = $_REQUEST['gender'];
$game = $_REQUEST['game'];
$movie = $_REQUEST['movie'];
$bike = $_REQUEST['bike'];
$read = $_REQUEST['read'];

include_once 'dbconn.php';

//select , insert, update, delete. select * from board, insert into board(칼럼명) values('데이터'
//update board set name='홍길동' , age = 30 where idx = 2
//delete from board where name = '홍길동'
$result = mysqli_query($connect_db, "INSERT INTO user(username, userid, userpw,gender,game, movie,bike,reading ,reg_date  ) values('$username', '$userid','$userpw','$gender','$game','$movie','$bike','$read',now() )");
echo $result;

//$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);


?>
<script>
alert('회원가입이 완료되었습니다.');
location.href= 'index.php';
</script>