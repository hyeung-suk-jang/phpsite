<?php
session_start();
//php 문법.
$username = $_REQUEST['username'];
$title = $_REQUEST['boardtitle'];
$contents = $_REQUEST['contents'];
$userid = $_SESSION['userid'];
$idx = $_REQUEST['idx'];
$type = $_REQUEST['type'];

if(isset($_REQUEST['mail'])){
	//메일발송.
	$to = "azanghs@naver.com";
   $subject = $title;
   $contents = $contents;
   $headers = "From: azanghs@gmail.com\r\n";

   mail($to, $subject, $contents, $headers);
   exit;
}

if(isset($_REQUEST['sms'])){
	//sms 발송
	$sms = new sms();
	$sms->set("TR_ID","smszanghs");
	$sms->set("TR_KEY","JMCP3*IRG1");
	$sms->set("TR_TXTMSG","명희영님 안녕하세요. ");
	$sms->set("TR_TO","010-8004-1292","명희영","");
	$sms->set("TR_FROM","010-9963-3292");
	$sms->set("TR_DATE","0");	// or 예약  $sms->set("TR_DATE","2011-06-20 12:12:12");
	$sms->set("TR_COMMENT","인증번호");
	$recv = $sms->send();
}

include_once 'dbconn.php';

//file

$error = $_FILES['myfile']['error'];
$filename = $_FILES['myfile']['name'];//file name(실제 파일의 이름)
//$filename = basename($_FILES["myfile"]["name"]);

if($filename){
	// 오류 확인
	if( $error != UPLOAD_ERR_OK ) {//에러가 났다면.
		switch( $error ) {
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				echo "파일이 너무 큽니다. ($error)";
				break;
			case UPLOAD_ERR_NO_FILE:
				echo "파일이 첨부되지 않았습니다. ($error)";
				break;
			default:
				echo "파일이 제대로 업로드되지 않았습니다. ($error)";
		}
		exit;
	}
}

$uploads_dir = './uploads';

//select , insert, update, delete. select * from board, insert into board(칼럼명) values('데이터'
//update board set name='홍길동' , age = 30 where idx = 2
//delete from board where name = '홍길동'
if($filename){
	$result = move_uploaded_file( $_FILES['myfile']['tmp_name'], "$uploads_dir/$filename");
	if($type != ""){
		//원글에 대한 정보를 가져온다. 원글의 답변글이므로  depth는 +1 되어야 한다.
		//level에 대해서, 같은 depth의 댓글중 마지막 댓글의 level +1이 되어야 한다.
		// 상위 댓글들이 있다면 상위 댓글들의 level을 +1씩 높여야 한다.
		$sql = "select * from board where idx= $idx";
		$rs = mysqli_query($connect_db, $sql);
		$rs = mysqli_fetch_array($rs);
		$depth  =$rs['boarddepth'] +1;
		
		$sql = "select max(boardlevel) as maxlevel from board where boardgroup =".$idx." and boarddepth = ".$rs['boarddepth'];
		
		$rs = mysqli_query($connect_db, $sql);
		$rs = mysqli_fetch_array($rs);
		$maxlevel = $rs['maxlevel']+1;
		$sql = "update board set boardlevel = boardlevel+1 where boardgroup = ".$idx." and boardlevel > ".$rs['boardlevel'];
		mysql_query($connect_db,$sql);

	}else{
		$result = mysqli_query($connect_db, "INSERT INTO board(userid,username, title,uploadfile, contents, reg_date,edit_date  ) values('$userid','$username', '$title','$filename','$contents',now(),now() )");
		$sql = "select max(idx) as max from board ";
		$rs = mysqli_query($connect_db, $sql);
		$rs = mysqli_fetch_array($rs);
		$result = mysqli_query($connect_db, "UPDATE board set boardgroup = idx where idx =".$rs['max']);
	}
}else{
	$result = mysqli_query($connect_db, "INSERT INTO board(userid,username, title, contents, reg_date,edit_date  ) values('$userid','$username', '$title','$contents',now(),now() )");
	$sql = "select max(idx) as max from board ";
	$rs = mysqli_query($connect_db, $sql);
	$rs = mysqli_fetch_array($rs);
	$result = mysqli_query($connect_db, "UPDATE board set boardgroup = idx where idx =".$rs['max']);
}
echo $result;

//$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);


class sms {
	var $server_url;
	var $cut;
	var $status;
	var $params;
	var $encoding;

	/**
	 *
	 *
	 * @param
	 * @return
	 */
	function sms($encoding='UTF-8') {
		$this->server_url = "";
		$this->cut = 5000;
		$this->params = array();
		$this->encoding = $encoding;
	}

	/**
	 * 변수 얻기
	 *
	 * @param
	 * @return
	 */
	function get() {
		return $this->params;
	}

