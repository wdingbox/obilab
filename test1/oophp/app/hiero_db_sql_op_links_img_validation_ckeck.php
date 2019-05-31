<!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlHieroglyphics.php");





$harr = new MysqlHieroglyphics();



$sql = "SELECT hid, hink FROM Hieroglyphics";
$myarr = $harr->query( $sql );


foreach( $myarr as $row ){
   $hid = $row['hid'];
   $orglnk = $row['hink'];
   $arr = preg_split("/[,]/i",$orglnk);
   foreach($arr as $img) {
      if(strlen($img)==0) continue;
      $srcfile = MysqlHieroglyphics::imgsrc($img);
      if( file_exists( $srcfile )) continue;
      print( $srcfile ."<br>" );
   }
}
print("<br>end====<br>");

//print_r($myarr);

?>