<html>
<head>
                <title>jgw db viewer</title>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>
                <script type="text/javascript" src="db_view_ajx.js"></script>

                <!-- Users -->
                <LINK href="db_view_item.css" rel="stylesheet" type="text/css">
                </head>

<style type="text/css">
div.sql_editor{
position: absolute; 
  zIndex: 5000; 
  left: 0;  
  top: 0; 
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
              $("#oksubmit").submit(function(){
								   var sql = $("#sql").val();
                           if ( sql.toLowerCase().search("update ") >=0 ){
                              return confirm("Update?\n"+sql);
                           }
                           return true;
								  });
});//$(document).ready(function(){                                      
</script>
 


<body bgcolor="<?php echo '#eeaaee'; ?>">		

<?php
//require_once("../tpl/atpl.php");
//atpl::printent("../tpl/mmdiv.php");
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






<div class="sql_editor">
<form method="get" action="<?php echo basename(__FILE__);?>">
   <a href="../../oMySql/phpMyAdmin-3.3.8/phpmyadmin_wei/index.php">DBM</a> <button id="oksubmit" type="submit">Sql</button>
   <input id="sql" name="sql" size='170%' value="<?php echo htmlentities($_REQUEST["sql"]);?>"></input><br>
   <select id="sss" name="sss">
      <option></option>
      <?php
      require_once("../tpl/atpl.php");
      //atpl::printent("../tpl/mmdiv.php");
      atpl::printent("db_view_selectoptions.tpl");
      atpl::printent("db_view_selectoptions2.tpl");
      ?>
   </select>

</form>
</div>



<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlHieroglyphics.php");

require_once("../uti/MysqlJiaguwen.php");
require_once("../uti/DbRow2Htm.php");

$againstDir = "../uti/jgw/mer/compound/p/";
$againstDir = "../../odb/tbi/img/jgif/";
if( !file_exists($againstDir)){
	echo "<font color='red'>no file exist:</font>";
}










echo  "<br><br>";
//echo "<a>$sql <br><br><br>";


if( preg_match("/Hieroglyphics/i",$sql)==1){
   //$db = new MysqlHieroglyphics();
}

$db = new MysqlJiaguwen();


$ret = $db->query($sql);
echo "count=". count($ret) .  ", " . $sql . "<br>";

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

      $fname = $r2htm->img_src_of($hid,$hid);  
      print("<img src='$fname' /img>$hid");
   }
}


?>






<!-- id="clentarea"-->


<br><br>Help:<br>
Shift + OnMouseMove ==> move sql editor. <br>
Shift + OnMouseMoveoverImg ==> Magnefy Img. <br> 

Ctrl + ClickImg ==> Copy, <br>
Ctrl + ClickTD ==> Paste Img into TD, <br>
Ctrl + ClickImgTitle ==> Delete img, <br>
Ctrl + ClickText ==> Update value.

<hr/>
chant font intval=978944 +jid. <br/>
sample:
<?php
$intval=978944  + 60569;
$chant= html_entity_decode("&#$intval;", 0, 'UTF-8');
echo "<font face='chant'>$chant</font>"; 
?>
</body>
</html>