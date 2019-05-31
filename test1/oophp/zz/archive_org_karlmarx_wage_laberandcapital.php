<?php
require_once("./uti/EnglishWordsStatistic.php");


$ccs = new EnglishWordsStatistic(array("./books/archive_org_karlmarx_wage_laberandcapital.txt"));
//$ccs = new EnglishWordsStatistic(array("./ana/word_freq_kjv_gospel.txt"));
//$ccs->run();
//$ccs->display();
$ccs->view(__FILE__);


?>
