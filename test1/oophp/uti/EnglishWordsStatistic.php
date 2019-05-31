
<?php
require_once("ChineseCharacterStatistic.php");
require_once("EnglishIrregularVerbs.php");
require_once("EnglishRegularVerbs.php");

///////////////////////////////////////////////////////////////////////////

class EnglishWordsStatistic extends ChineseCharacterStatistic
{
public $wordends;//
public $MergedWords;//
public function init2(){
   $irreg=array(
   "chr"=>"",
   "pharisees"=>"pharisee",
   "tongues"=>"tongue",
   "ordinances"=>"ordinance",
   "zelotes"=>"zelotes",
   "troubles"=>"trouble",
   "unawares"=>"unaware",
   "turtledoves"=>"turtledove",
   "estates"=>"estate",
   "pleasures"=>"pleasure",
   "bundles"=>"bundle",
   "magistrates"=>"magistrate",
   "lives"=>"lives",
   "captives"=>"captive",
   "women"=>"woman",
   "women"=>"woman",
   "women"=>"woman",
   "women"=>"woman",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man",
   "men"=>"man"
   );
   asort($irreg);
   $this->Ignores = $irreg;
   $this->TotalWords = 0;
}

public function del_s($words, &$bChanged)
{
   $bChanged = false;
   $word = $words;
      $pattern = "/[^aeisu]s$/i";
      if( preg_match($pattern, $words)>0 ){
         $pattern = "/s$/i";
         $word = preg_replace($pattern, '', $words);
         
         $this->Ignores[$words] = $word;
         $bChanged = true;
      }
      else if( preg_match("/ies$/i", $words)>0 )
      {
         $word = preg_replace("/ies$/i", 'y', $words);
         $this->Ignores[$words] = $word;
         $bChanged = true;
      }
      return $word;
}


public function wordends($word)
{
   $this->wordends[]=$word;
}

public function show_wordends(){
   foreach ( $this->wordends as $i => $str ){
      $this->wordends[$i] = strrev($str);
   }
   sort( $this->wordends );
   echo "<div align='right'>";
   foreach ( $this->wordends as $i => $str ){
      $nf = "-------".strrev($str) ;
      //$nf = substr($nf, strlen($nf)-30);
      //echo "<p aglin='right'>" . strrev($str) . "</p>";
      $norm = strrev($str);
      $norm = $this->dels($norm);
      
      echo "<p aglin='right'>" .$i.") ". strrev($str) ."===". $norm. "</p>";

   }
   echo "</div>";
}

public function load2freq_old( $filename )
{
   $this->init2();
   
   $data = file_get_contents( $filename );
   if( false == $data ){
      print("failed5 to read file:" . $filename );
      die();
   }
   //$pattern = "/src=[\"']?([^\"']?.*(png|jpTotalWordsg|gif))[\"']?/i";
   $pattern = "/[0-9]+[\s]+[A-Za-z']+[\s]*/i"; //^:start of line; \s:space; $:end line; +:>=1;
   $tot = preg_match_all($pattern, $data, $out);
   //print_r($out[0]);

   foreach ($out[0] as $str) 
   {
       $dat = preg_split("/[\s]+/", $str);

 
       $freq = $dat[0];      
       $word = $dat[1];
       
       $word = str_replace("'s", "", $word);
       
       //
       $s = substr($word,-1);//get last char;
       if( "s"== $s ){
         $this->wordends($word);
         $word = $this->dels($word);
       }
       
       //
       if ( array_key_exists($word, $this->Ignores) ){
         $word = $this->Ignores[$word];
       }

       if( strlen($word)==0 ) {
         echo $str ." == bad process<br>";
         continue;
       
       }
       
       if( !isset($this->WordFreqArr[$word])) {
         $this->WordFreqArr[$word] = array("sort"=>0,"afreq"=>0,"arank"=>0,"rfreq"=>0,"rrank"=>0);
       }

       $arr = $this->WordFreqArr[$word];
       $arr["afreq"] += $freq ;
       $arr["arank"] = 0 ;
       $arr["sort"] = $arr["afreq"];
       
       $this->WordFreqArr[$word]=$arr;
       $this->TotalWords += $freq;
   }
   
   //test
   //$this->show_wordends();
}


public function load2freq( $filename )
{
   $this->init2();
   $IrregVerb = new EnglishIrregularVerbs();
   $RegVerb = new EnglishRegularVerbs();
   
   $data = file_get_contents( $filename );
   if( false == $data ){
      print("failed6 to read file:" . $filename );
      die();
   }
   
   //$data = str_replace("'s ", " ", $data);
   $data = strtolower ( $data );   
   $data = preg_replace("/([a-z]+[0-9]+[:][0-9]+[\s])/i", " ", $data); //del verse name.
   $data = preg_replace("/[a-z]['][s][\s]/i", " ", $data); //del  ---'s .
   //$data = preg_replace("/[:'\"\?\.,=+()_[]{}|\\\/~`!@#\$%^&\*<>]/i", " ", $data); //del  ---'s .
   $data = preg_replace("/[^a-z]/i", " ", $data); //del symbols . ^:not letters. 


   
   
   //$pattern = "/src=[\"']?([^\"']?.*(png|jpTotalWordsg|gif))[\"']?/i";
   //$pattern = "/[0-9]+[\s]+[A-Za-z']+[\s]*/i"; //^:start of line; \s:space; $:end line; +:>=1;
   //$tot = preg_match_all("/[\s]+/", $data, $out);
   //print_r($out[0]);

   $out = preg_split("/[\s]+/", $data); //space
   foreach ($out as $idx=>$str) 
   {
      $str = trim ($str);
      if( strlen($str)==0 ) continue;
       //
       $word = $str;
       $bChanged = false;
       $s = substr($str,-1);//get last char;
       if( "s"== $s ){
         $this->wordends($str);
         $word = $this->del_s($str, $bChanged);
       }
       if( !$bChanged ){
         $word = $IrregVerb->getBaseForm( $str , $bChanged);
       }
       if( !$bChanged ){
         $word = $RegVerb->getBaseForm( $str , $bChanged);
       }
       if( !$bChanged ){
          //iiregular noun plural, verb tense.
          if ( array_key_exists($word, $this->Ignores) ){
            $word = $this->Ignores[$word];
          }
       }

       //ignored words
       if( strlen($word)==0 ) {
         echo count($out).",".$idx.$str ." == bad word process<br>";
         continue;
       }
       
       if( !isset($this->WordFreqArr[$word])) {
         $this->WordFreqArr[$word] = array("sort"=>0,"afreq"=>0,"arank"=>0,"rfreq"=>0,"rrank"=>0);
       }

       $arr = $this->WordFreqArr[$word];
       $arr["afreq"] += 1 ;
       $arr["arank"] = 0 ;
       $arr["sort"] = $arr["afreq"];
       
       $this->WordFreqArr[$word]=$arr;
       $this->TotalWords += 1;
   }
   
   
   //$IrregVerb->show_FoundUsed();
   $this->Ignores = array_merge( $this->Ignores, $IrregVerb->ChangedVerbs);
   $this->Ignores = array_merge( $this->Ignores, $RegVerb->ChangedVerbs);

}



}//class 



//$ccs = new ChineseCharacterStatistic(array("../books/cb_nt.htm"));
//$ccs->run();
//$ccs->display();

?>
