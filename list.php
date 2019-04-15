<?php
include_once './dbconn.php';
//php 문법에서의 변수.
$abc = 10;
//4대쿼리 : select, delete, insert, update.
//select * from board;
//delete from board where title = '안녕하세요.';
//delete from board where idx = 7;
//insert into board(username, title, reg_date, edit_date, contents) values('실제데이터','데이터',now(),now(),'데이터');
//update board set title = '방가방가' where idx = 11;

//select * from board => * 모든 컬럼(select :데이터를 가져와라. * : 모든컬럼, from board라는 테이블에서)
$result = mysqli_query($connect_db, "SELECT * FROM BOARD");
//php 내장된 함수. db에서 가져온 데이터를 php 문법상의 배열로 만들어준다.
//변수 vs 배열. 변수 : 하나의 값을 저장. 배열 : 변수가 여러개 묶여있는것이 배열.
//while : 
?>
<style>
table{
border-collapse:collapse;
}
.head{
	border:1px solid black;
	background:#eee;
}
.tbody:hover{
	background:#fabcff;
}
.tbody td:last-child, .head td:last-child{
	padding-left:20px;
}
</style>
<table >
<tr class="head">
	<td>번호</td>
	<td>이름</td>
	<td>제목</td>
	<td>본문</td>
	<td>작성일</td>
	<td>수정일</td>
</tr>

<?php
//프로그래밍 언어는 : 변수, 함수, 연산자, 제어문, 반복문, 조건문. 
//while : 반복문. while(조건식){} 조건식 : $row 변수에 값이 들어갔느냐. 안들어갔느냐.
//mysqli_fetch_array:한줄의 데이터를 가져오는데 배열로 가져온다.배열 = 변수들이 여러개 합쳐진 패키지. 
while($row = mysqli_fetch_array($result)){
	echo "<tr class='tbody' data-row=".$row['idx']."><td>".$row['idx']."</td><td>".$row['username']."</td><td> ".$row['title']
	."</td><td>".$row['contents']."</td><td>".$row['reg_date']."</td><td>".$row['edit_date']."</td></tr>";
}
?>
</table>
<div>
	<span>여기는 div 내부의 span</span>
</div>
<span>단독으로 존재하는 span</span>

<input type="button" name="write" value="글쓰기" onclick="location.href='write.php'">
<script>
//javascript => tag에 접근하는 방법.
//document.getElementById("id")
//document.getElementsByClassName("classname")
//document.getElementsByTagName("tr")
//document.querySelector("tr .tbody #mybox");//복합선택자가 가능.

var span = document.querySelectorAll("span");//최초 만족하는 span
for(var i = 0; i<span.length;i++)
	span[i].style.backgroundColor = 'red';

var tr = document.getElementsByClassName("tbody");
//for문.while : 반복문.
//tr.length:몇개의 변수들을 가지고 있느냐.
for(var i = 0; i<tr.length;i++){
	//tr[i].addEventListener
	tr[i].addEventListener("click",trclick);
}
function trclick(e){
	//this : 이벤트를 발생시킨 주체.(클릭된 tr 태그)
	datarow = this.getAttribute("data-row");
	//문자결합 + 
	location.href = "detail.php?idx="+datarow;//url?idx=8
	//<a href='detail.php?idx=".$row['idx']."'>
}
</script>
