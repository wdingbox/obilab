<?php
session_start();

require_once("Hid2jids.php");
require_once("../DbRow2Htm.php");
require_once("../MysqlJiaguwen.php");
require_once("../MysqlHieroglyphics.php");
//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);
if( !isset($_REQUEST["keyval"   ])) die ("err: no keyval");



//$db=$_REQUEST["db"];
$keyval=$_REQUEST["keyval"];
$db = "Hieroglyphics";
if( strlen($keyval)==5 && is_numeric($keyval)){
   $db = "Jiaguwen";
}


$row=array();
$sql="";
if( "Jiaguwen" == $db ) {

    $sql="SELECT * FROM Jiaguwen WHERE jid='$keyval'";
 
    syslog(0, "in sql=".$sql);
    
    //die("err test");

    $odb = new MysqlJiaguwen();
    $ret = $odb->query($sql);
    if( count($ret)!=1 ) die ("err query:".$sql); 

    $row = $ret[0];
}
else if( "Hieroglyphics" == $db ) {
   $sql="SELECT * FROM Hieroglyphics WHERE hid='$keyval'";//0:idx,1:hid,2:zid,3:freq
 
   syslog(0, "q sql=".$sql);
    
   $jia = new MysqlHieroglyphics();
   $ret = $jia->query($sql);
   if( count($ret)!=1 ) die ("err query:".$sql); 
   $row = $ret[0];
   //$jia->show_table( $ret );
   
   //make up the htoj value.
   $h2j = new Hid2jids();
   $row['htoj'] = $h2j->get_htoj_str_of($keyval);
}
else{
   die ("err dbname=".$db );
}

//////////////////////////////////
   $srow = new DbRow2Htm();
   $srow->htm_table($row );
   exit(1);

?>