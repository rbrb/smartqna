<?php
	require_once("dbconfig.php");
	
	if(strpos($_SERVER['REQUEST_URI'], "admin_core.php"))
		$wrapper = "admin_core.php";
		else if (strpos($_SERVER['REQUEST_URI'], "notice.php"))
			$wrapper = "notice.php";

	//$_POST['bno']이 있을 때만 $bno 선언
	if(isset($_GET['bno'])) {
		$bNo = $_GET['bno'];
	}

	//$bPassword = $_POST['bPassword'];

//글 삭제
if(isset($bNo)) {
	//삭제 할 글의 비밀번호가 입력된 비밀번호와 맞는지 체크
	//$sql = 'select count(b_password) as cnt from board_notification where b_password=password("' . $bPassword . '") and b_no = ' . $bNo;
	//$result = $db->query($sql);
	//$row = $result->fetch_assoc();
	
	//비밀번호가 맞다면 삭제 쿼리 작성
	//if($row['cnt']) {
		$sql = 'delete from board_notification where id = ' . $bNo;
	//틀리다면 메시지 출력 후 이전화면으로
	//} else {
	//	$msg = '비밀번호가 맞지 않습니다.';
	}

	$result = $db->query($sql);
	
//쿼리가 정상 실행 됐다면,
if($result) {
	$msg = '정상적으로 글이 삭제되었습니다.';
	$replaceURL = $wrapper;
} else {
	$msg = '글을 삭제하지 못했습니다.';
?>
	<script>
		alert("<?php echo $msg?>");
		history.back();
	</script>
<?php
	exit;
}


?>
<script>
	alert("<?php echo $msg?>");
	location.replace("<?php echo $replaceURL?>");
</script>