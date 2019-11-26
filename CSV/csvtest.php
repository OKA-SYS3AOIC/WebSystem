<form action="csvtest.php" method="post" enctype="multipart/form-data">
  CSVファイル：<br />
  <input type="file" name="csvfile" size="30" /><br />
  <input type="submit" value="アップロード" />
</form>
<?php
if (!empty($_FILES["csvfile"]["tmp_name"])) {
  $file_tmp_name = $_FILES["csvfile"]["tmp_name"];
  $file_name = $_FILES["csvfile"]["name"];

  //拡張子を判定
  if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv') {
    $err_msg = 'CSVファイルのみ対応しています。';
  } else {

    if (move_uploaded_file($file_tmp_name, "data/uploaded/" . $file_name)) {
      //後で削除できるように権限を644に
      chmod("data/uploaded/" . $file_name, 0644);
      $msg = $file_name . "をアップロードしました。";
      $file = 'data/uploaded/'.$file_name;
      $fp   = fopen($file, "r");

      //配列に変換する
      while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
        $asins[] = $data;
      }
      fclose($fp);

      //ファイルの削除
      unlink('data/uploaded/'.$file_name);
    } else {
      $err_msg = "ファイルをアップロードできません。";
    }
  }

?>
<h1>出力結果</h1>
<form action="csvtest.php" method="post">
<table border='1'>
<tr>
<?php
for($t=0;$t<count($asins[0]); $t++){
?>
	<th><?php echo $asins[0][$t] ?></th>
<?php
}
?>	
</tr>
<?php
for($i=1;$i<count($asins); $i++){
?>
<tr>
<?php
	for($j=0;$j<count($asins[$i]); $j++){
?>
	<td><?php echo $asins[$i][$j] ?></td>
<?php
}
?>
</tr>
<?php
}
?>
</table>
</form>
<?php
}
?>