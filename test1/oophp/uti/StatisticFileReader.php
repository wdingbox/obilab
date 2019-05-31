<?php

//UniqueWords=2973, totwords=83899, avfrq=28.22, avRfrq= 0.03, RankMax=201<br>
//idx, ccode, Char  = Freq, (CRF,WRF, RRK)<br>
//000, [and], and = 05669 (  6.76,  6.76, 100.00, 1 )<br>
//001, [the], the = 04743 ( 12.41,  5.65, 99.50, 2 )<br>
//002, [of], of = 02320 ( 15.18,  2.77, 99.00, 3 )<br>
//003, [he], he = 01936 ( 17.48,  2.31, 98.51, 4 )<br>

class StatisticFileReader
{
public $statistic;
public $rfrqs;
public $words;
public function load( $file )
{
   $data = file_get_contents( $file );
   //echo $data;
   //////////////////////////////////

   $pattern = "/,[\s][A-Za-z0-9]+[\s]=[\s\([0-9\.]+,/i";
   $pattern = "/[\r\n][0-9]+,[\s]\[[A-Za-z0-9]+\],[^\)]+[\)]/i";
   
   if( preg_match_all($pattern,$data,$out) ==0 ) ;
   
   //print_r($out);
   foreach($out[0] as $str)
   {
      $str = trim( $str );
      $this->statistic[] = $str;
      $ar = preg_split("/[,=\s\[\]\(]+/i",$str);
      //print_r($ar);
      //echo "<br>";
      $arr = array();
      $this->words [] = $ar[1];//word cod
      $this->rfrqs [] = $ar[5];//ralative freq.
   }
   return ;
}
public function test(){
   foreach($this->words as $idx=>$word)
   {
      print( $word."=".$this->rfrqs[$idx] ."<br>");
      
   }
}

}



class StatisticMatch
{
public $war1;
public $war2;
public $pairs;
public $MatchRange;
public $MatchMaxIndex;
public $MatchRate;

   public function __construct(  )
  {
    $this->MatchRange = 30;
    $this->MatchMaxIndex = 600;
  }
public function match2($war1,$war2)
{
   $iMax = count( $war2 );
   foreach($war1 as $indx => $word1 )
   {
      if($indx > $this->MatchMaxIndex )  break;
      //if( $war2[$indx] == $word1 ) continue;
      $bMatched = false;
      foreach( $war2 as $jndx => $ward2 )
      {
         //if( $indx == $jndx) continue;
         if( $word1 == $ward2 ){
            $this->pairs[] = array($indx, $jndx);
            $bMatched = true;
            break;
         }
      }
      if( false==$bMatched ) {
         $this->pairs[] = array($indx, $iMax);
      }
      
   }
   
   $this->calcMatchRate();
}

public function IsMatch($ii)
{
   if( $ii > $this->MatchMaxIndex ) return false;
   $Pair = $this->pairs[$ii];
   return $this->IsMatchedPair($Pair) ;
}
public function IsMatchedPair($Pair)
{
   return abs( $Pair[0]- $Pair[1] ) < $this->MatchRange ? true:false;
}
public function calcMatchRate()
{
   
   $MatchCount=0;
   foreach($this->pairs as $indx => $pair )
   {
      if( $indx > $this->MatchMaxIndex ) break;
      if( $this->IsMatchedPair($pair) )
      {
         $MatchCount++;
      }
   }
   
   $this->MatchRate = 100 * $MatchCount /  ( $this->MatchMaxIndex  );
   syslog(0, "this->MatchRate ==".$this->MatchRate);
}

}




class StatisticCompare
{
public $sfr0;
public $sfr1;
public $match;
public function compare($file0,$file1)
{

   $this->sfr0 = new StatisticFileReader();
   $this->sfr0->load("/tmp/$file0");

   $this->sfr1 = new StatisticFileReader();
   $this->sfr1->load("/tmp/$file1");

   $this->match = new StatisticMatch();
   $this->match->match2($this->sfr0->words, $this->sfr1->words);
}
public function show($hlink)
{
   $iMax  = count( $this->sfr0->statistic );
   $iMin  = count( $this->sfr1->statistic );
   if( $iMax < $iMin ) {
      $iMax = $iMin; 
      $iMin = count($this->sfr0->statistic);
   }
   $matched0 = array();
   $matched1 = array();
   for( $ii=0; $ii < $iMax ; $ii++)
   {
      $matched0[$ii] = 0;
      $matched1[$ii] = 0;
   }
   for( $ii=0; $ii < $iMin ; $ii++)
   {
      if( $this->match->IsMatch($ii) ) 
      {
         //print "*****";
         $matched0[$ii]=1;
         $k = $this->match->pairs[$ii][1];
         $matched1[$k] = 1;
      }
      else {
         //print ("- - - -");
         //$matched[]=0;
      }
      
      //print($this->sfr0->statistic[$ii]."===".$this->sfr1->statistic[$ii] . "<br>");
   }
   
   printf("matchRate=%5.3f<br>",$this->match->MatchRate);
   /////////////////////////////////////////
   print("<table>");
   for( $ii=0; $ii < $iMin ; $ii++)
   {
      print("<tr><td ");
      
      if( $matched0[$ii] ) 
      {
         print ("BGCOLOR='#00ff00'");
      }
      print (">");
      
      $keyword = $this->sfr0->words[$ii];
      print ("<a href='$hlink?key=$keyword'>");
    
      print( $this->sfr0->statistic[$ii] );
      print("</a></td><td ");
      if( $matched1[$ii] ) 
      {
         print "BGCOLOR='#00ff00'";
      }
      print (">");
      
      $keyword = $this->sfr1->words[$ii];
      print ("<a href='$hlink?key=$keyword'>");
      
      print( $this->sfr1->statistic[$ii] );
      
      print( "</a></td></tr>\r\n" );
   }
   print("</table>");
   
   
   

}
public function compareKeyword($keyword)
{
   $idx0=0;
   $idx1=0;
   foreach( $this->sfr0->words as $indx => $word )
   {
      if( $keyword == $word )
      {
         $idx0 = $indx;
         break;
      }
   }
   foreach( $this->sfr1->words as $indx => $word )
   {
      if( $keyword == $word )
      {
         $idx1 = $indx;
         break;
      }
   }
   $pairs = array();
   $pairs[] = array($idx0, $idx1);
   $pairs[] = array($idx0+1, $idx1-1);
   $pairs[] = array($idx0-1, $idx1+1);
   return $pairs;
}

}



?>