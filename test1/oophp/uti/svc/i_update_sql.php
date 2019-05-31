<?php
session_start();

require_once("../MysqlJiaguwen.php");
require_once("../MysqlHieroglyphics.php");
//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);



if( !isset($_REQUEST["sql"   ])) die ("err: no sql");
$sql = $_REQUEST["sql"   ];
if( strlen($sql)<5) die ("err:  $sql"); 

syslog(0,"sql=: ".$sql);
//return;

$odb=null;
if( strpos ($sql, "Jiaguwen") >0){
   $odb = new MysqlJiaguwen();
   syslog(0,"MysqlJiaguwen: ".$sql);
}
else{
   $odb = new MysqlHieroglyphics();
   syslog(0,"MysqlHieroglyphics: ".$sql);
}
$ret = $odb->execute($sql);
    
if(0==$ret ) die("err ".$sql);
print "Success:".$sql ;
die("");
    
 

?>