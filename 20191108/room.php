
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
    <td></td>
    <td>
      <input type="submit" name="send" value="絞り込み">
      <input type="reset" value="リセット">
    </td>
  </tr>
  </tr>
</table>
</form>
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


echo $_SESSION['roomtype'];


	// PDOでDBに接続


	// GETで現在のページ数を取得する（未入力の場合は1を挿入）
	if (isset($_GET['page'])) {
	$page = (int)$_GET['page'];
	} else {
	$page = 1;
	}

	// スタートのポジションを計算する
	if ($page > 1) {
	// 例：２ページ目の場合は、『(2 × 3) - 3 = 3』
		$start = ($page * 3) - 3;
		} else {
		$start = 0;
	}
$int="";
	// postsテーブルから3件のデータを取得する
if(strcmp($_SESSION['radio'], "selecttype")==0){
	$posts = $db->prepare("SELECT  m_classroom.m_classroom_id,m_classroomform.m_classroomform_name FROM  m_classroom LEFT JOIN m_classroomform ON m_classroom.m_classroomform_id = m_classroomform.m_classroomform_id WHERE m_classroomform.m_classroomform_name=\"".$_SESSION['roomtype']."\" LIMIT ".$start.", 3");
	$int=0;
}else{
	$posts =$db->prepare("SELECT m_classroom.m_classroom_id, m_classroomform.m_classroomform_name FROM m_classroom LEFT JOIN m_classroomform ON m_classroom.m_classroomform_id = m_classroomform.m_classroomform_id where m_classroom.m_classroom_id LIKE\"".$_SESSION['floor']."%\" LIMIT {$start}, 3");
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
	foreach ($posts as $post) {
?>
	<tr>
    		<td><?php echo $post['m_classroom_id']; ?></td>
    		<td><select name="roomtype">
		<option value="1" selected><?php echo $post['m_classroomform_name']; ?></option>
		<option value="2">通常</option>
		<option value="3">PC可</option>
		<option value="4">その他</option>
		</select>
    	</td>
	</tr>
<?php	
	}
?>
<?php

	
	// ページネーションの数を取得する
	$pagination = ceil($page_num / 3);

	 for ($x=1; $x <= $pagination ; $x++) { 
	echo'<a href="?page='. $x .'">'; echo $x; echo"</a>";
 						}
}
?>
</body>
</html>
