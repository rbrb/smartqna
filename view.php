<?php
	require_once("dbconfig.php");
	
if(strpos($_SERVER['REQUEST_URI'], "admin_core.php"))
	{
		$wrapper = "admin_core.php";
		$isAdmin = true;
	}
	else if (strpos($_SERVER['REQUEST_URI'], "notice.php"))
	{
		$wrapper = "notice.php";
		$isAdmin = false;
	}
	else{}
		
	$bNo = "";
	if(isset($_GET['bno']))
		$bNo = $_GET['bno'];
	if(isset($_GET['page']))
		$page = $_GET['page'];
	else 
		$page = 1;

	if(!empty($bNo) //&& empty($_COOKIE['board_notification_' . $bNo])
			) {
		$sql = 'update board_notification set b_hit = b_hit + 1 where id = ' . $bNo;
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
	
	$sql = 'select b_title, b_content, b_date, b_hit, b_id from board_notification where id = ' . $bNo;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
?>
	<?php if ($isAdmin) {?>
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
			<?php if(!strcmp($row['b_id'], $_SESSION['login_user'])) {?>
				<a href="<?php echo $wrapper; ?>?window=write&bno=<?php echo $bNo?>">수정</a>
				<a href="<?php echo $wrapper; ?>?window=delete_update&bno=<?php echo $bNo?>" onclick="return confirm('정말로 삭제하시겠습니까?')">삭제</a>
				<?php }?>
				<a href="<?php echo $wrapper."?page=".$page;?>" class="btnList btn">목록</a>
			</div>
		</div>
	</article>
	<?php } else {?>
<div class="page-header">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4 class="panel-title"><?php echo $row['b_title']?>　<small><span
					class="glyphicon glyphicon-calendar"></span> 작성일 : <?php echo $row['b_date']?> / 조회 : <?php echo $row['b_hit']?></small>
			</h4>
		</div>
		<div class="panel-body">
			<span class="glyphicon glyphicon-user"></span> 글쓴이 : <?php echo $row['b_id']?>
		</div>
	</div>
</div>

<div id="write_content"><?php echo $row['b_content']?></div>

<hr />

<div class="clearfix">
	<div class="pull-right">
<?php if(!strcmp($row['b_id'], $_SESSION['login_user'])) {?>
		<a href="<?php echo $wrapper; ?>?window=write&bno=<?php echo $bNo?>">수정</a>
				<a href="<?php echo $wrapper; ?>?window=delete_update&bno=<?php echo $bNo?>" onclick="return confirm('정말로 삭제하시겠습니까?')">삭제</a>
				<?php }?>
				<a href="<?php echo $wrapper."?page=".$page;?>" class="btnList btn">목록</a>
	</div>
</div>
<?php }?>