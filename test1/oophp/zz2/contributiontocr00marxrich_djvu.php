<?php
require_once("./uti/EnglishWordsStatistic.php");


$ccs = new EnglishWordsStatistic(array("./books/contributiontocr00marxrich_djvu.txt"));
//$ccs = new EnglishWordsStatistic(array("./ana/word_freq_kjv_gospel.txt"));
//$ccs->run();
//$ccs->display();
$ccs->view(__FILE__);


?>
