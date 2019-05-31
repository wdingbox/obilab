<?php

require_once("../MysqlHieroglyphics.php");

//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);

if( !isset($_REQUEST["jid"])) die ("err: no hid");

$hid =$_REQUEST["jid"];
if( !isset($_REQUEST["freq"])) die ("err: no freq");

$freq =$_REQUEST["freq"];

   $jgw = new MysqlHieroglyphics();

   $sql="UPDATE Hieroglyphics SET freq=$freq WHERE hid='$hid'";//0:idx,1:hid,2:zid,3:freq
   $ret = $jgw->execute($sql);
   
   //if( !$ret) die("err: $sql");
   
   //print_r( $result );
   
   printf("update freq, ret=%d : %s",$ret, $sql);
   
   print_r($_REQUEST);
?>