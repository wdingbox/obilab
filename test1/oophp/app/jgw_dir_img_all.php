<!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
                <title> </title>

          
                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
                </head>
                

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
$urd->readdir2arr_RecursFiles("../../odb/tbi/mer/");//root/");
$jianod = new JiaguwenNode();
foreach( $urd->dirFolders as $dir ){
   print("<br>".$dir."<br>");
   $jianod->loadDir($dir);
   $jianod->show();
}

exit(0);


$jianod = new JiaguwenNode();
$jianod->loadDir("../uti/jgw/mer/a_base_class/eye");
$jianod->show();
//$jia->display();
//$jia->view("Books/j/g");

?>
<!-- id="clentarea"-->
</div>
</body>
</html>
