<?php
	$db = new PDO("mysql:dbname=testtable;host=localhost;charset=utf8", "root", "");
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$selectsqls =$db->prepare("SELECT * FROM m_student WHERE m_student_id=\"".$_GET['si']."\"");
	$selectsqls->execute();
	$selectsqls = $selectsqls->fetchAll(PDO::FETCH_ASSOC);

foreach ($selectsqls as $selectsql) {
$qr=hash_hmac('sha256', $selectsql['m_student_id'],$selectsql['m_student_birthday'], false);
echo $selectsql['m_student_id'];
echo $selectsql['m_student_name'];
?>
<img src="php/qr_img.php?d=<?php echo $qr; ?>"class="qrcode">
<?php
}
?>