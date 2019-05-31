<!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
                <title>jh map editor</title>

                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
                </head>
                

</head>     
 <style type="text/css">
img { 

height:30px;
width: 30px;
}
.h { 

height:20px;
width: 20px;
}
img.magified { 
height:190px;
width: 190px;
}
a { 
font-size: 5px;

}
a.norm { 
font-size: 12px;

}
</style>   
 


<body bgcolor="#eeaaee">		
<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>


<?php

require_once("../uti/Ureaddir.php");
require_once("../uti/JiaguwenNode.php");


$urd = new Ureaddir();
$urd->readdir2arr_RecursFiles("../../odb/tbi/mer/");//root/");
$jianod = new JiaguwenNode();
foreach( $urd->dirFolders as $dir ){
   print("<br>".$dir."<br>");
   $jianod->loadDir($dir);
   $jianod->show_table();
}

//exit(0);


//$jianod = new JiaguwenNode();
//$jianod->loadDir("../uti/jgw/mer/a_base_class/eye");
//$jianod->show();
//$jia->display();
//$jia->view("Books/j/g");

?>


</body>
</html>
