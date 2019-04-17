<?php
?>
<style>
/*html태그를 예쁘게.*/
.box{
width:100px;height:1000px;border:1px solid red;
}
</style>
<meta charset='utf-8'>
<body id="body">
회원가입<br>
<form name="f1" action="join_ok.php">
성명 : <input type="text" name="username" id="username"><br>
아이디 : <input type="text" name="userid" id="userid"><input type='button' name='duple' value='아이디 중복체크' id='duple'><br>
패스워드 : <input type="password" name="userpw" id="userpw"><br>
패스워드확인 : <input type="password" name="userpw2" id="userpw2"><br>
<input type='radio' name='gender' value='W'>여자
<input type='radio' name='gender' value='M'>남자
<br>
취미선택<br>
<input type='checkbox' name='game' value="Y">게임
<input type='checkbox' name='read' value="Y">독서
<input type='checkbox' name='movie' value="Y">영화보기
<input type='checkbox' name='bike' value="Y">자전거타기<br>
<input type="button" value="가입완료" id="write"><br>
<input type="button" value="리스트보기" id="list">
</form>
<script
  src="https://code.jquery.com/jquery-1.12.4.js"
  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
  crossorigin="anonymous"></script>

<script>
//동작을 제어.
var write = document.getElementById("write");
var ischeckduple = false;

$("#duple").click(function(){
	if(!$("#userid").val()){
		alert("아이디를 입력해주세요");
		$("#userid").focus();
		return false;
	}
	var senddata = {
		userid:$("#userid").val()
	}
	$.ajax({
		url:'duplecheckid.php',
		method:'post',
		dataType:'json',
		data:senddata,
		success:function(rs){
			if(rs.result == 'duple'){
				alert(rs.msg);
				return;
			}else{
				ischeckduple = true;
				alert(rs.msg);
				return;
			}
		},
		error:function(e){
			console.log(e);
			alert("서버 통신중 오류가 발생했습니다.");
		}
	});
});
write.addEventListener("click", function(e){
//4가지방식.
//id로 접근하기.
//classname으로 접근하기.
//tagname으로 접근하기.
//query
	
	var username = document.getElementById("username");
	var userid = document.getElementById("userid");
	var userpw = document.getElementById("userpw");
	var userpw2 = document.getElementById("userpw2");
	

	//f1.gender.value
	
	//유효성 검사. ! : not연산자. 
	if(!username.value){//string 글자. '':false,'제목':true
		alert('성명을 입력해주세요');
		username.focus();
		return false;
	}
	
	if(!userid.value){
		alert('아이디를 입력해주세요');
		userid.focus();
		return false;
	}
	
	if(!userpw.value){
		alert('패스워드를 입력해주세요');
		userpw.focus();
		return false;
	}
	if(!f1.gender.value){
		alert('성별을 선택해주세요');
		f1.gender.focus();
		return false;
	}
	// ==, !=
	if(userpw.value != userpw2.value){
		alert("비밀번호와 비밀번호 확인값이 일치하지 않습니다.");
		return false;
	}
	if(ischeckduple != true){
		alert('아이디 중복체크를 해주세요');
		return false;
	}
	f1.submit();
	
});
var list = document.getElementById("list");
list.addEventListener("click",function(){
	location.href = 'list.php';
});
</script>
</body>