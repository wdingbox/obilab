<?php
$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
$sql = "SELECT * FROM Jiaguwen";
$sql = "SELECT jnm, jid FROM Jiaguwen  WHERE jnm<>'0' AND jnm <>'-' AND jnm<>'' ORDER BY jnm";
if( isset($_REQUEST["sql"]) && strlen($_REQUEST["sql"])>0 ){
   $sql = $_REQUEST["sql"];
}
else{
   print_r($_REQUEST);
   die( "no data for sql");
}
function get_new_contents_if_not_exist($filename,$line){
    $lines=file($filename);
    $contents="";
    for($i=0;$i<count($lines);$i++){
        $ln=trim($lines[$i]);
        if(strlen($ln)===0) continue;
        if($ln===$line) {
            echo "In file:$filename <br>\n";
            die( "Line Already Exist: $line");     
        }
        $contents.=$ln."\r\n";
    }  
    $contents.=$line."\r\n";
    return $contents;    
}


$contents=get_new_contents_if_not_exist("db_view_selectoptions.tpl",$sql);
$contents=get_new_contents_if_not_exist("db_view_selectoptions2.tpl",$sql);

$filename="db_view_selectoptions_History.tpl";
$contents=get_new_contents_if_not_exist($filename,$sql);
$ret=file_put_contents($filename, $contents);
echo $contents;
echo "saved ret:$ret, $filename";

?>
