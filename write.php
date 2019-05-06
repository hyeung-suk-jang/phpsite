<?php
session_start();
?>
<style>
/*html태그를 예쁘게.*/
.box{
width:100px;height:1000px;border:1px solid red;
}
</style>
<meta charset='utf-8'>
<body id="body">
글쓰기 페이지<br>
<!--상대경로 : ./,../ 절대경로 : / -->
<!--html은 구조를 설계.-->
<form name="f1" action="write_ok.php" method="post" enctype="multipart/form-data">
작성자 : <input type="text" name="username" id="username" value="<?=$_SESSION['username'];?>"><br>
글제목 : <input type="text" name="boardtitle" id="boardtitle"><br>
글본문 : <textarea cols="50" rows="10" name="contents" id="contents"></textarea><br>
<input type='radio' name='gender'>여자
<input type='radio' name='gender'>남자
<br>
취미선택<br>
<input type='checkbox' >농구
<input type='checkbox' >축구
<br>
파일선택
<input type='file' name="myfile"> 
</form>
<input type="button" value="글쓰기완료" id="write"><br>
<input type="button" value="리스트보기" id="list">
<div class='box'>
</div>
<script>
//동작을 제어.
var write = document.getElementById("write");
console.dir(write);
console.dir(window);
window.addEventListener('scroll',function(e){
	console.log('scroll 발생');
});

write.addEventListener("click", function(e){
//4가지방식.
//id로 접근하기.
//classname으로 접근하기.
//tagname으로 접근하기.
//query
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
var list = document.getElementById("list");
list.addEventListener("click",function(){
	location.href = 'list.php';
});
var body = document.getElementById("body");
body.addEventListener("click",function(e){
	console.log('body click');
});
</script>
</body>