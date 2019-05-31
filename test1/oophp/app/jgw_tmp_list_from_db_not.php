
<html>
<head>
                <title>img fr db</title>

          
                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>

                <!-- Users -->
                </head>
 <style type="text/css">
img { 

height:30px;
width: 30px;
}
</style>   

                
<script type="text/javascript">
var oid=57345;
$(document).ready(function(){   


$("img").click(function(){
   var imgfile = $(this).attr( "src" );
   
   if( $(this).next().css('background-color') != "#99ff99" ){
      $(this).next().css('background-color', '#99ff99');
   }
   else{
      $(this).next().css('background-color', 'white');
   }
   //alert(imgfile);
   //var arr = imgfile.split("/");
   //var jid = arr[ arr.length-1].split(".")[0]
   //alert( jid );
   jQuery.cookie( "jid", imgfile);
   //alert(  jQuery.cookie( "jid") );
	  
});
   
   
         
});//$(document).ready(function(){                                            
 </script>
 
<body>



<?php
require_once("../uti/Ureaddir.php");

require_once("../uti/MysqlJiaguwen.php");

$againstDir = "../uti/jgw/mer/compound/p/";
$againstDir = "../../odb/tbi/img/jgif/";

$ur = new Ureaddir();
$ur->readdir2arr_RecursFiles($againstDir);

$jia = new MysqlJiaguwen();
$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
$ret = $jia->query($sql);
foreach ($ret as $row){
   foreach( $ur->dirFiles as $key => $file){
      if( substr_count($file, $row[1])>0 ) {
         unset( $ur->dirFiles[ $key ] );
      }
   }
}


$blank=array(208,328,390,419,439,446,496);



$idx=5682;
$indx=0;
$sqls=array();
foreach( $ur->dirFiles as $key => $fle) {
   $indx++;
   print($indx."<img src='$fle' /><a>$fle</a>=");
   $jid = substr( $fle, -9,5);
   print($jid);
   
   print("===>");
   

   if($indx >1 && $indx< 513 ){
      if( in_array($indx,$blank) ){
         print($indx."<img src='$fle' /><font color='red'><a>$fle</a></font>=<br>");
         continue;
      }
      $idx++;
      $sql = "INSERT Jiaguwen (idx, jid,zid,freq) VALUES ($idx, $jid, 30000,1 )";
      $sqls[] = $sql;
      print($sql);
   }
   print("<BR>\r\n");
}

//$jdb = new MysqlJiaguwen();
//$jdb->execute_array($sqls);

?>


</body>
</html>