<?php
require_once("../uti/ChineseCharacterStatistic.php");
require_once("../uti/EnglishWordsStatistic.php");
require_once("../uti/Ureaddir.php");

require_once("../uti/MysqlJiaguwen.php");

$BOOKDIR = $_GET["book"];

if( isset( $_GET["fu"] ) ){
   $out = ChineseCharacterStatistic::BookDir2outfile( $BOOKDIR,true );
   unlink( $out );
}

syslog(0,$BOOKDIR);

$ud = new Ureaddir();

$arr = $ud->readdir2arr_RecursFiles($BOOKDIR);

$ccs = null;
if( ChineseCharacterStatistic::IsChaninese($BOOKDIR) )  //preg_match("/books\/(c)/i",$BOOKDIR)>0 )
{
   syslog(0,$BOOKDIR);
   $ccs = new ChineseCharacterStatistic($arr);
}
else{
   $ccs = new EnglishWordsStatistic($arr);
}
$ccs->run();
//$ccs->display();
print $ccs->get_view_content( $BOOKDIR );//reload if already exist to save time.



   print "<br>Uniq Chinese from book:<br>";
   $chinesezid =array();
  foreach($ccs->WordFreqArr as $key=>$arr )
  {
      $chinesezid[] = substr($key,2,5);
  }
   sort($chinesezid);
   print "<br>Tot simplified words in book=" . count($chinesezid);
  foreach($chinesezid as $zid )
  {
      //print "&#".$zid. ";" . $zid;
  }
  

  
  print "<br>Available simplified Chinese from Jiaguwen zid1:<br>";
  
  $jdb = new MysqlJiaguwen();
  $sql = "SELECT zid1 FROM Jiaguwen GROUP BY zid1";
  $ret = $jdb->query($sql);
  $jcarr=array();
  foreach($ret as $row){
   //echo "&#".$row[0] . ";" .$row[0];
   $jcarr [] = $row[0];
  }
  sort($jcarr);
  print "<br>Tot Jgw=" . count($jcarr);
  print "<br>";
  foreach($jcarr as $zid){
      print "&#".$zid. ";" . $zid;
  }
  
  
  
  
  
  //find chinese not in jiaguwen
  $in = array();
  $no = array();
  foreach($chinesezid as $zid )
  {
      if( in_array($zid, $jcarr )) {
         $in[] = $zid;
      }
      else{
         $no[] = $zid;
      }
  }
  
  print "<br>Jgw used in book:".count($in)."<br>";
  foreach($in as $val){
   echo "&#".$val . ";";
  }
  print "<br>Words Used in book but not found in Jqw:".count($no)."<br>";
  foreach($no as $val){
   echo "&#".$val . ";";
  }
  
  
print "<br>END";
exit(0);

?>
