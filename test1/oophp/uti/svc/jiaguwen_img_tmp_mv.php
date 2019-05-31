<?php

require_once("../MysqlJiaguwen.php");


//print_r($_REQUEST);
$srcfile =$_REQUEST["srcfile"];

$imgfile = basename ( $srcfile );
$destfile = "/tmp/".$imgfile;

$ret = move( $srcfile, $destfile );
echo "ret=".$ret;
?>