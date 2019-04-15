<?php
$boardidx = $_REQUEST['boardidx'];
$username = $_REQUEST['username'];
$contents = $_REQUEST['contents'];

include_once 'dbconn.php';


$result = mysqli_query($connect_db, "INSERT INTO reply(boardidx, username, contents, reg_date  ) values( $boardidx, '$username', '$contents',now() 
)");

$row = mysqli_query($connect_db, "SELECT * FROM REPLY WHERE BOARDIDX = $boardidx ORDER BY REG_DATE DESC limit 1");
$arraytrans = mysqli_fetch_array($row);

//echo "{'result':'S','msg':'성공적으로 입력되었습니다.','user':}";
?>
{"result":"S","msg":"성공적으로 입력되었습니다.","user":"<?=$arraytrans['username'];?>","contents":"<?=$arraytrans['contents'];?>", "reg_date":"<?=$arraytrans['reg_date'];?>"}