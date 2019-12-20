<?php
	session_start();
	define('MAX','5');
	$db = new PDO("mysql:dbname=testtable;host=localhost;charset=utf8", "root", "");
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$selectcourses =$db->prepare("SELECT * FROM m_course;");
	$selectcourses->execute();
	$selectcourses = $selectcourses->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>QRコード発行</title>
</head>
<body>
<form action="student2.php" method="POST">
<table border="0">
	<tr>
		<tr>
		<td><input type="submit" name="newrec" value="新規登録" disabled></td>
		</tr>
		<tr>
		<td><input type="radio" name="radio" value="checkstuno" checked="checked">学籍番号<input type="text" name="inputstuno"></td>
		</tr>
		<tr>
		<td><input type="radio" name="radio" value="checkstuname">生徒名<input type="text" name="inputstuname"></td>
		</tr>
		<tr>
		<td><input type="radio" name="radio" value="checkstufc">入学年度・コース
		<br>入学年度<input type="text" name="inputfirstyear">
		<br>コース
			<select name="course">
				<option value="C000" selected>-----</option>
		<?php
			foreach($selectcourses as $selectcourse){
		?>
		<option value="<?php echo $selectcourse['m_course_id'];?>"><?php echo $selectcourse['m_course_name']; ?></option>
		<?php
			}
		?>
			</select>
		</td>
		</tr>
		<tr>
			<td>
			<input type="submit" name="send" value="検索">
			</td>
		</tr>
	</tr>
</table>
</form>
<?php
	if(isset($_POST['send'])||isset($_GET['page_id']))
	{
		if(isset($_POST['inputstuno'])){
			$_SESSION['inputstuno'] = $_POST['inputstuno'];
		}
		if(isset($_POST['inputstuname'])){
			$_SESSION['inputstuname'] = $_POST['inputstuname'];
		}
		if(isset($_POST['inputfirstyear'])){
			$_SESSION['inputfirstyear'] = $_POST['inputfirstyear'];
		}
		if(isset($_POST['radio'])){
			$_SESSION['radio'] = $_POST['radio'];
		}
		if(isset($_POST['course'])){
			$_SESSION['course']=$_POST['course'];
		}


		if(strcmp($_SESSION['radio'], "checkstuno")==0){
			if($_SESSION['inputstuno']!=null){
			$selectsqls = $db->prepare("SELECT * FROM m_student LEFT JOIN m_course ON m_student.m_course_id = m_course.m_course_id WHERE m_student_id=\"".$_SESSION['inputstuno']."\"");
			}else{
			$selectsqls = $db->prepare("SELECT * FROM m_student LEFT JOIN m_course ON m_student.m_course_id = m_course.m_course_id");
			}
		}else if(strcmp($_SESSION['radio'], "checkstuname")==0){
			if($_SESSION['inputstuname']!=null){
			$selectsqls = $db->prepare("SELECT * FROM m_student LEFT JOIN m_course ON m_student.m_course_id = m_course.m_course_id WHERE m_student_name LIKE\"".$_SESSION['inputstuname']."%\"");
			}else{
			$selectsqls = $db->prepare("SELECT * FROM m_student LEFT JOIN m_course ON m_student.m_course_id = m_course.m_course_id");
			}
		}else if(strcmp($_SESSION['radio'], "checkstufc")==0){
			if($_SESSION['inputfirstyear']!=NULL&&strcmp($_SESSION['course'], "C000")==0){
			$selectsqls =$db->prepare("SELECT * FROM m_student LEFT JOIN m_course ON m_student.m_course_id = m_course.m_course_id where m_student.m_student_firstyear=\"".$_SESSION['inputfirstyear']."\"");
			}else if($_SESSION['inputfirstyear']!=NULL&&strcmp($_SESSION['course'], "C000")!==0){
			$selectsqls =$db->prepare("SELECT * FROM m_student LEFT JOIN m_course ON m_student.m_course_id = m_course.m_course_id where m_student.m_student_firstyear=\"".$_SESSION['inputfirstyear']."\"AND m_student.m_course_id=\"".$_SESSION['course']."\"");
			}else if($_SESSION['inputfirstyear']==NULL&&strcmp($_SESSION['course'], "C000")!==0){
			$selectsqls =$db->prepare("SELECT * FROM m_student LEFT JOIN m_course ON m_student.m_course_id = m_course.m_course_id where m_student.m_course_id=\"".$_SESSION['course']."\"");
			}else if($_SESSION['inputfirstyear']==NULL&&strcmp($_SESSION['course'], "C000")==0){
			$selectsqls = $db->prepare("SELECT * FROM m_student LEFT JOIN m_course ON m_student.m_course_id = m_course.m_course_id");
			}
		}
	$selectsqls->execute();
	$selectsqls = $selectsqls->fetchAll(PDO::FETCH_ASSOC);

$data_num = count($selectsqls); // トータルデータ件数
 
$max_page = ceil($data_num / MAX); // トータルページ数※ceilは小数点を切り捨てる関数
 
if(!isset($_GET['page_id'])){ // $_GET['page_id'] はURLに渡された現在のページ数
    $now = 1; // 設定されてない場合は1ページ目にする
}else{
    $now = $_GET['page_id'];
}
 
$start_no = ($now - 1) * MAX; // 配列の何番目から取得すればよいか
 
// array_sliceは、配列の何番目($start_no)から何番目(MAX)まで切り取る関数
$disp_data = array_slice($selectsqls, $start_no, MAX, true);
?>
<input type="button" value="印刷" onclick="window.print();" >
<table border='1' class="tablestudent">
<tr>
	<th>学籍番号</th>
	<th>生徒氏名</th>
	<th>入学年度</th>
	<th>生年月日</th>
	<th>コース</th>
	<th>QRコード</th>
</tr>
<?php
$qr="";
	foreach ($disp_data as $selectsql) {
	$qr=hash_hmac('sha256', $selectsql['m_student_id'],$selectsql['m_student_birthday'], false);
?>
	<tr>
	<td><?php echo $selectsql['m_student_id']; ?></td>
	<td><a href="stuqr.php?si=<?php echo $selectsql['m_student_id']?>"><?php echo $selectsql['m_student_name']; ?></a></td>
	<td><?php echo $selectsql['m_student_firstyear']; ?></td>
	<td><?php echo $selectsql['m_student_birthday']; ?></td>
	<td><?php echo $selectsql['m_course_name']; ?></td>
	<td class="qrimg"><img src="php/qr_img.php?d=<?php echo $qr; ?>"class="qrcode"></td>
	</tr>
<?php	

	}
?>
<?php
 
for($i = 1; $i <= $max_page; $i++){ // 最大ページ数分リンクを作成
    if ($i == $now) { // 現在表示中のページ数の場合はリンクを貼らない
        echo $now. '　'; 
    } else {
        echo '<a href=\'/student2.php?page_id='. $i. '\')>'. $i. '</a>'. '　';
    }
}
//処理終了
}
?>
</body>
</html>