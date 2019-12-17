<?php
	define('MAX','5');
	$db = new PDO("mysql:dbname=testtable;host=localhost;charset=utf8", "root", "");
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$selectsqls =$db->prepare("SELECT * FROM m_student;");
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
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>QRコード発行</title>
</head>
<body>
<input type="button" value="印刷" onclick="window.print();" >
<table border='1' class="tablestudent">
<tr>
	<th>学籍番号</th>
	<th>生徒氏名</th>
	<th>入学年度</th>
	<th>生年月日</th>
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
?>
</body>
</html>