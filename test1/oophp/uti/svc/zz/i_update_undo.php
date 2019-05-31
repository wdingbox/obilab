<?php
session_start();

require_once("../MysqlJiaguwen.php");
require_once("../MysqlHieroglyphics.php");
//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);
if( isset($_SESSION["database"]) && isset($_SESSION["sql_undo"]) ){
   $odb=null;
   if("Jiaguwen"==$_SESSION["database"] ){
      $odb = new MysqlJiaguwen();
   }
   else if("Hieroglyphics"==$_SESSION["database"] ){
      $odb = new MysqlHieroglyphics();
   }
   else{
      print_r($_SESSION);
      die( "err _SESSION[database] ");
   }
   syslog(0, "undo::" .  $_SESSION["sql_undo"] );
   $ret = $odb->execute( $_SESSION["sql_undo"] );

   die ("ok undo,ret=$ret, sql=".$_SESSION["sql_undo"]);
}
echo "err undo";
print_r( $_SESSION );


?>