<?php
require_once("MysqlJiaguwen.php");
require_once("ChineseCharacterStatistic.php");



class JiaguwenStatistic extends ChineseCharacterStatistic
{

public $jgw;
public $sta;
public $Totword;
public function JiaguwenStatistic(){
   //$this->load();
}
public function load(){

   $jjj = new MysqlJiaguwen();
      
   $sql="SELECT * FROM `Jiaguwen`";
   $this->jgw = $jjj->query($sql);
   return $this;
}

public function load2freq( $filename )
{
   $this->TotalWords=0;
   foreach ($this->jgw  as $row) 
   {
      $str = "<img src='../../odb/tbi/img/jgif/".$row[1] . ".gif' width='30' height='30'/>".$row[1]."-&#".$row[2] . ";".$row[2];
       if( !isset($this->WordFreqArr[$str])) {
         $this->WordFreqArr[$str] = array("sort"=>0,"afreq"=>0,"arank"=>0,"rfreq"=>0,"rrank"=>0);
       }
       //if( !isset($this->WordFreqArr[$str]["frq"])) $this->WordFreqArr[$str]["frq"] = 0;
       $arr = array();
       $arr["afreq"] = $row["freq"];
       $arr["arank"] = 0 ;
       $arr["sort"] = $arr["afreq"];
       
       $this->WordFreqArr[$str]=$arr;
       $this->TotalWords+=$row["freq"];
   }
}


public function TotWord(){

   $this->Totword=0;
   foreach( $this->jgw as $row )
   {
      $this->Totword += $row["freq"];
   }
   return $this;
}
public function ran(){

   $totword=0;
   foreach( $this->jgw as $row )
   {
      printf("%d,<img src='../../odb/tbi/jgif/%s.gif'/>%s.gif, &#%s;[%s],%05d<br>",$row[0],$row[1],$row[1],$row[2],$row[2],$row["freq"]);
      //print_r($row);
      //echo "<br>";
      $totword += $row["freq"];
   }
   return $this;
}
public function show()
{
   $this->load();
   $this->load2freq("--");
   arsort($this->WordFreqArr);//,SORT_NUMERIC);
  
   $this->rank();
   
   $this->display();
   return;
   
   $totword=0;
   foreach( $this->jgw as $row )
   {
      printf("%d,<img src='../../odb/tbi/jgif/%s.gif'/>%s.gif, &#%s;[%s],%05d<br>",$row[0],$row[1],$row[1],$row[2],$row[2],$row[3]);
      //print_r($row);
      //echo "<br>";
      $totword += $row["freq"];
   }
}

}






if(0){
   $rv = new JiaguwenStatistic(array(""));
   $rv->run();
   $rv->display();
   



}


?>