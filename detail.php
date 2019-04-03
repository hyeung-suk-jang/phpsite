<?php
include_once './dbconn.php';
$idx = $_REQUEST['idx'];

$result = mysqli_query($connect_db, "SELECT * FROM BOARD WHERE IDX=".$idx);
while($row = mysqli_fetch_array($result)){
	echo "<a href='detail.php?idx=".$row['idx']."'>번호: ".$row['idx']."/ 이름: ".$row['username']."/ 제목: ".$row['title']
	."/ 본문내용: ".$row['contents']."/ 작성일: ".$row['reg_date']."</a><br>";
}
?>
