<?php
require_once("../uti/Ureaddir.php");



$ur = new Ureaddir();
$files = $ur->readdir2arr("./");

foreach( $files[1] as $file){
   print("<a href='$file'>$file</a><br>\r\n");
}


?>
