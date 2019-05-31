
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
 


<body bgcolor="<?php echo '#eeaaee'; ?>">		


<form method="get" action="<?php echo basename(__FILE__);?>">
<select id="sql" name="sql">
<option></option>
<option>SELECT * FROM Jiaguwen</option>
<option>SELECT * FROM Jiaguwen LIMIT 0,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 1000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 2000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 3000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 4000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 5000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 6000,1000</option>
<option>SELECT * FROM Jiaguwen WHERE jink IS NULL</option>
<option>SELECT * FROM Jiaguwen WHERE jink = ""</option>
<option>SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' ORDER BY jtoh , jink DESC</option>
<option>SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' ORDER BY jtoh , jink ASC</option>
<option>SELECT * FROM Jiaguwen WHERE jmn LIKE '%,%'</option>
<option>SELECT * FROM Jiaguwen WHERE jmn <>""</option>
<option>SELECT * FROM Jiaguwen WHERE jmn IS NULL</option>
<option>SELECT * FROM Jiaguwen WHERE jmn IS NOT NULL</option>

<option>SELECT idx,jid,zid,jmn,rid FROM Jiaguwen ORDER BY idx</option>
<option>SELECT idx,jid, zid,jmn,rid FROM Jiaguwen ORDER BY idx</option>
</select>
<button type="submit">OK</button>
</form>

<?php

require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlJiaguwen.php");

$againstDir = "../uti/jgw/mer/compound/p/";
$againstDir = "../../odb/tbi/img/jgif/";



$ut = new MysqlUti();


//die("aa");
function htm_img_jqw( $val ){
   
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if(strlen($bname)==0) continue;
      $fname = "../../odb/tbi/img/jgif/$bname.gif";
      $ret .= "<img src='$fname'/>$bname";
   }
   return $ret; 
}
function htm_fnt_jqw( $val ){
   //   $ret .= "&#58333;<a>58333</a>&#62880;<a style='font-size:14.0pt;font-family:ICS3;mso-bidi-font-family:ICS3'>&#57344;&#57344;</a>";

   $ret="<a class='ics3'>&#$val;</a><a>$val</a>";
   
   return $ret;
}
function htm_numeric_jid( $val ){
   //   $ret .= "&#58333;<a>58333</a>&#62880;<a style='font-size:14.0pt;font-family:ICS3;mso-bidi-font-family:ICS3'>&#57344;&#57344;</a>";

   $ret="<a>$val</a>";
   
   return $ret;
}
function htm_img_zid( $val ){
   $ret="&#".$val.";".$val;
   return $ret;
}
function htm_img_hid( $val ){

   
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if('0'==$bname || strlen($bname)==0) continue;
      $fname = MysqlUti::src_of($bname);//"../../odb/hiero/ccer-h/$bname.gif";
      $ret .= "<img src='$fname'/>$bname";
   }
   return $ret;
}
function htm_tr( $row ){
   global $ut;


   echo "<tr>";
   foreach($row as $key => $val ) {
      if(is_numeric($key) ) continue;
      
      echo "<td>";
         switch($key){
         //case 'idx':
            ///echo htm_fnt_jqw($val);
         //break;
         case 'jid':
            echo htm_fnt_jqw($val);
            //echo "</td><td><a>$val</a></td>";
         break;
         case 'jink':
            echo htm_fnt_jqw($val);
            //echo htm_img_jqw($val);
            break;
         case 'zid':
            echo htm_img_zid($val);
         break;
         case 'jmn':
            echo htm_img_hid($val);
         break;
         case 'jtoh':
            echo htm_img_hid($val);
            $ut->push2TmpArr($val);
         break;
         default:
         echo $val;
         }
      echo "</td>";
   }
   echo "</tr>\r\n";
}
function htm_tr_colnames( $row ){
    echo "<tr>";
   foreach($row as $key => $val ) {
      if(is_numeric($key)) continue;
      echo "<td>";
         echo $key;
      echo "</td>";
   }
   echo "</tr>";
}

$jia = new MysqlJiaguwen();
$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
$sql = "SELECT * FROM Jiaguwen";
$sql = "SELECT jid,zid,jmn FROM Jiaguwen WHERE jtoh LIKE '%,%'";
$sql = "SELECT idx,jid,zid,jmn,rid FROM Jiaguwen ORDER BY idx";
if( isset($_REQUEST["sql"]) && strlen($_REQUEST["sql"])>0 ){
   $sql = $_REQUEST["sql"];
}

echo $sql . "<br>\n";
$ret = $jia->query($sql);
echo "count=". count($ret) . "<br>";


echo "<table border='1'>\r\n";
   htm_tr_colnames($ret[0]);
   foreach ($ret as $row){
      htm_tr($row);
   }
echo "</table>\r\n";






?>


</body>
</html>
