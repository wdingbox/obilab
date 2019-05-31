
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
</style>   

                
<script type="text/javascript">
var oid=57345;
$(document).ready(function(){     
});//$(document).ready(function(){                                            
</script>
 
<body bgcolor="<?php echo '#eeaaee'; ?>">		
<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>

<form method="get" action="<?php echo basename(__FILE__);?>">
<select id="sql" name="sql">
<option></option>
<option>SELECT * FROM Hieroglyphics</option>
<option>SELECT * FROM Hieroglyphics LIMIT 0,10</option>
<option>SELECT * FROM Hieroglyphics WHERE hink LIKE '%,%'</option>
<option>SELECT * FROM Hieroglyphics WHERE hink LIKE '%,%'</option>
</select>
<button type="submit">OK</button>
</form>

<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlHieroglyphics.php");

$againstDir = "../uti/jgw/mer/compound/p/";
$againstDir = "../../odb/tbi/img/jgif/";




$jia = new MysqlHieroglyphics();
$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
$sql = "SELECT * FROM Hieroglyphics";
if( isset($_REQUEST["sql"]) && strlen($_REQUEST["sql"])>0 ){
   $sql = $_REQUEST["sql"];
}

echo $sql . "<br>\n";
$ret = $jia->query($sql);
echo "count=". count($ret) . "<br>";
$jia->show_table( $ret );


?>


</body>
</html>