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
	var id = $("#userid").val();
	var pw = $("#userpw").val();
	var senddata = {
		sendid:id,
		sendpw:pw
	}
	$.ajax(
	  {
			url:'login_ok.php',
			method:'post',
			data:senddata,
			dataType:'json',
			//성공
			success:function(rs){
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