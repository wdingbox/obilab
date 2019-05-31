<?php

require_once("../MysqlJiaguwen.php");

//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);
function errdie($msg){
   die("err : $msg");
}

if( !isset($_REQUEST["jid"])) die ("err : no jid");

$jid =$_REQUEST["jid"];

if( !isset($_REQUEST["jtoh"])) die ("err : no jtoh");

$jtoh =$_REQUEST["jtoh"];



$linkjidcodes = MysqlUti::merge_str_links($jtoh,"");


   $jgw = new MysqlJiaguwen();

   $sql="UPDATE Jiaguwen SET jtoh='$linkjidcodes' WHERE jid='$jid'";//0:idx,1:jid,2:zid,3:freq
   $ret = $jgw->execute($sql);
   
   if(0==$ret) {
      print "err ";
   }
   syslog(0,"ret=$ret; sql=$sql");
   
   //print_r( $result );
   
   printf("update ret=%d;  jid=%s; jtoh=%s; sql=$sql",$ret, $jid, $jtoh, $sql);
   
   print_r($_REQUEST);
?>