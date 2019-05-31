<?php

require_once("../MysqlHieroglyphics.php");

//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);

if( !isset($_REQUEST["jid"])) die ("err: no hid");

$hid =$_REQUEST["jid"];



$arr=array();
foreach( $_REQUEST as $key => $val )
{
   $name= substr( $key,0,4 ) ;//"jink".$i;
   if($name != "jink") continue;
   //if( !isset($_REQUEST[$name])) contin;
   if( strlen( $val) < 1 ) continue;
   $val = trim ( $val );
   if( $hid == $val ) die ("err: self jink error");  
   
   $arr[] = $val;
}
if( count( $arr ) ==0 ) die ("err: no jink val");

$arr = array_unique($arr);
sort($arr);

$linkjidcodes="";
foreach( $arr as $val){
   $linkjidcodes .= $val . ",";
}





   $jgw = new MysqlHieroglyphics();

   $sql="UPDATE Hieroglyphics SET hink='$linkjidcodes' WHERE hid='$hid'";//0:idx,1:hid,2:zid,3:freq
   $ret = $jgw->execute($sql);
   
   //if( !$ret) die("err: $sql");
   
   //print_r( $result );
   
   printf("update ret=%d : %s-->%s",$ret, $hid, $linkjidcodes);
   
   print_r($_REQUEST);
?>