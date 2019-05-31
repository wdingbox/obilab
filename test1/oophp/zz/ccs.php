
<?php

class ChineseCharacterStatistic
{
public $FilenamesArr;//array
public $SymbolsArr;//array
public $TotalWords;
public $WordsCountGtr1;//word count for freq is greater than 1.
public $WordFreqArr;

public function ChineseCharacterStatistic( $fnameArr )
{
   $Signs = array (
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
   $this->SymbolsArr  = $Signs;
   $this->filenameArr = $fnameArr;
}

function load2freq( $filename )
{
   $data = file_get_contents( $filename );
   //$pattern = "/src=[\"']?([^\"']?.*(png|jpTotalWordsg|gif))[\"']?/i";
   $pattern = "/&#[0-9]{5};/i";
   $tot=preg_match_all($pattern, $data, $out);
   //print_r($out[0]);

   foreach ($out[0] as $str) 
   {
       if( in_array($str, $this->SymbolsArr) ) continue; 
       if( !isset($this->WordFreqArr[$str])) $this->WordFreqArr[$str] = array();
       if( !isset($this->WordFreqArr[$str]["frq"])) $this->WordFreqArr[$str]["frq"] = 0;
       
       $this->WordFreqArr[$str]["frq"]++;
       $this->TotalWords++;
   }
}
public function run()
{
   foreach( $this->filenameArr as $fname )
   {
      $this->load2freq($fname);
      print($fname."aa<br>");
   }

   
   arsort($this->WordFreqArr,SORT_NUMERIC);
   
   $i=0;
   foreach ($this->WordFreqArr as $frq) 
   {
      $i++;
       if( 1 == intval ($frq) ) {
         $this->WordsCountGtr1 = $i;
         break;
       }
   }
   
}


function display()
{
   $AccumulatedUsage=0;
   $AccumulatedUsagePercent=0;
   $WordCount = count( $this->WordFreqArr );
   $WordFreqAverage =  $this->TotalWords / $WordCount;
   $WRFAvg = $WordFreqAverage / $this->TotalWords;
   $i=0;

   $txt = "totwords=%d, avfre=%5.2f, %5.2f<br>\n";
   printf($txt, $this->TotalWords,$WordFreqAverage,$WRFAvg);
  
   print("idx, ccode, Char  = Freq, (CRF,WRF, RRK)<br>");
   foreach ( $this->WordFreqArr as $key=>$val )
   {
       $AccumulatedUsage+=$val;
       $AccumulatedUsagePercent = (100 * $AccumulatedUsage / $this->TotalWords);
       $UsageRate = 100*$val / $this->TotalWords;
       $RelativeRank = 100*($WordCount-$i) / $WordCount;
       
       $txt="%03d, %s, %s = %05d ( %5.2f, %5.2f, %5.2f )<br>\n";
       printf($txt, $i,substr($key,2,5),$key, $val, $AccumulatedUsagePercent, $UsageRate, $RelativeRank);
       $i++;
   }
}

}//class

$ccs = new ChineseCharacterStatistic(array("../books/cb_nt.htm"));
$ccs->run();
$ccs->display();

?>
