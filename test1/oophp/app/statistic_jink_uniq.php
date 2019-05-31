
<html>
<head>
                <title>jgw db viewer</title>

                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
                </head>
 <style type="text/css">
zzzimg { 

height:30px;
width: 30px;
}
a{
   font-size:6px;
}
div{
float:left;
}
</style>   

                
<script type="text/javascript">
var oid=57345;
$(document).ready(function(){     
});//$(document).ready(function(){                                            
</script>
 


<body bgcolor="#eeaaee">		
<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>



<?php

require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlHieroglyphics.php");

require_once("../uti/MysqlJiaguwen.php");
require_once("../uti/DbStats.php");

$againstDir = "../uti/jgw/mer/compound/p/";
$againstDir = "../../odb/tbi/img/jgif/";





$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
$sql = "SELECT * FROM Jiaguwen";
$sql = "SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' LIMIT 0,10";
if( isset($_REQUEST["sql"]) && strlen($_REQUEST["sql"])>0 ){
   $sql = $_REQUEST["sql"];
}


if( isset($_REQUEST["idimg"]) && strlen($_REQUEST["idimg"])>0 ){
   $idimg = $_REQUEST["idimg"];
}



$lster = new DbStats();
//$lster->makelist_1($idimg);
$lster->jink_uniq_tbler_2s();

?>
<!-- id="clentarea"-->
</div>
</body>
</html>