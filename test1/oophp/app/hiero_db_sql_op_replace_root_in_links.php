<!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<body>
<form action="<?php echo basename( $__FILE__ ) ;?>" method="GET">
<a>oldroot<a><input id="oldroot" name="oldroot" value="<?php echo  $_REQUEST["oldroot"];?>" type="text"></input>
<a>newroot<a><input id="newroot" name="newroot" value="<?php echo  $_REQUEST["newroot"];?>" type="text"></input>
<input name="confirm" type="checkbox" />
<button type="submit">OK</button>
</form>




<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlHieroglyphics.php");


//if(!isset($_REQUEST["oldroot"])) die("'oldroot' is not set.");
//if(!isset($_REQUEST["newroot"])) die("'newroot' is not set.");


$oldroot = $_REQUEST["oldroot"];
$newroot = $_REQUEST["newroot"];


print("oldroot=".MysqlHieroglyphics::htm_img($oldroot ) .",newroot=".MysqlHieroglyphics::htm_img($newroot ) .", confirm=".$_REQUEST["confirm"] . "<br><br>");

//$oldroot = "A53";
//$newroot = "---";
if(strlen($oldroot)==0) die(" oldroot is empty.");
if(strlen($newroot)==0) die(" newroot is empty.");


$harr = new MysqlHieroglyphics();



$sql = "SELECT hid, hink FROM Hieroglyphics WHERE hink LIKE '%$oldroot,%'";
$myarr = $harr->query( $sql );


foreach( $myarr as $row ){
   $hid = $row['hid'];
   print( MysqlHieroglyphics::htm_img($hid )); 
   print("<a>==</a>");
   
   $orglnk = $row['hink'];
   print( MysqlHieroglyphics::htm_img($orglnk )); 
   print("<br>");
   
   $newlnk = MysqlHieroglyphics::replace_root_of_links($oldroot, $newroot, $orglnk); //preg_replace("/$oldroot/i", $newroot, $orglnk);
   print(($newlnk."<br>"));
   print( MysqlHieroglyphics::htm_img($hid )); 
   print("<a>==</a>");
   print(MysqlHieroglyphics::htm_img($newlnk));
   
   print("<br>");
   if( isset($_REQUEST["confirm"]) && $_REQUEST["confirm"]=="on") {
      $sql = "UPDATE Hieroglyphics SET hink='$newlnk' WHERE hink='$orglnk'";
      print("<a>$sql</a><br>");
      $myarr = $harr->execute( $sql );
   }
   else{
      print("confirm is not set to 1. no db changes.<br>");
   }
   
   print("<br><br><br>");
}

print("<br>");
$_REQUEST["oldroot"]=null;
$_REQUEST["newroot"]=null;

$_REQUEST["confirm"]=null;
//print_r($myarr);

?>

 
</body>
</html>