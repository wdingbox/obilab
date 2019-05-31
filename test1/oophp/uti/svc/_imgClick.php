<?php
@session_start();

require_once("../MysqlJiaguwen.php");

if( !isset($_REQUEST["src"])) {
   echo "die";
   die ("no jid");
   }



$src = $_REQUEST["src"];

//print_r($_REQUEST);
//echo $src;

$jgw = new MysqlJiaguwen();

//remove duplicated.
$sql="DELETE FROM  ttt WHERE src ='$src' ";
$ret = $jgw->execute($sql);
echo $sql . "\nret=$ret";

//add the unique one.
$sql="INSERT  ttt (src) VALUES ('$src')";
$ret = $jgw->execute($sql);
echo $sql . "\nret=$ret";

?>