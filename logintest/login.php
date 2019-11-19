<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>テーブルサンプル</title>
</head>
<body>

<form action="login.php" method="POST">
	<p>メールアドレス： <input type="text" name="mail"></p>
	<p>パスワード： <input type="password" name="pass"></p>
	<p><input type="submit" name="send" value="ログイン"></p>
</form>
<?php

//sendを取ったら(ボタンを押したら)作動
if(isset($_POST['send']))
{
session_start();

$_SESSION['mail'] = $_POST['mail'];

$_SESSION['pass'] = $_POST['pass'];

try{
$db = new PDO("mysql:dbname=testtable;host=localhost;charset=utf8", "root", "");



$selectsqls =$db->prepare("SELECT * FROM m_employee LEFT JOIN m_employeeclassification ON m_employee.m_employeeclassification_id = m_employeeclassification.m_employeeclassification_id WHERE m_employee.m_employee_mailaddress=\"".$_SESSION['mail']."\" and m_employee.m_employee_password=\"".$_SESSION['pass']."\"");

$selectsqls->execute();

//レコード件数取得
$row_count = $selectsqls->rowCount();

//変換
$result = $selectsqls->fetch(PDO::FETCH_ASSOC);

//切断
$db=null;

} catch (PDOException $e) {
     echo $e->getMessage();
     exit;
}
if($row_count>0){
//ログイン者の名前、分類をセッションに記録
$_SESSION['name'] = $result['m_employee_name'];
$_SESSION['classification'] = $result['m_employeeclassification_name'];
//indexへ遷移
header('Location: index.php');
}
//メアドかパスが間違っていたら
else{
echo "メールアドレスまたはパスワードが間違っています。";
}
}
?>

</body>
</html>