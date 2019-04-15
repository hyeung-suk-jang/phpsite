<?php
//세션기능을 활성화 시키겠다.
session_start();
$issession = "notlogin";

if(!empty($_SESSION['userid'])){
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
<input type="button" value="로그인 하기" id="login">
<div class="abc">
</div>
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
	if(issession =='notlogin'){
		alert('로그인 후 이용가능합니다.');
	}else{
		location.href = 'list.php';
	}
//	location.href = 'list.php';
}

var login = document.getElementById("login");
login.addEventListener("click",function(){
	location.href= 'login.php';
});
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