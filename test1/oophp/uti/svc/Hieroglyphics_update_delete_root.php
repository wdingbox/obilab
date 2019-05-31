<?php

require_once("../MysqlHieroglyphics.php");

//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);

if( !isset($_REQUEST["jid"])) die ("err: no hid");

$hid =$_REQUEST["jid"];
syslog(0,"hid=".$hid);
if(strlen( $hid ) ==0) die (" err: hid is empty");

if( !isset($_REQUEST["roots"])) die ("err: no roots");
$roots =$_REQUEST["roots"];

syslog(0,"to delete a root=".$roots);
if(strlen( $roots ) ==0) die (" err: roots is empty");

if( $hid == $roots ) die("delete self err ");

$roots .=",";
$linkjidcodes="";

   $jgw = new MysqlHieroglyphics();
   

   $sql="SELECT hink FROM Hieroglyphics WHERE hid='$hid'";
   $ret = $jgw->query($sql);

   //print_r($ret);
   $linksRead = "";
   if( isset($ret[0])){
      $linksRead = ( $ret[0]["hink"] );
      $linksRead  = ltrim($linksRead, ",");
      syslog(0, "linksRead=".$linksRead);
   }
   else{
      die("err: no ret");
   }

   if(strlen($linksRead)>0){
      $linkjidcodes = str_replace($roots , "", $linksRead);
      syslog(0, "hink after detele=".$linkjidcodes);
   }
   else{
      die("err read");
   }
 
   
   
   
   $sql="UPDATE Hieroglyphics SET hink='$linkjidcodes' WHERE hid='$hid'";
   
   syslog(0, $sql);
   
   $ret = $jgw->execute($sql);
   
   //if( !$ret) die("err: $sql");
   
   //print_r( $result );
   
   printf("update ret=%d : %s-->%s",$ret, $hid, $linkjidcodes);
   
   print_r($_REQUEST);
?>