	/**
	 * 변수 셋팅
	 *
	 * @param
	 * @return
	 */
	function set($key="",$val1="",$val2="",$val3="") {
		if($key == 'TR_TO' && $val1 != "") {
			$this->params['TR_TO'][$val1] = array("name"=>$val2,"name2"=>$val3);
		} else {
			if (empty($val1)) {
				unset($this->params[$key]);
			} else {
				$this->params[$key] = $val1;
			}
		}
		return true;
	}

	/**
	 * SMS개수 확인
	 *
	 * @param
	 * @return
	 */
	function view($params = null) {

		if ($params === null) { $params = $this->params; }
		if (empty($params['TR_ID'])) { return array('msg'=>'TR_ID is empty','status'=>'fail'); }
		if (empty($params['TR_KEY'])) { return array('msg'=>'TR_KEY is empty','status'=>'fail'); }

		$return = array();
		$post = array('adminuser'=>$params['TR_ID'],
			'authkey'=>$params['TR_KEY'],
			'type'=>'view');

		$this->server_url = "http://sms.phps.kr/lib/send.sms";
		if (function_exists('mb_convert_encoding')) {

			if (function_exists('curl_exec')) {
				$return = $this->curl_send($post);
			} else if (function_exists('fsockopen')) {
				$return = $this->sock_send($post);
			} else {
				$return = "undefine function curl_exec or fsockopen";
			}
		} else {
			$return = "undefine function mb_convert_encoding";
		}
		return $return;
	}

	/**
	 * 삭제
	 *
	 * @param
	 * @return
	 */

	function cancel($params = null) {

		if ($params === null) { $params = $this->params; }
		if (empty($params['TR_ID'])) { return array('msg'=>'TR_ID is empty','status'=>'fail'); }
		if (empty($params['TR_KEY'])) { return array('msg'=>'TR_KEY is empty','status'=>'fail'); }

		$return = array();
		$post = array('adminuser'=>$params['TR_ID'],
			'authkey'=>$params['TR_KEY'],
			'date'=>date("Y-m-d H:i:s",strtotime("+1 day")),
			'tr_num'=>$params['TR_NUM']);

		$this->server_url = "http://sms.phps.kr/lib/send.sms";
		if (function_exists('mb_convert_encoding')) {

			if (function_exists('curl_exec')) {
				$return = $this->curl_send($post);
			} else if (function_exists('fsockopen')) {
				$return = $this->sock_send($post);
			} else {
				$return = "undefine function curl_exec or fsockopen";
			}
		} else {
			$return = "undefine function mb_convert_encoding";
		}
		return $return;
	}


	/**
	 * 전송
	 *
	 * @param
	 * @return
	 */
	function send($params = null) {
		if ($params === null) { $params = $this->params; }
		if (empty($params['TR_ID'])) { return array('msg'=>'TR_ID is empty','status'=>'fail'); }
		if (empty($params['TR_KEY'])) { return array('msg'=>'TR_KEY is empty','status'=>'fail'); }
		if (empty($params['TR_TXTMSG'])) { return array('msg'=>'TR_TXTMSG is empty','status'=>'fail'); }
		if (!is_array($params['TR_TO'])) { return array('msg'=>'TR_TO is not array','status'=>'fail'); }
		$tmpto = each($params['TR_TO']);
		if (empty($tmpto[0])) { return array('msg'=>'TR_TO is empty','status'=>'fail'); }
		if (empty($params['TR_DATE'])) { $params['TR_DATE']=0; }
		if (empty($params['TR_FROM'])) { return array('msg'=>'TR_FROM is empty','status'=>'fail'); }

		$phone		= "";
		$name		= "";
		$cnt		= 1;
		$index		= 0;
		$group = array();
        $group[$index]['phone'] = $group[$index]['name'] = $group[$index]['name2'] = '';
		foreach ($params['TR_TO'] as $key => $val) {
			$group[$index]['phone'] .= preg_replace("/[^0-9]/","",$key).",";
			$group[$index]['name'] .= preg_replace("/[,]/","",$val['name']).",";
			$group[$index]['name2'] .= preg_replace("/[,]/","",$val['name2']).",";
			if ($cnt % $this->cut == 0) { $index++; }
			$cnt++;
		}

		if (strtoupper($this->encoding) == 'UTF-8') {
			if (function_exists('mb_convert_encoding')) {
				if(isset($params['TR_COMMENT']))	{ $params['TR_COMMENT'] = mb_convert_encoding($params['TR_COMMENT'],'EUC-KR','UTF-8'); }
				$params['TR_TXTMSG'] = mb_convert_encoding($params['TR_TXTMSG'],'EUC-KR','UTF-8');
			} else if (function_exists('iconv')) {
				if(isset($params['TR_COMMENT']))	{ $params['TR_COMMENT'] = iconv('UTF-8','EUC-KR',$params['TR_COMMENT']); }
				$params['TR_TXTMSG'] = iconv('UTF-8','EUC-KR',$params['TR_TXTMSG']);
			} else {
				 return array('msg'=>'no encoding function','status'=>'fail');
			}
		}


		$return = array();
		foreach ($group as $key => $pdata) {
			$phone = preg_replace("/,$/","",$pdata['phone']);
			$name = preg_replace("/,$/","",$pdata['name']);
			$name2 = preg_replace("/,$/","",$pdata['name2']);

			if (strtoupper($this->encoding) == 'UTF-8') {
				if (function_exists('mb_convert_encoding')) {
					$name = mb_convert_encoding($name,'EUC-KR','UTF-8');
					$name2 = mb_convert_encoding($name2,'EUC-KR','UTF-8');
				} else if (function_exists('iconv')) {
					$name = iconv('UTF-8','EUC-KR',$name);
					$name2 = iconv('UTF-8','EUC-KR',$name2);
				} else {
					 return array('msg'=>'no encoding function','status'=>'fail');
				}
			}

			$post = array('adminuser'=>$params['TR_ID'],
				'authkey'=>$params['TR_KEY'],
				'phone'=>$phone,
				'name'=>$name,
				'name2'=>$name2,
				'rphone'=>$params['TR_FROM'],
				'msg'=>(isset($params['TR_COMMENT']))?$params['TR_COMMENT']:'',
				'sms'=>$params['TR_TXTMSG'],
				'date'=>$params['TR_DATE'],
				'ip'=>getenv("REMOTE_ADDR"));

			$this->server_url = "http://sms.phps.kr/lib/send.sms";


				if (function_exists('curl_exec')) {
					$return[] = $this->curl_send($post);
				} else if (function_exists('fsockopen')) {
					$return[] = $this->sock_send($post);
				} else {
					$return[] = "undefine function curl_exec or fsockopen";
				}

		}

		unset($this->params);
		return $return;
	}


