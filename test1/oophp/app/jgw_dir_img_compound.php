<!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
                <title> </title>

          
                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
                </head>
                
<script type="text/javascript">

$(document).ready(function(){   
   $("img").click(function(){
      var str = $(this).attr("src");
      $(this).next().css('background-color', 'green');
      var arr = str.split("/");
      if( null == window.parent || null == window.parent.frames[0] || window.parent.frames[0].document) return; 
      if('undefine'==window.parent.frames[0]) return;
      if( null == window.parent || null == window.parent.frames[0] || window.parent.frames[0].document) return; 
      
      //alert(arr);
      $('#imgid', window.parent.frames[0].document).attr("src",str);
      $('#textoid', window.parent.frames[0].document).text( arr[ arr.length-1].split(".")[0] );
   });         
});                                           
 </script>

</head>     
                
<body bgcolor="#ffee22">
<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>


<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/JiaguwenNode.php");


$urd = new Ureaddir();
$urd->readdir2arr_RecursFiles("../../odb/tbi/mer/compound");
$jianod = new JiaguwenNode();
foreach( $urd->dirFolders as $dir ){
   //print("<br>".$dir."<br>");
   $jianod->loadDir($dir);
   $jianod->sortByJID_show();//show();
}
?>
</body>

</html>