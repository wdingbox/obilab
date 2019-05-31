<?php

require_once("../MysqlJiaguwen.php");

//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);

if( !isset($_REQUEST["jid"])) die ("no jid");

$jid =$_REQUEST["jid"];



$arr=array();
foreach( $_REQUEST as $key => $val )
{
   $name= substr( $key,0,4 ) ;//"jink".$i;
   if($name != "jink") continue;
   //if( !isset($_REQUEST[$name])) contin;
   if( strlen( $val) < 1 ) continue;
   
   if( $jid == $val ) die ("self jink error");  
   
   $arr[] = $val;
}
if( count( $arr ) ==0 ) die ("no jink val");

$arr = array_unique($arr);
sort($arr);

$linkjidcodes="";
foreach( $arr as $val){
   $val = trim ( $val );
   if( strlen($val) <1 ) continue;
   $linkjidcodes .= $val . ",";
}





   $jgw = new MysqlJiaguwen();

   $sql="UPDATE Jiaguwen SET hiero='$linkjidcodes' WHERE jid='$jid'";//0:idx,1:jid,2:zid,3:freq
   $ret = $jgw->execute($sql);
   
   //print_r( $result );
   
   printf("update ret=%d : %s-->%s",$ret, $jid, $linkjidcodes);
   
   print_r($_REQUEST);
?>