<!DOCTYPE html>
<?php
 session_start();
 $issession = "notlogin";
 $search = "";

 if(isset($_REQUEST['search'])){
	$search = $_REQUEST['search'];
 }
 


if(!empty($_SESSION['userid'])){
     $issession = "login";

}

?>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>글리스트페이지</title>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    </head>

    <body>
        <div class="wrap">
            <div class="inner">
                <div class="gnb">
                <?php
                	if( $issession == "login"){//로그인 된 상태.
                ?>
                	<a href="logout.php">로그아웃</a>
                <?php
                }else{?>
					<a href="login.php">로그인</a>
                    <a href="join.php">회원가입</a>
                <?}?>

                </div>
                <h3>List</h3>
                <div class="list_wrap">
                    <table>
                        <colgroup>
                            <col width="10%">
                            <col width="15%">
                            <col width="30%">
							<col width="10%">
							<col width="10%">
                            <col width="*">
                        </colgroup>
                        <thead>
                            <tr>
                                <th> 번호</th>
                                <th> 글쓴이</th>
                                <th> 제목</th>
								<th> 파일</th>
								<th> 조회수</th>
                                <th> 작성일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                include_once "dbconn.php";
                                $sql = "";

$page = !empty($_REQUEST['page']) ? $_REQUEST['page']:1;//현재 페이지번호.
// 페이지 설정
$page_set = 3; // 한페이지 줄수
$block_set = 5; // 한페이지 블럭수

$limit_idx = ($page - 1) * $page_set; // limit시작위치
$searchtype="";			
                                if($search){
									if(isset($_REQUEST['search_type'])){
										$searchtype = $_REQUEST['search_type'];
									}
                                	if($searchtype == "title+contents"){
                                		$sql = "SELECT * FROM board where title like '%$search%' or contents like '%$search%'";
                                	}else{
                                		$sql = "SELECT * FROM board where $searchtype like '%$search%'";
                                	}

                                	//echo $sql;

                                }else{
                                	$sql = "select * from board";
                                }
                                //전체글수 구하기 쿼리
                                //$sqltotal = "select * from board";
                                $resulttotal = mysqli_query($connect_db , $sql);
                                $total = mysqli_num_rows($resulttotal);//전체글수.

                                $sql = $sql ." LIMIT $limit_idx, $page_set";
                                echo $sql;
                                //exit;
                                $result = mysqli_query($connect_db , $sql);


                                //$_REQUEST : $_GET + $_POST
                                // 1항 ? 2항 : 3항;


								//echo $sql;
$total_page = ceil ($total / $page_set); // 총페이지수(올림함수)
$total_block = ceil ($total_page / $block_set); // 총블럭수(올림함수)
$block = ceil ($page / $block_set); // 현재블럭(올림함수)



								// 페이지번호 & 블럭 설정
$first_page = (($block - 1) * $block_set) + 1; // 첫번째 페이지번호
$last_page = min ($total_page, $block * $block_set); // 마지막 페이지번호
 $prev_page = $page - 1; // 이전페이지
$next_page = $page + 1; // 다음페이지

$prev_block = $block - 1; // 이전블럭
$next_block = $block + 1; // 다음블럭

// 이전블럭을 블럭의 마지막으로 하려면...
$prev_block_page = $prev_block * $block_set; // 이전블럭 페이지번호
// 이전블럭을 블럭의 첫페이지로 하려면...
//$prev_block_page = $prev_block * $block_set - ($block_set - 1);
$next_block_page = $next_block * $block_set - ($block_set - 1); // 다음블럭 페이지번호

/*
echo "현재 페이지는".$page."<br/>";
echo "현재 블록은".$nowBlock."<br/>";

echo "현재 블록의 시작 페이지는".$s_page."<br/>";
echo "현재 블록의 끝 페이지는".$e_page."<br/>";

echo "총 페이지는".$pageNum."<br/>";
echo "총 블록은".$blockNum."<br/>";
*/



                                while($row= mysqli_fetch_array($result)){
                                	$sql = "select count(*) as cnt from reply where boardidx = ".$row['idx'];
                                	$rs = mysqli_query($connect_db, $sql);
                                	$rs = mysqli_fetch_array($rs);
								
								$clipimage = "";
								if($row['uploadfile']!="" ){
									$clipimage = "<img src='./image/clip2.png'>";
								}

                                echo  "<tr><td class='board_idx'></td><td>".$row['username']."</td><td><a class='title' href='detail.php?idx=".$row['idx']."'><span>".$row['title']."[".$rs[0]."]</span></a></td><td>$clipimage</td><td>".$row['viewcount']."</td><td>".$row['edit_date']."</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="btn_wrap">
                	<div class='search'>
                	<form name="f1" method="post">
                	<input type='button' value='전체보기' id="showall">
                	<?php
                	// 페이징 화면
echo ($prev_page > 0) ? "<a href='?page=$prev_page&search=$search&search_type=$searchtype'>[prev]</a> " : "[prev] ";
echo ($prev_block > 0) ? "<a href='?page=$prev_block_page&search=$search&search_type=$searchtype'>...</a> " : "... ";

for ($i=$first_page; $i<=$last_page; $i++) {
echo ($i != $page) ? "<a href='?page=$i&search=$search&search_type=$searchtype'>$i</a> " : "<b>$i</b> ";
}

echo ($next_block <= $total_block) ? "<a href='?page=$next_block_page&search=$search&search_type=$searchtype'>...</a> " : "... ";
echo ($next_page <= $total_page) ? "<a href='?page=$next_page&search=$search&search_type=$searchtype'>[next]</a>" : "[next]";
                	?>
					<select id="search_type" name="search_type">
                	<option value = 'title'>제목</option>
                	<option value='contents'>글내용</option>
                	<option value='user'>작성자</option>
                	<option value='title+contents'>제목+글내용</option>
                	</select>
                	<input type='text' name='search' id='search'><input type='button' value='검색' id="btn_search">
                	</form>
                	</div>
                    <?php
                    if($issession == "login"){
                    ?>
                        <a href="write.php"><span>글쓰기</span></a>
                    <?php
                    }
                    ?>

                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                	$("#showall").click(function(){
                		location.href = 'index.php';
                	});

                    var i = 1;
                    $('.board_idx').each(function(){
                        $(this).text(i);
                        i= i+1;
                    }).ready()

					$("#btn_search").click(function(){
						if(!$("#search").val()){
							alert("검색어를 입력해주세요");
							$("#search").focus();
							return false;
						}
						alert($("#search_type").val());
						//전송방법. 2가지.
						f1.submit();
					});
                });

            </script>

        </div>

    </body>
</html>
