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

syslog(0,"to add roots=".$roots);
if(strlen( $roots ) ==0) die (" err: roots is empty");

$arrIn=array();
$arrIn = preg_split("/[,]/i",$roots);

$arrIn = array_unique($arrIn);
sort($arrIn);

if(count($arrIn)==0) die("err no input");





   $jgw = new MysqlHieroglyphics();
   

   $sql="SELECT hink FROM Hieroglyphics WHERE hid='$hid'";
   $ret = $jgw->query($sql);

   //print_r($ret);
   $linksRead = "";
   if( isset($ret[0])){
      $linksRead = ( $ret[0]["hink"] );
      //$linksRead = ltrim($linksRead,",");
   }
   else{
      print("err: no ret");
   }

   if(strlen($linksRead)>0){
   
      $arrRead = preg_split("/[,]/i",$linksRead);
      $arrIn = array_merge ($arrIn, $arrRead);
   }
  
   
   $arr = array_unique($arrIn);
   sort($arr);
   
   $linkjidcodes="";
   foreach( $arr as $val){
      $val = trim($val);
      if( strlen( $val ) == 0) continue;
      $linkjidcodes .= $val . ",";
   }
   //$linkjidcodes = ltrim($linkjidcodes,",");
   //$linkjidcodes = trim ( $linkjidcodes) ;
   if(strlen( $linkjidcodes) ==0 ) die ("err: input roots is null");
   
   
   
   
   
   $sql="UPDATE Hieroglyphics SET hink='$linkjidcodes' WHERE hid='$hid'";//0:idx,1:hid,2:zid,3:freq
   
   syslog(0,$sql);
   
   $ret = $jgw->execute($sql);
   
   //if( !$ret) die("err: $sql");
   
   //print_r( $result );
   
   printf("ret=%d; hid=%s; updatedlinkjidcodes=%s; ",$ret, $hid, $linkjidcodes);
   
   print_r($_REQUEST);
?>