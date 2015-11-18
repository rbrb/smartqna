<?php
	require_once("dbconfig.php");
	
	if(strpos($_SERVER['REQUEST_URI'], "admin_core.php"))
		$wrapper = "admin_core.php";
		else if (strpos($_SERVER['REQUEST_URI'], "notice.php"))
			$wrapper = "notice.php";

	//$_GET['bno']이 있을 때만 $bno 선언
	if(isset($_GET['bno'])) {
		$bNo = $_GET['bno'];
	}
		 
	if(isset($bNo)) {
		$sql = 'select b_title, b_content, b_id from board_notification where id = ' . $bNo;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
	}
?>
	<?php if (!strcmp($wrapper, "admin_core.php")) {?>
	<link rel="stylesheet" href="./css/board.css" />
	<?php }?>
	<article class="boardArticle">
		<div id="boardWrite">
			<form action="<?php echo $wrapper; ?>?window=write_update" method="post">
				<?php
				if(isset($bNo)) {
					echo '<input type="hidden" name="bno" value="' . $bNo . '">';
				}
				?>
				<table id="boardWrite">
					<tbody>
						<tr>
							<th scope="row"><label for="bID">아이디</label></th>
							<td class="id">
								<?php
								//if(isset($bNo)) {
									//echo $row['b_id'];
									echo $_SESSION['login_user'];
								//} else { ?>
									<input type="hidden" name="bID" id="bID" value="<?php echo $_SESSION['login_user']?>">
								<?php //} ?>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="bTitle">제목</label></th>
							<td class="title"><input type="text" name="bTitle" id="bTitle" value="<?php echo isset($row['b_title'])?$row['b_title']:null?>"></td>
						</tr>
						<tr>
							<th scope="row"><label for="bContent">내용</label></th>
							<td class="content"><textarea name="bContent" id="bContent"><?php echo isset($row['b_content'])?$row['b_content']:null?></textarea></td>
						</tr>
					</tbody>
				</table>
				<div class="btnSet">
					<button type="submit" class="btnSubmit btn">
						<?php echo isset($bNo)?'수정':'작성'?>
					</button>
					<a href="#" onClick="javascript:history.go(-1); return false ; " class="btnList btn">취소</a>
				</div>
			</form>
		</div>
	</article>
