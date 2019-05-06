<?php
include_once './dbconn.php';
$idx = $_REQUEST['idx'];

$result = mysqli_query($connect_db, "SELECT * FROM BOARD WHERE IDX=".$idx);
//select * from board where idx = 7
$row = mysqli_fetch_array($result);
$filename = $row['uploadfile'];
?>

<form name="f1" action="edit_ok.php" method='post' enctype="multipart/form-data">
<input type="hidden" name="idx" value="<?=$idx?>">
작성자 : <input type="text" name="username" id="username" value="<?=$row['username']?>"><br>
글제목 : <input type="text" name="boardtitle" id="boardtitle" value="<?=$row['title']?>"><br>
글본문 : <textarea cols="50" rows="10" name="contents" id="contents" ><?=$row['contents']?></textarea><br>
파일 : <input type='file' name="myfile"><br>
<?php
if($row['uploadfile'] != ""){
?>
<?echo "첨부파일삭제 : <a href='#' id='filedelete'>".$row['uploadfile']."삭제</a><br>";?>
<?}?>
<input type="button" value="수정완료" id="write"><br>
<input type="button" value="리스트보기" id="list">
</form>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
	var write = document.getElementById("write");
	var list = document.getElementById("list");

	write.addEventListener('click',function(){
		var title = document.getElementById("boardtitle");
        var username = document.getElementById("username");
        var text = document.getElementById("contents");
        
        //유효성 검사. ! : not연산자. 
        if(!title.value){//string 글자. '':false,'제목':true
            alert('제목을 입력해주세요');
            title.focus();
            return false;
        }
        
        if(!username.value){
            alert('작성자를 입력해주세요');
            username.focus();
            return false;
        }
        
        if(!text.value){
            alert('글본문을 입력해주세요');
            text.focus();
            return false;
        }

        f1.submit();
	});
	list.addEventListener("click",function(){
		location.href="list.php";
	});
	var delfile = document.getElementById("filedelete");
	delfile.addEventListener("click",function(){
		var senddata = {
			idx:<?=$idx?>,
			filename:'<?=$filename?>'
		}
		$.ajax({
		  url: "delfile.php",
		  //POST, GET
		  method: "POST",
		  data: senddata,
		  dataType: "json",
		  success:function(data){//data = {"result":"S","msg":"성공적으로 입력되었습니다.","user":"
		    console.log(data);
			if(data.result == "S"){
				alert(data.msg);
			}else{
				alert("데이터가 정상처리 되지 않았습니다");
			}
		  },
		  error:function(data){
			console.log(data);
			alert("데이터 처리 중 오류가 발생했습니다.");
		  }
		});
	});
</script>
