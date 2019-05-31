<?php
require_once("MysqlBase.php");
require_once("MysqlJiaguwen.php");
require_once("Ureaddir.php");




//mysql> show columns from Jiaguwen;
//+-------+--------------+------+-----+---------+-------+
//| Field | Type         | Null | Key | Default | Extra |
//+-------+--------------+------+-----+---------+-------+
//| idx   | int(11)      | NO   | PRI | NULL    |       |
//| jid   | int(11)      | YES  |     | NULL    |       |
//| zid   | int(11)      | YES  |     | NULL    |       |
//| freq  | int(11)      | YES  |     | NULL    |       |
//| hid   | int(11)      | YES  |     | NULL    |       |
//| rid   | int(11)      | YES  |     | NULL    |       |
//| jink  | varchar(100) | YES  |     | NULL    |       |
//| pyn   | varchar(50)  | YES  |     | NULL    |       |
//| eng   | varchar(50)  | YES  |     | NULL    |       |
//| descr | varchar(120) | YES  |     | NULL    |       |
//+-------+--------------+------+-----+---------+-------+
class JiaguwenRootsStatistic 
{
public $TotWordsFrRoot;
public $RootTotalFreq;

public $RootsFreq; //list of all roots freq
public $RootsFriends;//
public $RootsLeaves;

public $RootsDangledFreq;//transformed roots which is never used as parents.



public function JiaguwenRootsStatistic(){
   $this->gen_RootsFreqList();
   $this->gen_RootsFriendsAndLeves();
   $this->gen_RootsDangled();
}

public function gen_RootsFreqList() {
   $this->RootTotalFreq = 0;
   $jia = new MysqlJiaguwen();
   $sql = "SELECT * FROM Jiaguwen ORDER BY jid";
   $ret = $jia->query($sql);
   
   $this->TotWordsFrRoot = 0;
   
   $this->RootsFreq = array();
   foreach ($ret as $row){
      $lnk = $row['jink'];
      if( strlen($lnk) < 3 ) continue;
      $lnkarr = preg_split( "/[,]/", $lnk );
      if( in_array( $row[1], $lnkarr ) ){
         //print_r($row);
         echo $row[1]."==>WATCH! jid is in jink:$lnk<br>";
      }
      foreach( $lnkarr as $jcod ) {
         if( strlen($jcod) < 3 ) continue;
         if( !isset( $this->RootsFreq[ $jcod ] ) ) {
            $this->RootsFreq[ $jcod ] = 0;
         }
         $this->RootsFreq[ $jcod ] ++;
         $this->RootTotalFreq++;
      }
      
      $this->TotWordsFrRoot++;
         
   }
   
   arsort($this->RootsFreq);
}

public function gen_RootsFriends_RootsLeaves_for($rootName, $rows) {
   $friends = array();   
   $words = array();

   foreach ($rows as $row){
      $lnk = $row['jink'];
      if( strlen($lnk) < 3 ) continue;
      $lnkarr = preg_split( "/[,]/", $lnk );
      if( count ($lnkarr)<2 ) continue;

      foreach( $lnkarr as $jcod ) {
         if( strlen($jcod) < 3 ) continue;
         if( $jcod == $rootName ) continue;
         if( !isset( $friends[ $jcod ] ) ) {
            $friends[ $jcod ] = 0;
         }
         $friends[ $jcod ] ++;
      }
      
      $words[ $row['jid'] ] = $row['freq'];
   }
   arsort($friends);
   $this->RootsFriends[ $rootName ] = $friends;
   
   arsort($words);
   $this->RootsLeaves[ $rootName ] = $words;
   //$this->show_friends($arr);
}
public function gen_RootsFriendsAndLeves( ) {

   $jia = new MysqlJiaguwen();
   foreach( $this->RootsFreq as $jcod => $freq) {
      $sql = "SELECT * FROM Jiaguwen WHERE jink LIKE '%$jcod%'  ORDER BY freq";
      $ret = $jia->query($sql);
      $this->gen_RootsFriends_RootsLeaves_for($jcod, $ret);  
   }
}
public function gen_RootsDangled( ) {

   $jia = new MysqlJiaguwen();
   $sql = "SELECT * FROM Jiaguwen";
   $ret = $jia->query($sql);
   foreach ($ret as $row){
      $lnk = $row['jink'];
      $lnk = trim( $lnk );
      if( strlen($lnk) >= 5 ) continue;
      if( strlen($lnk) > 0 ) {
         die("error jink data=$lnk");
      }
      $jid = $row['jid'];
      if( isset( $this->RootsFreq[ $jid ] ) ){
         continue;
      }
      $this->RootsDangledFreq[ $jid ] = $row['freq'];         
   }
}
public function gen_CrossWordCoverage( ) {

   $crossRoots=array(58515,58369,58525,60634,62629,62548,60469,63362,58650,61714,62578,62317,62231,62869,62465,60987,62254,61598,61711,62956,62592,62229,62377,62287,62255,62336,61713,58810,62613,62850,61660,62584,62632,59461,58078,58096,59804,61662
   ,61817,61101,62466,62593,58811,61592,62232,62028,63535,60370,58862,62870,62628,62643,62378,61033,62349,63055);
   
   
   $crossPict=array(59243,57571,59190,59365,60789,58760,59478,58759,59498,61867,59411);
   
   $mergedCrossRoot = array_merge( $crossRoots, $crossPict );
   $mergedCross = array();
   foreach( $mergedCrossRoot as $indx => $root) {
      $mergedCross = array_merge( $mergedCross, $this->RootsLeaves[ $root ] );
      if($root==$crossPict[0]) print("<br>----<br>");
      printf( $this->htm_img($root) );
      printf( "root=".$root );
      printf( ",count=".count($mergedCross) );
      printf( ",coverRate=%10.2f", count($mergedCross) / $this->TotWordsFrRoot);
      printf( "<br>" );
   }
}



public function htm_img($jcod) {
   $img = "<img src='../../odb/tbi/img/jgif/$jcod.gif'/>";
   return $img;
}
public function print_a_root($indx, $jcod ){
   if( strlen( $jcod ) <3  )  return;
   $freq = $this->RootsFreq[ $jcod ];
   $img = $this->htm_img( $jcod );
   printf("%s[%d](%d, %d),",
         $img,$jcod,$indx,$freq);
}


public function show_rootsfreqlist(){
   //printf("RootTotalFreq=%d<br>",$this->RootTotalFreq);
   $ii=0;
   foreach( $this->RootsFreq as $jcod => $freq ){
      $this->print_a_root($ii++, $jcod );
      continue;
   }
}




public function show_friends_Leaves_of($root){
   $idx=0;
   foreach($this->RootsFriends[ $root ] as $jcod => $freq ){
      printf("%s[%d](%d,%d)",$this->htm_img($jcod),$jcod,$idx++,$freq);
   }
   print("<br>~~~~~-----~~~~~<br>");
   $idx=0;
   foreach($this->RootsLeaves[ $root ] as $jcod => $freq ){
      printf("%s[%d](%d,%d)",$this->htm_img($jcod),$jcod,$idx++,$freq);
   }
}

public function show_friends_Leaves( ) {
   print("<br>~~~~~--show_friends_Leaves---~~~~~<br>");

   $idx=0;
   foreach( $this->RootsFreq as $jcod => $freq) {
      print("<br><font color='red'><<<$jcod>>><<<");
      $this->print_a_root($idx++, $jcod);
      print(">>>--~~~~~</font><br>");
      $this->show_friends_Leaves_of($jcod);  
   }
   
}

public function show_matrix(){
  
   print("<br>~~~~~---show_matrix--~~~~~<br>");
   foreach( $this->RootsFriends as $rootName => $friends ){
      print( $this->htm_img($rootName).":");
       $i=0;
      foreach( $friends as $jcod => $freq ) {
         print( $this->htm_img( $jcod ) );
         $i++;
         if($i>=50) break;
      }
      print("<br>");
   }
}

public function show_dangledrootlist(){
  
   print("<br>~~~~~---show_dangledrootlist--~~~~~<br>");
   foreach( $this->RootsDangledFreq as $rootName => $freq ){
      print( $this->htm_img($rootName).":[".$rootName."]frq=".$freq."\r\n");
   }
}


public function show(){
   printf("RootTotalFreq=%d, TotWordsFrRoot=%d, TotalRootsDangled=%d <br>",
   $this->RootTotalFreq, 
   $this->TotWordsFrRoot,
   count($this->RootsDangledFreq) 
   );
   
   $this->show_rootsfreqlist();
   $this->show_dangledrootlist();
   
   $this->show_friends_Leaves();
   
   $this->show_matrix();
      
   $this->displayOutput2tmp();
   
   $this->gen_CrossWordCoverage();
}




public function displayOutput2tmp(){

   $fp = fopen('/tmp/xyz.Jiaguwen_roots_statistic.txt', 'w');
   fwrite($fp, '1');
   fwrite($fp, '23');
   



   $indx=0;
   $accumulatedFreq=0;
   foreach($this->RootsFreq as $key => $freq) {
      $indx++;
      
      $accumulatedFreq += $freq;
      
      
      $RelativeFreq = 10000 * $freq /  $this->RootTotalFreq;
      $RelativeFreqTot = 10000 * $accumulatedFreq /  $this->RootTotalFreq;
      
      
      $FormatText="%03d, [%s], %s = %05d ( %5.2f, %5.2f, %5.2f, %5.2f, %d,  %3.2f==%3.2f )<br>\r\n";
      $line = sprintf($FormatText,
         $indx,
         $key,
         $key,
         $accumulatedFreq,
         $RelativeFreqTot,
         $RelativeFreq,
         0,0,0,0,0);
      
      
  
      
      echo $line;
      fwrite($fp, $line);
   }
   
   fclose($fp);
}

}//class





?>