	/**
	 * curl 전송
	 *
	 * @param
	 * @return
	 */
	function curl_send($post = array()) {

		//curl
		$CURL = curl_init($this->server_url);
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($CURL, CURLOPT_HEADER,false);
		curl_setopt($CURL, CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($CURL, CURLOPT_ENCODING,"");
		curl_setopt($CURL, CURLOPT_USERAGENT,"");
		curl_setopt($CURL, CURLOPT_AUTOREFERER,true);
		curl_setopt($CURL, CURLOPT_CONNECTTIMEOUT,120);
		curl_setopt($CURL, CURLOPT_TIMEOUT,120);
		curl_setopt($CURL, CURLOPT_MAXREDIRS,10);
		curl_setopt($CURL, CURLOPT_POST,1);
		curl_setopt($CURL, CURLOPT_POSTFIELDS,$post);
		curl_setopt($CURL, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($CURL, CURLOPT_VERBOSE,0);
		$undate		= curl_exec($CURL);
		curl_close($CURL);

		return unserialize($undate);
	}

	/**
	 * 소켓 전송
	 *
	 * @param
	 * @return
	 */
	function sock_send($post = array()) {

		//default
		$aPost = array();
		foreach($post as $key=>$val) {
			$aPost[] = $key."=".$val;
		}
		$posturl = join("&",$aPost);
		$tmpurl = parse_url($this->server_url);

		if ($tmpurl['scheme'] =='http') { $port = 80; } else { $port = 443; }
		$host = $tmpurl['host'];
		$path = $tmpurl['path'];

		//header
		$header ="POST ".$path."  HTTP/1.1\r\n";
		$header.="Host: ".$host."\r\n";
		$header.="User-Agent: PHP Script\r\n";
		$header.="Content-Type: application/x-www-form-urlencoded\r\n";
		$header.="Content-Length: ".strlen($posturl)."\r\n";
		$header.="Connection: close\r\n\r\n";
		$header.=$posturl;

		//fsockopen
		$sock = fsockopen($host, $port, $errno, $errstr);
		fwrite($sock, $header);
		while (!feof($sock)) { $response.=fgets($sock, 128); }

		//parse
		$response=explode("\r\n\r\n",$response);
		$header=$response[0];
		$responsecontent=$response[1];
		if(!(strpos($header,"Transfer-Encoding: chunked")===false)){
			$aux=split("\r\n",$responsecontent);
			for($i=0;$i<count($aux);$i++)
				if($i==0 || ($i%2==0))
					$aux[$i]="";
			$responsecontent=implode("",$aux);
		}//if
		return unserialize(chop($responsecontent));
	}
}
?>
<script>
alert('성공적으로 입력되었습니다.');
location.href= 'write.php';
</script>