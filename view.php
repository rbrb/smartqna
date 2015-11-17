<?php
	require_once("dbconfig.php");
	$bNo = "";
	if(isset($_GET['bno']))
		$bNo = $_GET['bno'];
	if(isset($_GET['page']))
		$page = $_GET['page'];
	else 
		$page = 1;

	if(!empty($bNo) //&& empty($_COOKIE['board_notification_' . $bNo])
			) {
		$sql = 'update board_notification set b_hit = b_hit + 1 where b_no = ' . $bNo;
		$result = $db->query($sql); 
		if(empty($result)) {
			?>
			<script>
				alert('오류가 발생했습니다.');
				history.back();
			</script>
			<?php 
		//} else {
			//setcookie('board_notification_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
		}
	}
	
	$sql = 'select b_title, b_content, b_date, b_hit, b_id from board_notification where b_no = ' . $bNo;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
?>
	<link rel="stylesheet" href="./css/board.css" />
	<article class="boardArticle">
		<div id="boardView">
			<h3 id="boardTitle"><?php echo $row['b_title']?></h3>
			<div id="boardInfo">
				<span id="boardID">작성자: <?php echo $row['b_id']?></span>
				<span id="boardDate">작성일: <?php echo $row['b_date']?></span>
				<span id="boardHit">조회: <?php echo $row['b_hit']?></span>
			</div>
			<div id="boardContent"><?php echo $row['b_content']?></div>
			<div class="btnSet">
			<?php if($row['b_id'] == $_SESSION['login_user']) {?>
				<a href="admin_core.php?window=write&bno=<?php echo $bNo?>">수정</a>
				<a href="admin_core.php?window=delete_update&bno=<?php echo $bNo?>" onclick="return confirm('정말로 삭제하시겠습니까?')">삭제</a>
				<?php }?>
				<a href="#" onClick="javascript:history.go(-1); return false ; " class="btnList btn">목록</a>
			</div>
		</div>
	</article>
