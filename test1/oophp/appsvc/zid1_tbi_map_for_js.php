
<html>
<head>
                <title>jgw db viewer</title>

                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
                </head>
<style type="text/css">
a.ics3{
font-size:14.0pt;
font-family:ICS3;
mso-bidi-font-family:ICS3
}
</style>   

                
<script type="text/javascript">
var oid=57345;
$(document).ready(function(){     
});//$(document).ready(function(){                                            
</script>
 


<body>



<?php

require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlJiaguwen.php");

$againstDir = "../uti/jgw/mer/compound/p/";
$againstDir = "../../odb/tbi/img/jgif/";




$jdb = new MysqlJiaguwen();

$sql="Select zid1, jid from Jiaguwen";
$rows = $jdb->query($sql);

$arr = array();
foreach($rows as $row){
   $zid1 = $row["zid1"];
   $jid  = $row["jid"];
   
   if(!isset( $arr[$zid1] ) ){
      $arr[$zid1]=array();
   }
   $arr[$zid1] [] = $jid;

}

echo "var ZJ=new Array(); //zid1 to jid associated list. Tot=". count($arr) ."<br><br>";

$idx=0;
foreach($arr as $zid1 => $ar ){
   if($zid1==0) continue;
   $idx++;
   //printf( "%05d ", $idx );
   echo "ZJ[" . $zid1 ."]=\"" ;
   
   $str="";
   foreach($ar as $jid ){
      $str.= $jid . " ";
   }
   $str = trim($str);
   echo $str;
   echo "\";";
   echo "<br>\n";
}

?>


</body>
</html>
