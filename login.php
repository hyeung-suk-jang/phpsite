<meta charset='utf-8'>
<body>
ID : <input type='text' name='id' id='userid'><br>
PW : <input type='password' name='pw' id='userpw'><br>
<input type='button' value="로그인" id='btn'>
<script
  src="https://code.jquery.com/jquery-1.12.4.js"
  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
  crossorigin="anonymous"></script>
<script>
$("#btn").click(function(){
	//자바스크립트 문법.
	var id = $("#userid").val();
	var pw = $("#userpw").val();
	
	//자바스크립트 문법. 객체리터럴 : {변수명:값,변수명:값}
	var senddata = {
		sendid:id,
		sendpw:pw
	}

	$.ajax(
	  {
			//sender : 데이터를 전송.
			url:'login_ok.php',
			method:'post',
			data:senddata,
			dataType:'json',
			//성공
			success:function(rs){//{"result":"S","msg":"성공적으로 조회되었습니다.","userid":"azanghs"}
				if(rs.result =='S'){
					alert('로그인 성공');
					location.href= 'index.php';
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
</script>
</body>