
<?php

//データベース接続
$server = "localhost";
$userName = "root";
$password = "";
$dbName = "testtable";

$mysqli = new mysqli($server, $userName, $password,$dbName);

if ($mysqli->connect_error){
    echo $mysqli->connect_error;
    exit();
}else{
    $mysqli->set_charset("UTF8");
}

$sql = "SELECT * FROM m_classroomform;";

$result = $mysqli -> query($sql);

//クエリー失敗
if(!$result) {
    echo $mysqli->error;
    exit();
}

//レコード件数
$row_count = $result->num_rows;

//連想配列で取得
while($row = $result->fetch_array(MYSQLI_ASSOC)){
    $rows[] = $row;
}

//結果セットを解放
$result->free();

// データベース切断
$mysqli->close();

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
foreach($rows as $row){

?>

	<option value="<?php echo $row['m_classroomform_name'];?>"><?php echo $row['m_classroomform_name']; ?></option>
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
if(isset($_POST['send']))
{

include 'roomtable.php';
}

?>


</body>
</html>