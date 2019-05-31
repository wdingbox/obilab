<?php


$fname=$_REQUEST["fname"];
$Data=$_REQUEST["Data"];


if(file_exists($fname)){    
    rename($fname,"$fname.".time());
};
$ret=file_put_contents($fname,$Data);

echo "file_put_contents ret=$ret<hr/>";
print_r($_REQUEST);


?>