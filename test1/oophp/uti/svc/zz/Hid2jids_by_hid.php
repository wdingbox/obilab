<?php
@session_start();
require_once("Hid2jids.php");
//require_once("../MysqlJiaguwen.php");
//require_once("../MysqlHieroglyphics.php");
//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);

if(!isset($_REQUEST["hid"])){
   die("no 'hid' value");
}
echo "hid=". $_REQUEST["hid"] . ";htoj=";

$h2j = new Hid2jids();
echo $h2j->get_htoj_str_of($_REQUEST["hid"]);


?>