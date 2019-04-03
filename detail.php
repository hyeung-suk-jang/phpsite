<?php
include_once './dbconn.php';
$idx = $_REQUEST['idx'];

$result = mysqli_query($connect_db, "SELECT * FROM BOARD WHERE IDX=".$idx);
//select * from board where idx = 7
$row = mysqli_fetch_array($result);

echo "글쓴이 : ".$row['username']."<br>";
echo "제목 : ".$row["title"]."<br>";
echo "내용 : ".$row["contents"]."<br>";
echo "작성일 : ".$row["reg_date"]."<br>";
?>
<input type="button" name="edit" value="수정" id="edit">
<input type="button" name="del" value="삭제" id="del">
<script>
	var del = document.getElementById("del");
	var edit = document.getElementById("edit");

	del.addEventListener('click',function(){
		if(confirm("해당글을 삭제하시겠습니까?")){
			location.href='del.php?idx=<?=$idx;?>';
		}
	});
	edit.addEventListener("click",function(){
		location.href="edit.php?idx=<?=$idx?>";
	});
</script>
