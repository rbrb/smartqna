<?php
	require_once("dbconfig.php");

	//$_GET['bno']이 있을 때만 $bno 선언
	if(isset($_GET['bno'])) {
		$bNo = $_GET['bno'];
	}
		 
	if(isset($bNo)) {
		$sql = 'select b_title, b_content, b_id from board_notification where b_no = ' . $bNo;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
	}
?>
	<link rel="stylesheet" href="./css/board.css" />
	<article class="boardArticle">
		<div id="boardWrite">
			<form action="admin_core.php?window=write_update" method="post">
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
									<input type="hidden" name="bID" id="bID">
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
					<a href="admin_core.php" class="btnList btn">목록</a>
				</div>
			</form>
		</div>
	</article>
