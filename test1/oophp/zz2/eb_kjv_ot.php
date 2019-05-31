<?php
require_once("./uti/EnglishWordsStatistic.php");

$ccs = new EnglishWordsStatistic(array("./books/ebible/kjv_ot.txt"));
//$ccs = new EnglishWordsStatistic(array("./ana/word_freq_kjv_ot.txt"));
//$ccs->run();
//$ccs->display();
$ccs->view(__FILE__);


?>
