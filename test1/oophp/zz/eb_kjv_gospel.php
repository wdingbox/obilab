<?php
require_once("./uti/EnglishWordsStatistic.php");


$ccs = new EnglishWordsStatistic(array("./books/ebible/kjv_gospel.txt"));
//$ccs = new EnglishWordsStatistic(array("./ana/word_freq_kjv_gospel.txt"));
//$ccs->run();
//$ccs->display();
$ccs->view(__FILE__);


?>
