<?php
include_once './dbconn.php';

$result = mysqli_query($connect_db, "SELECT * FROM BOARD");
?>

<table>
<tr>
	<td>번호</td>
	<td>이름</td>
	<td>제목</td>
	<td>내용</td>
	<td>작성일</td>
</tr>
<?php
while($row = mysqli_fetch_array($result)){
?>
<tr>
	<td><?echo $row['idx']?></td>
	<td><?echo $row['username']?></td>
	<td><?echo $row['title']?></td>
	<td><?echo $row['contents']?></td>
	<td><?echo $row['reg_date']?></td>
</tr>
<?php
}	
?>
</table>
<!--
while($row = mysqli_fetch_array($result)){
	echo "번호: ".$row['idx']."/ 이름: ".$row['username']."/ 제목: ".$row['title']
	."/ 본문내용: ".$row['contents']."/ 작성일: ".$row['reg_date']."<br>";
}
-->