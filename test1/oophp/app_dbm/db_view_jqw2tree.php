<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
                <title>jgw db viewer</title>
                <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
                <script type="text/javascript" src="../../_js/jquery.js"></script>
   
                <script type="text/javascript" src="../_js/uti.js"></script>
                <script type="text/javascript" src="db_view_ajx.js"></script>
		
		
			<link rel="stylesheet" href="../../_js/jqtreeview/jquery.treeview.css" />
    <link rel="stylesheet" href="../../_js/jqtreeview/red-treeview.css" />
	<link rel="stylesheet" href="../_js/jqtreeview/ootree.css" />
	<script src="../../_js/jqtreeview/jquery.treeview.js" type="text/javascript"></script>
	

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
		$(function() {
			$("#browser").treeview(); 
		});
      $(document).ready(function(){
				  $(".ooimg").click(function(idx){
								   prompt("jid", "jid='"+$(this).attr("title")+"'");
								  });
});//$(document).ready(function(){  
</script>
 
	</head>
	<body>
	
   
	<h1 id="">jQuery Treeview OOA TBI</h1>
	<div id="main">

	<a>TBI OOA TreeView</a>
	<ul id="browser" class="filetree">


<?php
$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
$sql = "SELECT * FROM Jiaguwen";
$sql = "SELECT jnm, jid FROM Jiaguwen  WHERE jnm<>'0' AND jnm <>'-' AND jnm<>'' ORDER BY jnm";
if( isset($_REQUEST["sql"]) && strlen($_REQUEST["sql"])>0 ){
   $sql = $_REQUEST["sql"];
}
else{
   $_REQUEST["sql"]="";
}

require_once("ooData.htm");


?>










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











echo $sql . " ---------- <br><br><br>";


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




	</ul>
</div>
 
</body></html>
