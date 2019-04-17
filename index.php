<?php
//세션기능을 활성화 시키겠다.
session_start();
$issession = "notlogin";

//php문법에서 : $_SESSION[''] : 웹서버에 저장된 세션변수. , $_REQUEST : 사용자가 전송한 데이터., $_SERVER : 웹서버가 실행시점부터 갖고 있는 변수값.

if(!empty($_SESSION['userid'])){//안비어있습니까?=$_SESSION['userid']값이 존재합니까?
	$issession = "login";
}
?>
<meta charset='utf-8'>
<style>
.abc{
	width:100px;
	height:80px;
	border:1px solid red;
	background:#aaa;
}
</style>
<body>
게시판만들기<br>
<input type="button" value="리스트보기" id="list">
<input type="button" value="글쓰기" id="write" class="abc">
<?php
if($issession == "login"){
?>
<input type="button" value="로그아웃 하기" id="logout">
<?php
}else{
?>
<input type="button" value="로그인 하기" id="login">
<input type="button" value="회원 가입" id ="join">
<?php
}
?>
<div class="abc">
</div>
<script
  src="https://code.jquery.com/jquery-1.12.4.js"
  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
  crossorigin="anonymous"></script>
<script>
//변수선언 = 
//document.getElementsByClassName
//document.getElementsByTagName
//변수, 함수, 연산자, 제어문, 조건문, html태그 다루기.
//변수의 종류는 크게 2가지. 자신의 변수영역에 데이터를 넣는 구조.
//var a = 10;
//var b = "글자";
//var c = true; // false;
//var d;
//var e = null;

//이미 메모리에 할당된 데이터 영역을 참조하는 구조.
var write = document.getElementById("write");
//태그에는 onclick이라는 자바스크립트 이벤트 처리함수를 적용할 수 있다.

//function(){} //함(상자함)수.
write.onclick = function(){
	location.href = 'write.php';
}

var list = document.getElementById("list");
list.onclick = function(){
	//로그인여부.
	var issession = '<?=$issession?>';
	//alert(issession);
	//조건문:if(조건문)

	if(issession == 'notlogin'){
		alert('로그인 후 이용가능합니다.');
	}else{
		location.href = 'list.php';
	}
//	location.href = 'list.php';
}

<?php
if($issession == "login"){
?>

var logout = document.getElementById("logout");
logout.addEventListener("click",function(){
	$.ajax(
	  {
			//sender : 데이터를 전송.
			url:'logout.php',
			method:'post',
			dataType:'json',
			//성공
			success:function(rs){
				if(rs.result =='S'){
					alert('로그아웃 성공');
					location.reload();
				}else{
					alert(rs.msg);
				}
			},
			error:function(result){
				console.log(result);
				alert("에러");
			}
		}	
	);		
});

<?php
}else{
?>
var login = document.getElementById("login");
login.addEventListener("click",function(){
	location.href= 'login.php';
});
var join = document.getElementById("join");
join.addEventListener("click",function(){
	location.href = 'join.php';
});
<?php
}	
?>

//함수를 정의해 놓은 곳.
function hamsu(abc){
	abc = abc+2;
	return abc;
}
//함수를 호출하는 방식.
var sum = hamsu(10);
console.log(sum);

</script>
</body>