<meta charset='utf-8'>
<body id="body">
글쓰기 페이지<br>
<!--상대경로 : ./,../ 절대경로 : / -->
<form name="f1" action="write_ok.php">
작성자 : <input type="text" name="username" id="username"><br>
글제목 : <input type="text" name="boardtitle" id="boardtitle"><br>
글본문 : <textarea cols="50" rows="10" name="contents" id="contents"></textarea><br>
<input type="button" value="글쓰기" id="write"><br>
<input type="button" value="리스트보기" id="list">
</form>
<div style="width:100px;height:1000px;border:1px solid red;">
</div>
<script>
var write = document.getElementById("write");
console.dir(write);
console.dir(window);
window.addEventListener('scroll',function(e){
	console.log('scroll 발생');
});

write.addEventListener("click", function(e){
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