<?php
$boardidx = $_REQUEST['boardidx'];
$username = $_REQUEST['username'];
$contents = $_REQUEST['contents'];

include_once 'dbconn.php';


$result = mysqli_query($connect_db, "INSERT INTO reply(boardidx, username, contents, reg_date  ) values( $boardidx, '$username', '$contents',now() )");
?>
{"result":"S","msg":"성공적으로 입력되었습니다."}