
<html>
<head>
                <title>mv 2 tmp</title>
                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <!-- Users -->
                </head>
                          
<script type="text/javascript">

$(document).ready(function(){   
   $("img").click(function(){
      var filename = $(this).attr("src");
      $(this).next().css('background-color', 'red');
         $.post("../uti/svc/jiaguwen_img_tmp_cp.php", 
                     {   
                         srcfile:  filename
                     },
                     function(data, status){
                        if(data.search("ret=1")<0){
                           alert(data);             
                        }                        
                     },
                      "datastring"
         );// post

   });
                  
});                                           
 </script>

</head>     
                
<body bgcolor="#ff9090">		

<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/JiaguwenNode.php");


$urd = new Ureaddir();
$urd->readdir2arr_RecursFiles("../../odb/tbi/mer/");
$jianod = new JiaguwenNode();
foreach( $urd->dirFolders as $dir ){
   //print("<br>".$dir."<br>");
   $jianod->loadDir($dir);
   $jianod->show();
}
?>
</body>

</html>