<?php
include_once './dbconn.php';

$result = mysqli_query($connect_db, "SELECT * FROM BOARD");
while($row = mysqli_fetch_array($result)){
	echo "<a href='detail.php?idx=".$row['idx']."'>번호: ".$row['idx']."/ 이름: ".$row['username']."/ 제목: ".$row['title']
	."/ 본문내용: ".$row['contents']."/ 작성일: ".$row['reg_date']."</a><br>";
}
?>
<input type="button" name="write" value="글쓰기" onclick="location.href='write.php'">

