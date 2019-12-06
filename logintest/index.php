<?php
session_start();
if(isset($_SESSION['name'])==null){
header('Location: login.php');
}
echo "こんにちは、".$_SESSION['name']."さん<br>";
echo "あなたは".$_SESSION['classification']."です。<br>";

if($_SESSION['classification']=="講師"){
echo '選べるメニュー<br>';
echo '出席管理<br>';
}
else{
echo "選べるメニュー<br>";
echo '出席管理<br>';
echo 'クラス管理<br>';
echo '生徒管理<br>';
echo '教員管理<br>';
echo '<a href="room.php">教室管理</a><br>';
echo '学科・コース管理<br>';
echo '授業管理<br>';

}
echo '<form action="index.php" method="post">';
echo '<input type="submit" name="logout" value="ログアウト">';
echo '<input type="submit" name="PassChange" value="パスワード変更">';
echo '</form>';
if(isset($_POST['logout'])){
$_SESSION = array();
 
// セッションを破棄
session_destroy();
header('Location: logout.php');
}
//ここからパスワード変更処理
//パスワード変更フォームを召喚
if(isset($_POST['PassChange'])||isset($_POST['PassChangeCommit'])){
?>
<form action="index.php" method="post">
6～12文字の英数字<input type="password" name="PassChangeForm1" value="" onInput="checkForm(this)"><br>
確認のためもう一度入力してください。<input type="password" name="PassChangeForm2" value="" onInput="checkForm(this)"><br>
<input type="submit" name="PassChangeCommit" value="変更">

</form>
<?php
}
//入力内容チェック
if(isset($_POST['PassChangeCommit'])){
	//6文字以上か
	if(strlen($_POST['PassChangeForm1'])<6){
	echo "短すぎます。";
	//12文字以下か
	}else if(strlen($_POST['PassChangeForm1'])>12){
	echo "長すぎます。";
	//英字は含んであるか
	}else if ( preg_match('/[a-zA-Z]+/', $_POST['PassChangeForm1']) == 0) {
	echo "英字を一つ以上含んでください。";
	//数字は含んであるか
	}else if ( preg_match('/[0-9]+/', $_POST['PassChangeForm1']) == 0) {
	echo "数字を一つ以上含んでください。";
	//再入力フォームと入力内容は同じか
	}else if(strcmp($_POST['PassChangeForm1'], $_POST['PassChangeForm2']) != 0){
	echo "もう一度ご確認ください。";
	//正しければ
	}else if(strcmp($_POST['PassChangeForm1'], $_POST['PassChangeForm2']) == 0){
	//SHA256でハッシュ化
	$newpasshash=hash_hmac('sha256', $_POST['PassChangeForm1'], false);
	echo $newpasshash;
	//データベースに接続、UPDATE処理
	$db = new PDO("mysql:dbname=testtable;host=localhost;charset=utf8", "root", "");
	$UPD = $db->prepare("UPDATE m_employee SET m_employee_password = \"".$newpasshash."\" WHERE m_employee_id=\"".$_SESSION['id']."\"");	
	$UPD -> execute();
	echo"パスワードを変更しました。";
	}
}
?>
<!-- 入力制御(半角英数字以外は""にする) -->
<script type="text/javascript">

function checkForm($this)
{
    var str=$this.value;
    while(str.match(/[^A-Z^a-z\d\-]/))
    {
        str=str.replace(/[^A-Z^a-z\d\-]/,"");
    }
    $this.value=str;
}

</script>
