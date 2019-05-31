
<html>
<head>
                <title> </title>

          
                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

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
 
<body bgcolor="<?php echo '#eeeeee'; ?>">		
<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>



<?php
require_once("../uti/Ureaddir.php");

require_once("../uti/MysqlJiaguwen.php");
require_once("../uti/JiaguwenRootsStatistic.php");


$jr = new JiaguwenRootsStatistic();
//$jr->CollectRoot();
$jr->show();

//$jr->get_list_linked();

//$jr->show_matrix();
?>


</body>
</html>