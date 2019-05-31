<html>
<head>
                <title> </title>

          
                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
</head>
<body bgcolor="<?php echo '#eeeeee'; ?>">		
<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>
<?php
require_once("../uti/Ureaddir.php");

require_once("../uti/JiaguwenStatistic.php");



$jia = new JiaguwenStatistic();

  

  
  
  
$jia->show();
//$jia->display();
//$jia->view("Books/j/g");

?>
</body>
</html>
