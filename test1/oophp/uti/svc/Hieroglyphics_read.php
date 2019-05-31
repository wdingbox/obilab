<?php

require_once("../MysqlHieroglyphics.php");

//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);

if( !isset($_REQUEST["jid"])) die ("err= no hid");

$hid =$_REQUEST["jid"];





   $jgw = new MysqlHieroglyphics();

   $sql="SELECT hink FROM Hieroglyphics WHERE hid='$hid'";//0:idx,1:jid,2:zid,3:freq
   $ret = $jgw->query($sql);

   //print_r($ret);
   if( isset($ret[0])){
      print( $ret[0]["hink"] );
   }
   else{
      print("err: no ret");
   }
   //print_r( $result );
   
   //printf("update ret=%d : %s-->%s",$ret, $jid, $linkjidcodes);
   
   //print_r($_REQUEST);
?>