<?php
@session_start();

require_once("../MysqlJiaguwen.php");

if( !isset($_REQUEST["pars"])) {
   echo "die:";
   die ("no pars");
   }



$pars = $_REQUEST["pars"];

//////////////////////////////////////////////
print_r($_REQUEST);
$jgw = new MysqlJiaguwen();
$jgw->udpate_item($pars);


?>