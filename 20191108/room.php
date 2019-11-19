<?php
	session_start();
	$db = new PDO("mysql:dbname=testtable;host=localhost;charset=utf8", "root", "");
	$selectsqls =$db->prepare("SELECT * FROM m_classroomform;");
	$selectsqls->execute();
	$selectsqls = $selectsqls->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>テーブルサンプル</title>
</head>
<body>
<form action="room.php" method="POST">
<table border="0">
	<tr>
		<tr>
			<td><input type="radio" name="radio" value="selecttype" checked="checked">教室タイプから探す
			<select name="roomtype">
<?php
	foreach($selectsqls as $selectsql){
?>
				<option value="<?php echo $selectsql['m_classroomform_name'];?>"><?php echo $selectsql['m_classroomform_name']; ?></option>
<?php
	}
?>
			</select>
		</tr>
		<tr>
			<td><input type="radio" name="radio" value="selectfloor">階から探す
			<select name="floor">
				<option value="1" selected>1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
			</select>F
		</tr>
		<tr>
			<td>
			表示件数：<select name="count">
			<option value="5" selected>5</option>
			<option value="10">10</option>
			<option value="25">25</option>
			<option value="50">50</option>
			</select>件ずつ
			</td>
		</tr>
		<tr>
			<td>
			<input type="submit" name="send" value="絞り込み">
			<input type="reset" value="リセット">
			</td>
		</tr>
	</tr>
</table>
</form>
<form action="roomtableadd.php" method="POST">
<?php
	if(isset($_POST['send'])||isset($_GET['page']))
	{
		if(isset($_POST['roomtype'])){
			$_SESSION['roomtype'] = $_POST['roomtype'];
		}
		if(isset($_POST['floor'])){
			$_SESSION['floor'] = $_POST['floor'];
		}
		if(isset($_POST['radio'])){
			$_SESSION['radio'] = $_POST['radio'];
		}
		if(isset($_POST['count'])){
			$_SESSION['count']=$_POST['count'];
		}
		// GETで現在のページ数を取得する
		if (isset($_GET['page'])) {
		$page = (int)$_GET['page'];
		} else {
		$page = 1;
		}
		// スタートのポジションを計算する
		if ($page > 1) {
			$start = ($page * $_SESSION['count']) - $_SESSION['count'];
		} else {
			$start = 0;
		}
		$int="";
		// postsテーブルから3件のデータを取得する
		if(strcmp($_SESSION['radio'], "selecttype")==0){
			$posts = $db->prepare("SELECT  m_classroom.m_classroom_id,m_classroomform.m_classroomform_name FROM  m_classroom LEFT JOIN m_classroomform ON m_classroom.m_classroomform_id = m_classroomform.m_classroomform_id WHERE m_classroomform.m_classroomform_name=\"".$_SESSION['roomtype']."\" LIMIT ".$start.", ".$_SESSION['count']."");
			$int=0;
		}else{
			$posts =$db->prepare("SELECT m_classroom.m_classroom_id, m_classroomform.m_classroomform_name FROM m_classroom LEFT JOIN m_classroomform ON m_classroom.m_classroomform_id = m_classroomform.m_classroomform_id where m_classroom.m_classroom_id LIKE\"".$_SESSION['floor']."%\" LIMIT {$start}, ".$_SESSION['count']."");
			$int=1;	
		}
		$posts->execute();
		$posts = $posts->fetchAll(PDO::FETCH_ASSOC);
		if($int==0){
			$page_num = $db->prepare("SELECT count(*) FROM  m_classroom LEFT JOIN m_classroomform ON m_classroom.m_classroomform_id = m_classroomform.m_classroomform_id WHERE m_classroomform.m_classroomform_name=\"".$_SESSION['roomtype']."\"");
		}else{
			$page_num = $db->prepare("SELECT count(*) FROM m_classroom LEFT JOIN m_classroomform ON m_classroom.m_classroomform_id = m_classroomform.m_classroomform_id where m_classroom.m_classroom_id LIKE\"".$_SESSION['floor']."%\"");
		}
		$page_num->execute();
		$page_num = $page_num->fetchColumn();
?>
<h1>出力結果</h1>
総レコード件数：<?php echo $page_num; ?><br>
<table border='1'>
<tr>
	<th>教室</th>
	<th>教室タイプ</th>
</tr>
<?php
$cnt=0;
	foreach ($posts as $post) {
		$cnt=$cnt+1;
?>
<tr>
	<td name="roomid<?php echo $cnt;?>"><?php echo $post['m_classroom_id']; ?></td>
	<td><select name="roomadd<?php echo $cnt;?>">
		<option value="<?php echo $post['m_classroomform_name'];?>" selected><?php echo $post['m_classroomform_name']; ?></option>
<?php
	$orders = $db->prepare("SELECT * FROM m_classroomform WHERE m_classroomform_name NOT LIKE \"".$post['m_classroomform_name']."\"");
	$orders->execute();
	$orders = $orders->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
	foreach($orders as $order){
?>
		<option value="<?php echo $order['m_classroomform_name'];?>"><?php echo $order['m_classroomform_name']; ?></option>

<?php

	}
?>
	</select></td>
	</tr>
<?php	

	}
?>
<?php
	// ページネーションの数を取得する
	$pagination = ceil($page_num / $_SESSION['count']);
	for ($x=1; $x <= $pagination ; $x++) { 
		echo'	<a href="?page='. $x .'">'; echo $x; echo"</a>";
	}
		echo '<br><input type="submit" name="UPD" value="保存"><input type="reset" value="リセット">';
	}
	if(isset($_POST['UPD'])){
		$UPD = $db->prepare("UPDATE m_classroom SET m_classroomform_id = (SELECT m_classroomform_id FROM m_classroomform WHERE m_classroomform_name=\"".$_POST['roomadd$cnt']."\")WHERE m_classroom_id=\"".$_POST['']."\"");	
}
?>
</form>
</body>
</html>