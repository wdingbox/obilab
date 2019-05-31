<?php
require_once("./uti/ChineseCharacterStatistic.php");

$ccs = new ChineseCharacterStatistic(
   array("./books/xiyouji__.clean1.htm",
   "./books/xiyouji__.clean2.htm"));
//$ccs->run();
//$ccs->display();
$ccs->view(__FILE__);

exit(0);

?>
