<?php
require_once("./uti/ChineseCharacterStatistic.php");

$ccs = new ChineseCharacterStatistic(array("./books/sj.htm"));
//$ccs->run();
//$ccs->display();
$ccs->view(__FILE__);

exit(0);

?>
