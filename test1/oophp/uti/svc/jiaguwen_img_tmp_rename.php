<?php
$YOUR_PATH="/tmp";
//print_r(posix_getpwuid(getmyuid())); 
//print_r(pathinfo($YOUR_PATH)); 

print_r($_REQUEST);
print("<br>--<br>");

//print_r($_REQUEST);
$srcfile =$_REQUEST["srcfile"];

$imgfile = basename ( $srcfile );
$destfile = "/tmp/_".$imgfile;

$ret = rename( $srcfile, $destfile );
echo "ret=".$ret;



$cmd = 'mv -X "/tmp/z.txt" "/tmp/z2.txt"'; 
exec($cmd, $output, $return_val); 

if ($return_val == 0) { 
   echo "success"; 
} else { 
   echo "failed"; 
} 
$fname='/tmp/ztest2.html';
$fh = fopen($fname, 'a');
fwrite($fh, '<h1>Hello world!</h1>');
fclose($fh);
$fname='/tmp/ztest.html';
$fh = fopen($fname, 'a');
fwrite($fh, '<h1>Hello world!</h1>');
fclose($fh);

$ret = unlink($fname);
echo $ret;
$ret = unlink("/tmp/z.txt");
echo $ret;


?>