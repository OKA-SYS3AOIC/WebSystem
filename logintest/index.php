<?php
session_start();
echo "こんにちは、".$_SESSION['name']."さん<br>";
echo "あなたは".$_SESSION['classification']."です。<br>";

if($_SESSION['classification']=="講師"){
echo "選べるメニュー<br>";
echo "出席管理<br>";
}
else{
echo "選べるメニュー<br>";
echo "出席管理<br>";
echo "クラス管理<br>";
echo "生徒管理<br>";
echo "教員管理<br>";
echo "教室管理<br>";
echo "学科・コース管理<br>";
echo "授業管理<br>";
}