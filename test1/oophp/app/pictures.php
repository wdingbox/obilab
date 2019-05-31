
<html>
<head>
                <title>jgw db viewer</title>

                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
                </head>
 <style type="text/css">
img { 

height:30px;
width: 30px;
}
div { 
float: left;
}
</style>   

                
<script type="text/javascript">
var oid=57345;
$(document).ready(function(){     
      $("#sss").change(function(idx){
         var sql = $(this).val();
         //alert(sql[0]);
         $("#sql").val(sql);
      });
});//$(document).ready(function(){                                            
</script>
 


<body bgcolor="<?php echo '#eeaaee'; ?>">		
<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>


<?php
$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
$sql = "SELECT * FROM Jiaguwen";
$sql = "SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' LIMIT 0,10";
if( isset($_REQUEST["sql"]) && strlen($_REQUEST["sql"])>0 ){
   $sql = $_REQUEST["sql"];
}
else{
   $_REQUEST["sql"]="";
}
?>







<form method="get" action="<?php echo basename(__FILE__);?>">
<input id="sql" name="sql" size='150' value="<?php echo htmlentities($_REQUEST["sql"]);?>"></input><br>
<select id="sss" name="sss">
<option></option>
<option>SELECT * FROM Jiaguwen</option>
<option>SELECT * FROM Jiaguwen WHERE jink LIKE '_____,' ORDER BY jink</option>
<option>SELECT jid FROM Jiaguwen</option>
<option>SELECT jid, zid FROM Jiaguwen</option>
<option>SELECT * FROM Jiaguwen LIMIT 0,10</option>
<option>SELECT * FROM Jiaguwen LIMIT 0,500</option>
<option>SELECT * FROM Jiaguwen LIMIT 0,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 1000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 2000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 3000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 4000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 5000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 6000,1000</option>

<option>SELECT * FROM Jiaguwen WHERE jink LIKE '_____,' ORDER BY jink</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink=''</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink IS NULL</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink LIKE '_____,'</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink LIKE '_____,_____,%'</option>

<option>SELECT DISTINCT jink FROM Jiaguwen WHERE jink LIKE '_____,'</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen LIMIT 0,10</option>
<option>SELECT jid, zid FROM Jiaguwen</option>


<option>SELECT * FROM Jiaguwen WHERE jink IS NULL</option>
<option>SELECT * FROM Jiaguwen WHERE jink = ""</option>
<option>SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' ORDER BY jtoh , jink DESC</option>
<option>SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' ORDER BY jtoh , jink ASC</option>
<option>SELECT * FROM Jiaguwen WHERE jmn LIKE '%,%'</option>
<option>SELECT * FROM Jiaguwen WHERE jmn <>""</option>
<option>SELECT * FROM Jiaguwen WHERE jmn IS NULL</option>
<option>SELECT * FROM Jiaguwen WHERE jmn IS NOT NULL</option>
<option>SELECT * FROM Jiaguwen WHERE L IS NULL</option>
<option>SELECT * FROM Jiaguwen WHERE L!='4' AND xa!='x'</option>
<option>SELECT * FROM Jiaguwen WHERE  xa='x'</option>
<option>SELECT * FROM Jiaguwen WHERE jink='' AND L!='1' AND L!='5' AND xa!='x' </option>
<option>SELECT * FROM Jiaguwen WHERE L IS NOT NULL ORDER BY L</option>
<option>SELECT jid,zid, freq  FROM Jiaguwen GROUP BY zid ORDER BY freq</option>

<option>SELECT * FROM Hieroglyphics LIMIT 0,10</option>
<option>SELECT * FROM Hieroglyphics LIMIT 0,100000</option>

<option>SELECT 'Jiaguwen.jid', 'Hieroglyphics.hid' FROM Jiaguwen, Hieroglyphics WHERE Jiaguwen.idx != ''   LIMIT 0,100</option>
<option>SELECT 'Jiaguwen.jid' , 'Hieroglyphics.hid'  FROM Jiaguwen, Hieroglyphics WHERE Jiaguwen.idx <10   LIMIT 0,10</option>
<option>SELECT 'Jiaguwen.jid' jid, 'Hieroglyphics.hid' hid FROM Jiaguwen, Hieroglyphics WHERE Jiaguwen.idx <10   LIMIT 0,10</option>
</select>
<button type="submit">OK</button>
</form>

<?php

require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlHieroglyphics.php");

require_once("../uti/MysqlJiaguwen.php");
require_once("../uti/DbRow2Htm.php");

$againstDir = "../uti/jgw/mer/compound/p/";
$againstDir = "../../odb/tbi/img/jgif/";











//echo $sql . "";


if( preg_match("/Hieroglyphics/i",$sql)==1){
   //$db = new MysqlHieroglyphics();
}
else {
   //$db = new MysqlJiaguwen();
}
$db = new MysqlJiaguwen();


$ret = $db->query($sql);
echo "count=". count($ret) . "<br>";

$r2htm = new DbRow2Htm();
echo "<table border='1'>\r\n";
   $r2htm->htm_tr_title($ret[0]);
   foreach ($ret as $row){
      $r2htm->htm_tr_dat_rd($sql,$row);
      
      if(isset($row['jtoh'])) {
         $r2htm->push2TmpArr($row['jtoh']);
      }
   }
echo "</table>\r\n";

echo "<br>total hieros=".count($r2htm->TmpArr);
echo "<br>";

if(isset($r2htm->TmpArr)){
   sort($r2htm->TmpArr);
   foreach ($r2htm->TmpArr as $hid  ){

      $fname = $r2htm->img_src_of($hid);  
      print("<img src='$fname' /img>$hid");
   }
}


?>
<!-- id="clentarea"-->
</div>
</body>
</html>