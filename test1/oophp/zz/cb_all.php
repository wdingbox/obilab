
<?php


$data = file_get_contents("cb_nt.htm");
//$pattern = "/src=[\"']?([^\"']?.*(png|jpg|gif))[\"']?/i";
$pattern = "/&#[0-9]*;/i";
$tot=preg_match_all($pattern, $data, $out);
//print_r($out[0]);



$GrammarSigns=array (
"&#65292;",
"&#12290;",
"&#65306;",
"&#65292;",
"&#65281;",
"&#12289;",
"&#65307;",
"&#12299;",
"&#12298;",
"&#12310;",
"&#12311;",
"&#65311;",
"&#45;");


$WordCount=0;
$arr = array();
foreach ($out[0] as $str) 
{
    //if(in_array($str, $GrammarSigns)) continue; 
    $arr[$str]++;
    $WordCount++;
}
arsort($arr,SORT_NUMERIC);
//print count($arr);

$AccumulatedUsage=0;
$AccumulatedUsagePercent=0;
$i=0;
foreach ($arr as $key=>$val)
{
    $AccumulatedUsage+=$val;
    $AccumulatedUsagePercent = ($AccumulatedUsage / $WordCount) * 100;
    print($i . ")  ". substr($key,2,5). " ". $key." = ".$val. "    (".$AccumulatedUsagePercent. ")</br>\n");
    $i++;
}

//print_r($arr);




print("WordCount=".$WordCount);
?>
