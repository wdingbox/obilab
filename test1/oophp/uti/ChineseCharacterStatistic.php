
<?php

require_once("MapChineseGbEnglishWord.php");



class ChineseCharacterStatistic
{
public $FilenamesArr;//array
public $Ignores;//array
public $TotalWords;
public $WordsCountGtr1;//word count for freq is greater than 1.
public $RankMax;//word count for freq is greater than 1.
public $WordFreqArr;
public $Index90;
public $FirstItemOfArr;

public function ChineseCharacterStatistic( $fnameArr )
{
   $Signs = array (
   "&#32896;",
   "&#20994;",
   "&#33401;",
   "&#65292;",
   "&#65281;",
   "&#12289;",
   "&#65307;",
   "&#12299;",
   "&#12298;",
   "&#12310;",
   "&#12311;",
   "&#65311;",
   "&#65288;",
   "&#65289;",
   "&#12308;",
   "&#58002;",
   "&#57384;",
   "&#57958;",
   "&#58130;",
   "&#57962;",
   "&#58221;",
   "&#57927;",
   "&#57552;",
   "&#57586;",
   "&#58237;",
   "&#57550;",
   "&#58333;",
   "&#58023;",
   "&#58337;",
   "&#57365;",
   "&#57848;",
   "&#58523;",
   "&#58413;",
   "&#58474;",
   "&#58044;",
   "&#59339;",
   "&#58047;",
   "&#58426;",
   "&#58225;",
   "&#57466;",
   "&#12355;",
   "&#12385;",
   "&#65321;",
   "&#57671;",
   "&#65312;",
   "&#12394;",
   "&#58286;",
   "&#57565;",
   "&#39267;",
   "&#58206;",
   "&#57953;",
   "&#57462;",
   "&#57952;",
   "&#57461;",
   "&#57469;",
   "&#57483;",
   "&#57372;",
   "&#57751;",
   "&#57398;",
   "&#58222;",
   "&#57457;",
   "&#59308;",
   "&#57666;",
   "&#57948;",
   "&#58427;",
   "&#58137;",
   "&#57558;",
   "&#12449;",
   "&#58032;",
   "&#58038;",
   "&#65332;",
   "&#57720;",
   "&#45;",
   "&#45;",
   "&#45;",
   "&#45;",
   "&#45;",
   "&#45;",
   "&#45;",
   "&#45;",
   "&#45;",
   "&#45;"
   );
   
   sort($Signs);
   $this->Ignores  = array_unique ( $Signs );
   
   foreach( $fnameArr as $fname ){
      if( is_dir( $fname ) ) continue;
      $this->filenameArr[] = $fname;
   }
   $this->Index90 = 1;

}

public function load2freq( $filename )
{
   $data = file_get_contents( $filename );
   if( false == $data ){
      print("failed3 to read file:" . $filename );
      die();
   }
   //$pattern = "/src=[\"']?([^\"']?.*(png|jpTotalWordsg|gif))[\"']?/i";
   $pattern = "/&#[0-9]{5};/i";
   $tot=preg_match_all($pattern, $data, $out);
   //print_r($out[0]);

   foreach ($out[0] as $str) 
   {
       if( in_array($str, $this->Ignores) ) continue; 
       else{
         $cod = substr($str,2,5);
         $codNum = intval($cod);
         if($codNum < 12600 || $codNum > 57000  ){
            $this->Ignores[]=$str;
            continue;
         }
       }
       
       
       if( !isset($this->WordFreqArr[$str])) {
         $this->WordFreqArr[$str] = array("sort"=>0,"afreq"=>0,"arank"=>0,"rfreq"=>0,"rrank"=>0);
       }
       //if( !isset($this->WordFreqArr[$str]["frq"])) $this->WordFreqArr[$str]["frq"] = 0;
       $arr = $this->WordFreqArr[$str];
       $arr["afreq"] ++ ;
       $arr["arank"] = 0 ;
       $arr["sort"] = $arr["afreq"];
       
       $this->WordFreqArr[$str]=$arr;
       $this->TotalWords++;
   }
}
public function rank()
{

   //calc the absolute rank based on absolution freq.
   $i=1;
   $this->RankMax=0;
   $aFreqOld=-1;
   
   $AccumulatedFreq=0;
   $AccumulatedFreqPercent=0;
 
   syslog(0,"** TotalWord=".$this->TotalWords);
   foreach ($this->WordFreqArr as $key => $arr) 
   {
      if( $arr["afreq"] != $aFreqOld )
      {
         $this->RankMax++;
         $aFreqOld = $arr["afreq"];
      }
      $arr["arank"]=$this->RankMax; 
      $this->WordFreqArr[$key] = $arr;
      
      //calc index90 when accumulated usage rate reach 90%.
      $AccumulatedFreq += $arr["afreq"];
      //syslog(0,"AccumulatedFreq=".$AccumulatedFreq);
      $AccumulatedFreqPercent = ( $AccumulatedFreq / $this->TotalWords);
      //syslog(0, $AccumulatedFreqPercent ."=". $AccumulatedFreq . "/". $this->TotalWords);
      if( $AccumulatedFreqPercent < 0.900 ){
         $this->Index90 = $i;
      }
      $i++;
   }
   
}
public function getFirstItemOfArray( $arr ){
   foreach($arr as  $val) {
         return $val;
   }
   return NULL;
}
public function run()
{
   foreach( $this->filenameArr as $fname )
   {
      $this->load2freq($fname);
      print($fname."<br>\r\n");
   }

   
   arsort($this->WordFreqArr);//,SORT_NUMERIC);
  
   $this->rank();
   
}

function display()
{
   
   //date_default_timezone_set('UTC');
   // Prints something like: Monday 8th of August 2005 03:12:46 PM
   echo date('Y-m-d h:i:s');
   echo "<br>\r\n";

   $AccumulatedUsage=0;
   $AccumulatedUsagePercent=0;
   $UniqueWords = count( $this->WordFreqArr );
   $WordFreqAverage =  $this->TotalWords / $UniqueWords;
   $WRFAvg = 100*$WordFreqAverage / $this->TotalWords;
   
   $FirstItem = $this->getFirstItemOfArray( $this->WordFreqArr );
   $FirstItem["rf"] = 10000*$FirstItem["afreq"] / $this->TotalWords; //relative freq
   
   $i=0;

   $txt = "[U=%d, T=%d, Rx=%d, I90=%5.2f, avfrq=%5.2f, avRfrq=%5.2f] <br>\r\n";
   printf($txt, $UniqueWords, $this->TotalWords, $this->RankMax, $this->Index90, $WordFreqAverage,$WRFAvg);
  
   print("idx, ccode, Char  = Freq, (CRF,WRF,RFR, RRK)<br>\r\n");
   foreach ( $this->WordFreqArr as $key=>$arr )
   {
       $val = $arr["afreq"]; //absolute freq.
       $AccumulatedUsage += $val; //
       $AccumulatedUsagePercent = (100 * $AccumulatedUsage / $this->TotalWords); //accumulated rate.
       $RF = 10000*$val / $this->TotalWords; //Relative Freq
              
       $RFR = 100 - (100 * $i / ($this->Index90) );//
       
       ////////////////////////
       $A=0;
       $B=0;
       if($i>0 && $FirstItem["rf"] && $RF && $i){
         $A = 10000*($FirstItem["rf"] - $RF ) / $FirstItem["rf"] / $RF / $i;
         $B = 10000*( $i * $RF - $FirstItem["rf"] ) /$FirstItem["rf"] / $RF / $i;
       }
       
       $RelativeRank = 100*($this->RankMax - $arr["arank"]+1) / ($this->RankMax );//ralative Rank
       
       $ss = str_replace(array('&','#',';'), '', $key) ;//trim associated key.
       
       $txt="%03d, [%s], %s = %05d ( %5.2f, %5.2f, %5.2f, %5.2f, %d,  %3.2f==%3.2f )<br>\r\n";
       printf($txt, $i,$ss,$key, $val, $AccumulatedUsagePercent, $RF, 
       $RelativeRank,
       $RFR,
       $arr["arank"],
       $A,
       $B
       
       );
       
       $i++;
   }
   
   
   
   
   
   
   
   
  if(!isset($this->Ignores)) return;
  print("\r\n<br>Ingores<BR>\r\n");
  asort($this->Ignores);
  foreach($this->Ignores as $key=>$val )
  {
      $ss = str_replace(array('&','#',';'), '', $val) ;
      if( is_numeric  ($key) )
         printf("%03d => [%s]=%s <br>\r\n",$key, $ss, $val);
      else
         printf("%s =>[%s]=%s <br>\r\n",$key, $ss, $val);
  }
}
public function view($out){


   $fname = ChineseCharacterStatistic::BookDir2outfile($out, true);
 
   if( !file_exists($fname)){
      ob_start();   
      
      $this->run();
      $this->display();
      $content = ob_get_contents();
      
      ob_end_clean();
      
            
      syslog(0, "creating out new result:". $fname);
      
      $pf = fopen($fname, "w");
      fwrite($pf,$content, strlen($content));
      fclose($pf);
   }
   
   $data = file_get_contents( $fname );
   print($data);
}
public function get_view_content($out){


   $fname = ChineseCharacterStatistic::BookDir2outfile($out, true);
 
   if( !file_exists($fname)){
      ob_start();   
      
      $this->run();
      $this->display();
      $content = ob_get_contents();
      
      ob_end_clean();
      
            
      syslog(0, "creating out new result:". $fname);
      
      $pf = fopen($fname, "w");
      fwrite($pf,$content, strlen($content));
      fclose($pf);
   }
   
   $data = file_get_contents( $fname );
   return ($data);
}
public static function BookDir2outfile($dir, $yes){
   if($yes)
   {
      $fname = preg_replace("/\//", '~', $dir);
      $fname = "/tmp/xyz_".$fname.".htm";
   }
   else{
      $fname = preg_replace("/.htm/", '', $dir);
      $fname = preg_replace("/xyz_/", '', $fname);
      $fname = preg_replace("/~/", '/', $fname);
   }
   return $fname;
}

public static function FindStatisticFromData( $data, $keyword)
{

   //////////////////////////////////
   $pattern = "/\[U=[0-9][^\]]+\]/i";
   $Info="[]";
   if( preg_match($pattern,$data,$out)  ) {
        //$keyword = $map[$keyword];
        //preg_match($pattern,$data,$out);
        $Info = $out[0];
   }
   

   //////////////////////////////////
   $map=array("23376","son","a111","man");
   //syslog(0,"keyword:" . $keyword  );
   $pattern = "/[\r\n][0-9]+,[\s]\[".$keyword."\],[^\)]+[\)]/i";
   
   if( preg_match($pattern,$data,$out) ==0 ) {
        //$keyword = $map[$keyword];
        //preg_match($pattern,$data,$out);
   }
   return $out[0].$Info;
}

//bookdir: "./books/c/bbe"
public static function FindStatisticFromFile( $bookdir, $keyword)
{
   if( !isset($keyword)) return "";
   $pathfilename = ChineseCharacterStatistic::BookDir2outfile($bookdir, true);
   syslog(0, $bookdir.$keyword);
   if( !file_exists($pathfilename) ) return $keyword;
   //return $pathfilename . $keyword;
   $data = file_get_contents( $pathfilename );
         if( false == $data ){
            syslog(0,"failed to read file:" . $pathfilename );
         }
   $bChinese = ChineseCharacterStatistic::IsChaninese($bookdir) ;
   $map = new MapChineseGbEnglishWord();
   $keyword = $map->getChineseGB($keyword, $bChinese);
   //ChineseCharacterStatistic::LanguageTranslate($bookdir, $keyword);
   $out = ChineseCharacterStatistic::FindStatisticFromData($data,$keyword);
   return $out;
}

public static function IsChaninese( $bookdir )
{
   if( preg_match("/books[\/~]c[\/~]/i", $bookdir)>0 ) return true;
   return false;;
} 
}//class

















?>
