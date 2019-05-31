<?php

require_once("../MysqlJiaguwen.php");


//print_r($_REQUEST);
$jid =$_REQUEST["jid"];

   $jgw = new MysqlJiaguwen();

   $sql="SELECT * FROM `Jiaguwen` WHERE jid=$jid";//0:idx,1:jid,2:zid,3:freq
   $ret = $jgw->query($sql);
   
   //print_r( $result );
   
   printf("%s,  &#%s;%s, (id=%d, frq=%d)",$ret[0][1],$ret[0][2],$ret[0][2],$ret[0][0],$ret[0][3]);
   
?>