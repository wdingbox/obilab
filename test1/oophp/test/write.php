<?php
require_once("../uti/cc.php");

   $fname = "/tmp/a.txt";
   syslog(0, $fname);
   
   $pf = fopen($fname, "w");
   fwrite($pf,"aaa", 3 );
   fclose($pf);
      
      
?>