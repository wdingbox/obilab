<?php
require_once("Jiaguwen.php"); 

$contents = json_encode($Jiaguwen);
$fname="Jiaguwen.json";
$size=file_put_contents($fname,$contents);
echo $size;
echo "<hr/>";
echo $contents;

$contents=file_get_contents($fname);
$arr=json_decode($contents);

$size=file_put_contents("$fname.2php",$contents);

?>