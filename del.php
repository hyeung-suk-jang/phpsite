<?php
include_once './dbconn.php';
$idx = $_REQUEST['idx'];

$result = mysqli_query($connect_db, "DELETE FROM BOARD WHERE IDX=".$idx);
//select * from board where idx = 7

?>
<script>
	alert("정상 삭제되었습니다.");
    location.href='list.php';
</script>
