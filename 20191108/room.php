<?php
	session_start();
	$db = new PDO("mysql:dbname=testtable;host=localhost;charset=utf8", "root", "");
	$selectsqls =$db->prepare("SELECT * FROM m_classroomform;");
	$selectsqls->execute();
	$selectsqls = $selectsqls->fetchAll(PDO::FETCH_ASSOC);
	$roomformcount = count($selectsqls);
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
		<td><input type="submit" name="newrec" value="新規登録"></td>
		</tr>
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
<form action="room.php" method="POST">
<?php
//新規登録の処理
	if(isset($_POST['newrec']))
	{
echo '<input type="radio" name="newsel" value="newclass" checked="checked">新規クラス作成<br>';
echo'クラス名<input type="text" name="newclass" value="">例)1A、9D1<br>';
echo '教室タイプ<select name="newroomtype">';
foreach($selectsqls as $selectsql){
	echo '<option value="';echo $selectsql['m_classroomform_name']; echo'">';echo $selectsql['m_classroomform_name'];echo"</option>";
	}
echo"</select><br>";
echo '<input type="radio" name="newsel" value="newtype">新規教室タイプ作成<br>';
echo'クラスタイプ名<input type="text" name="newclasstype" value=""><br>';
echo'<input type="submit" name="newrecsend" value="新規登録">';
}
if(isset($_POST['newrecsend']))
{
$INS="";
if(strcmp($_POST['newsel'], "selecttype")==0){
	$SELS=$db->prepare("SELECT m_classroomform_id FROM m_classroomform WHERE m_classroomform_name=\"".$_POST['newroomtype']."\"");
	$SELS->execute();
	$SELS=$SELS->fetchAll(PDO::FETCH_ASSOC);
	foreach ($SELS as $SEL) {
	$INS=$db->prepare("INSERT INTO m_classroom (m_classroom_id,m_classroom_qrdate,m_classroomform_id) VALUES (\"".$_POST['newclass']."\",\"qr\",\"".$SEL['m_classroomform_id']."\")");
						}
}else{
$roomformcount++;
if($roomformcount<10){
$INS=$db->prepare("INSERT INTO m_classroomform(m_classroomform_id,m_classroomform_name)values(\"RF0".$roomformcount."\",\"".$_POST['newclasstype']."\")");
}else{
$INS=$db->prepare("INSERT INTO m_classroomform(m_classroomform_id,m_classroomform_name)values(\"RF".$roomformcount."\",\"".$_POST['newclasstype']."\")");
}
}
	$INS->execute();
	echo"正常終了";
header('Location: room.php');
	}
//検索結果表示処理
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
		// postsテーブルからデータを取得する
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
		$_SESSION['num']=$page_num;
?>
<h1>出力結果</h1>
総レコード件数：<?php echo $_SESSION['num']; ?><br>
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

	<td><?php echo $post['m_classroom_id']; ?></td>
	<input type="hidden" name="classroomid<?php echo $cnt;?>" value="<?php echo $post['m_classroom_id']; ?>">
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
//データ更新処理
	if(isset($_POST['UPD'])){
if($_SESSION['num']<$_SESSION['count']){
for($f=1; $f<=$_SESSION['num']; $f++){
		$UPD = $db->prepare("UPDATE m_classroom SET m_classroomform_id = (SELECT m_classroomform_id FROM m_classroomform WHERE m_classroomform_name=\"".$_POST['roomadd'.$f]."\")WHERE m_classroom_id=\"".$_POST['classroomid'.$f]."\"");	
		$UPD -> execute();
}
}else
{
for($fe=1; $fe<=$_SESSION['count']; $fe++){
		$UPD = $db->prepare("UPDATE m_classroom SET m_classroomform_id = (SELECT m_classroomform_id FROM m_classroomform WHERE m_classroomform_name=\"".$_POST['roomadd'.$fe]."\")WHERE m_classroom_id=\"".$_POST['classroomid'.$fe]."\"");	
		$UPD -> execute();
}
}
//header('Location: room.php');
}
?>
</form>
</body>
</html>