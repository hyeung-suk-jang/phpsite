<?php
session_start();

include_once './dbconn.php';
$idx = $_REQUEST['idx'];

$result = mysqli_query($connect_db, "SELECT * FROM BOARD WHERE IDX=".$idx);
//select * from board where idx = 7
$row = mysqli_fetch_array($result);
$userid = $row['userid'];

echo "글쓴이 : ".$row['username']."<br>";
echo "제목 : ".$row["title"]."<br>";
echo "내용 : ".$row["contents"]."<br>";
echo "작성일 : ".$row["reg_date"]."<br>";
?>
<?php
if($userid == $_SESSION['userid']){
?>
<input type="button" name="edit" value="수정" id="edit">
<input type="button" name="del" value="삭제" id="del">
<?php
}
?>
<input type="button" name="list" value="리스트로 돌아가기" id="list"><br><br>
<div id="replylist">
<?php
//댓글리스트 출력.
$replyres = mysqli_query($connect_db, "SELECT * FROM reply WHERE boardidx=".$idx);
while($row = mysqli_fetch_array($replyres)){
	echo $row["username"]." ".$row["contents"]." ".$row['reg_date'];	
	if($_SESSION['userid'] == $row["userid"]){
		echo "<input type='button' value='댓글수정' name='reply_edit' id='reply_edit'>";
		echo "<input type='button' value='댓글삭제' name='reply_del' id='reply_del'>";
	}
	echo "<br>";
}
?>
</div>
<br>
<form name="f2" action="reply.php">
댓글달기<br>
작성자<input type='text' name='username' id='username' size='10' value="<?=$_SESSION['username']?>"><br>
내용<input type="text" name="reply" id="reply" size="80">
<input type="button" value="댓글완료" id="replywrite">
</form>
<script
  src="https://code.jquery.com/jquery-1.12.4.js"
  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
  crossorigin="anonymous"></script>
<script>
	
	var del = document.getElementById("del");
	var edit = document.getElementById("edit");
	

	var list = document.getElementById("list");

	if(del){
	del.addEventListener('click',function(){
		//조건문.
		if(confirm("해당글을 삭제하시겠습니까?")){
			location.href='del.php?idx=<?=$idx;?>';
		}
	});
	}

	if(edit){
	edit.addEventListener("click",function(){

		location.href="edit.php?idx=<?=$idx?>";
	});
	}
	list.addEventListener("click",function(){
		location.href="list.php";
	});
	var reply = document.getElementById("replywrite");
	reply.addEventListener("click",function(){
		//유효성 체크.
		var replyval = document.getElementById("reply");
		var username = document.getElementById("username");
		//!:not연산자. 뒤에 있는 데이터를 boolean형 으로 변환한다음에 true를 -> false, false->true.
		//"kdaksdksdj;" : true, "":false.
		if(!username.value){//true -> 입력을 안했다.
			alert('작성자를 입력해주세요');
			username.focus();
			return;//밑에 있는 코드를 무시하고 바로 여기서 끝냄.
		}
	
		// = : 할당연산자, == : 동등비교연산자.
		if(replyval.value == ""){
			alert('댓글을 입력해주세요');
			replyval.focus();
			return;
		}
		



		//ajax.
		//jquery가 제공해주는 유용한 메소드들을 호출해서 사용하는 방식. 
		
		var senddata = {
			boardidx : <?=$idx;?>,
			username : username.value,
			contents : replyval.value
		};
		
		//ajax.비동기 통신기법.
		//$ = jQuery(함수)
		jQuery.ajax({
		  url: "addreply.php",
		  //POST, GET
		  method: "POST",
		  data: senddata,
			  //json : {"name":"value","name":"value"}, html : <ul><li></li><li></li></ul>
		  dataType: "json",
		  success:function(data){//data = {"result":"S","msg":"성공적으로 입력되었습니다.","user":"
		    console.log(data);
			if(data.result == "S"){
				alert(data.msg);
				//append.
				//var replylist = document.getElementById("replylist");

				$("#replylist").append(data.user+ " " + data.contents+ " "+data.reg_date+ "<br>"); 
			}else{
				alert("데이터가 정상처리 되지 않았습니다");
			}
		  },
		  error:function(data){
			console.log(data);
			alert("데이터 처리 중 오류가 발생했습니다.");
		  }
		});
		
			
		/*
		// 1. 요청 객체 생성 : 웹 표준 지원 브라우저일 경우
		var xmlHttp = new XMLHttpRequest();
		// 2. 요청에 대한 응답 처리 이벤트 리스너 등록
		xmlHttp.onreadystatechange = on_ReadyStateChange;
		// 3. 서버로 보낼 매개변수 생성
		var strParam = 'boardidx=<?=idx;?>&username='+username.value +'&contents='+replyval.value;
		// 4. 클라이언트와 서버 간의 연결 요청 준비(open() 메서드 이용)
		xmlHttp.open('GET','addreply.php?' + strParam, false);
		// 5. 실제 데이터 전송(send() 메서드 이용)
		xmlHttp.send(strParam);
		*/
	});

	// 6. 응답처리
	function on_ReadyStateChange() {
		/**
		 * 0 = 초기화 전
		 * 1 = 로딩 중
		 * 2 = 로딩 됨
		 * 3 = 대화 상태
		 * 4 = 데이터 전송완료
		 */
		// 4 = 데이터 전송완료
		if(xmlHttp.readyState == 4) {
			// 200 은 에러 없음= ( 404 = 페이지가 존재하지 않음 )
			if(xmlHttp.status == 200) {
				 console.log(xmlHttp.responseText );
				console.log('이 부분에서 데이터를 처리합니다.');
			} else {
				console.log('처리 중 에러가 발생했습니다.');
			}
		}
	}

</script>
