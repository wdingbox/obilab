<?php
session_start();

require_once("../MysqlJiaguwen.php");
require_once("../MysqlHieroglyphics.php");
//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);



if( !isset($_REQUEST["db"   ])) die ("err: no db");
if( !isset($_REQUEST["sc"   ])) die ("err: no sc");
if( !isset($_REQUEST["op"   ])) die ("err: no op");

//if( !isset($_REQUEST["ff"   ])) die ("err: no ff");
if( !isset($_REQUEST["setid"   ])) die ("err: no setid");
if( !isset($_REQUEST["where"   ])) die ("err: no where");



$op=$_REQUEST["op"];//+ or -
$sc=$_REQUEST["sc"];//selected col name
$db=$_REQUEST["db"];//database name
$ff=$_REQUEST["ff"];
$vi=$_REQUEST["vi"];
$fi=$_REQUEST["fi"];

$uval  = $_REQUEST["setid"   ];
$keyId = $_REQUEST["where"   ];




$sql="";
if( "Jiaguwen" == $db ) {

    $sql="SELECT * FROM Jiaguwen WHERE jid='$keyId'";//0:idx,1:hid,2:zid,3:freq
    
    syslog(0, "sql=".$sql);
    
    //die("err test");

    $odb = new MysqlJiaguwen();
    $ret = $odb->query($sql);
    if( count($ret)!=1 ) die ("err query:".$sql); 

    $row = $ret[0];
    
    $dbstr = "row | ";
    foreach ($row as $key => $val ){
      if( is_numeric( $key ) )continue;
      $dbstr .= $key . "=" . $val . " | ";
    }
    syslog(0, $dbstr);

    if( !isset($row[ $sc]) ) $row[ $sc]="";// die ("err row[ $sc ] not set.");
    $Oldval = $row[ $sc ];//selected col name
    
    $colnames = $odb->get_colnames();
    $sc = $colnames[$sc];
    
    //$Oldval = $row[ $sc ];

    $sql_undo = "UPDATE Jiaguwen SET $sc='$Oldval' WHERE jid='$keyId'";
    $_SESSION["sql_undo"] = $sql_undo;
    $_SESSION["database"] = $db;
    
    syslog(0, "prepare for undo:".$sql_undo);

    if( "+" == $op ) {
      $newVal = MysqlUti::merge_str_links($Oldval,$uval);
    }
    else if ("-"==$op ){
      $newVal = MysqlUti::remove_str_links($Oldval, $uval);
    }
    else{
      die("err op=$op");
    }
    if( $newVal == $Oldval) die ("err new==old same");
    
    $sql = "UPDATE Jiaguwen SET $sc='$newVal' WHERE jid='$keyId'";
    
    $type_of_str_link = MysqlUti::type_of_str_links($newVal);
    if( "err"==$type_of_str_link ){
      syslog(0, "err type of str jink:".$sql);
      die("err mixed type for update");
    }
   
 
    


    syslog(0, "to run sql:".$sql);
    $ret = $odb->execute($sql);
    
    if(0==$ret ) die("err ".$sql);
    print $sql ;
    die("");
}

else if( "Hieroglyphics" == $db ) {

    $sql="SELECT * FROM Hieroglyphics WHERE hid='$keyId'";
    
    syslog(0, "sql=".$sql);
    
    //die("err test");

    $odb = new MysqlHieroglyphics();
    $ret = $odb->query($sql);
    if( count($ret)!=1 ) die ("err query:".$sql); 

    $row = $ret[0];
    
    $dbstr = "row | ";
    foreach ($row as $key => $val ){
      syslog(0, "Hieroglyphics prepare for undo:".$key."=".$val);
      if( is_numeric( $key ) )continue;
      $dbstr .= $key . "=" . $val . " | ";
    }
    syslog(0, $dbstr);

    if( !isset($row[ $sc]) ) $row[ $sc]="";//die ("err row[ $sc ] not set.");
    $Oldval = $row[ $sc ];//selected col name
    
    $colnames = $odb->get_colnames();
    $sc = $colnames[$sc];
    
    //$Oldval = $row[ $sc ];

    $sql_undo = "UPDATE Hieroglyphics SET $sc='$Oldval' WHERE hid='$keyId'";
    $_SESSION["sql_undo"] = $sql_undo;
    $_SESSION["database"] = $db;
    
    syslog(0, "Hieroglyphics prepare for undo:".$sql_undo);

    if( "+" == $op ) {
      $newVal = MysqlUti::merge_str_links($Oldval,$uval);
    }
    else if ("-"==$op ){
      $newVal = MysqlUti::remove_str_links($Oldval, $uval);
    }
    else{
      die("err op=$op");
    }
    if( $newVal == $Oldval) die ("err new==old same");
    
    $sql = "UPDATE Hieroglyphics SET $sc='$newVal' WHERE hid='$keyId'";
    
    $type_of_str_link = MysqlUti::type_of_str_links($newVal);
    if( "err"==$type_of_str_link ){
      syslog(0, "err type of str jink:".$sql);
      die("err mixed type for update");
    }
   
 
    


    syslog(0, "to run sql:".$sql);
    $ret = $odb->execute($sql);
    
    if(0==$ret ) die("err ".$sql);
    print $sql ;
    die("");
}
else{
   die("err wrong db=".$db);
}

?>