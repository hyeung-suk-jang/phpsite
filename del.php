<?php
include_once 'dbconn.php';
$idx = $_REQUEST['idx'];
$file = $_REQUEST['filename'];
$result = mysqli_query($connect_db, "DELETE FROM board WHERE idx=".$idx);

//딸린 댓글도 삭제
$result = mysqli_query($connect_db, "DELETE FROM reply WHERE boardidx=".$idx);

//파일도 삭제.
if($file){
unlink("./uploads/".$file);
}
?>

<script type="text/javascript">
    alert('삭제되었습니다.')
    location.href="index.php";
</script>
