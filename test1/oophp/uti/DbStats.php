<?php

require_once("Ureaddir.php");
require_once("MysqlHieroglyphics.php");

require_once("MysqlJiaguwen.php");
require_once("DbRow2Htm.php");










class DbStats 
{
public function img2childrenlist0($idimg){
   $r2htm = new DbRow2Htm();


   //get grp members;
   $mbary=array();
   $mbary[]=$idimg;
   if(is_numeric($idimg)){
      $sql = "SELECT jid FROM Jiaguwen WHERE jink LIKE '$idimg,'";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      echo "member count=". count($ret) . ",sql=$sql; <br>";

      foreach($ret as $key=>$row){
         $mbary[]=$row[0];
      }
   }
   else{
      die("err sql=$sql, idimg=$idimg" );
   }


   //print members
   $sql = "SELECT jid FROM Jiaguwen WHERE ";//jink LIKE '%$idimg,%,%'";
   $sql.="  jink LIKE '$idimg,%,'"; //start with among at least two data.
   $sql.=" || jink LIKE '%,$idimg,%'";//2nd and more.
   echo "<table>";
   foreach($mbary as $val){
      echo $r2htm->htm_divaimg($val);  
      $sql.=" || jink LIKE '$val,%,'"; //start with among at least two data.
      $sql.=" || jink LIKE '%,$val,%'";//2nd and more.
   }
   echo "</table>";
   $ret = $db->query($sql);
   echo "Tot count=". count($ret);// . ",sql=$sql; <br>";
   echo "<table>";
   foreach($ret as $row){
      echo $r2htm->htm_divaimg($row[0]);  
   }
   echo "</table>";
   echo "<br>sql=$sql; <br>";
}

public function img2childrenlist($idimg){
   $r2htm = new DbRow2Htm();


   //get grp members;
   $mbary=array();
   $mbary[]=$idimg;
   if(is_numeric($idimg)){
      $sql = "SELECT jid FROM Jiaguwen WHERE jink LIKE '$idimg,'";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      echo "member count=". count($ret) . ",sql=$sql; <br>";

      foreach($ret as $key=>$row){
         $mbary[]=$row[0];
      }
   }
   else{
      die("err sql=$sql, idimg=$idimg" );
   }


   //print members
   
   
   $counter=0;
   foreach($mbary as $idex=>$val){

      $sql = "SELECT jid FROM Jiaguwen WHERE ";//jink LIKE '%$idimg,%,%'";
      $sql.="  jink LIKE '$val,%,'"; //start with among at least two data.
      $sql.=" || jink LIKE '%,$val,%'";//2nd and more.
      $ret = $db->query($sql);
      echo "<table border='1'>";
      echo "<tr><td>i=".$idex."<br>(".count($ret) .")";
      echo $r2htm->htm_divaimg($val);  
      echo "</td><td>";
      foreach($ret as $key=>$row) {
         echo $r2htm->htm_divaimg($row[0]);  
         $counter++;
      }
      echo "</td></tr>";
      echo "</table>";
   }
   echo "<br>tot counter=$counter; <br>";
}




public function jink_uniq_tbler_2s(){
      //two or more items in jink.
      $sql = "SELECT jink FROM Jiaguwen WHERE jink LIKE '_____,_%'";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      echo "Tot compound word count=". count($ret) . ",sql=$sql; ,";

      $jidarr = array();
      foreach($ret as $key=>$row){
         $jink = $row[0];
         $arr1 = preg_split("/[,]/i",$jink);
         $jidarr = array_merge($jidarr,$arr1);
      }
      $jidarr = array_unique ($jidarr);
      arsort($jidarr);
      
      ////////print
      $r2htm = new DbRow2Htm();
      echo "jidUniqCount=".count($jidarr)."<br>";
      $SizedJids = array();
      foreach($jidarr as $key=>$jid) {
         $sql = "SELECT jink FROM Jiaguwen WHERE jid='$jid'";
         $ret = $db->query($sql);
         if($ret==null){
            //echo "err jid=$jid<br>";
            $SizedJids [0][]=$jid;
            continue;
         }
         
         $jink2 = $ret[0][0];
         $jink2arr = preg_split("/[,]/i",$jink2);
         $jinkcount = count($jink2arr);
         
         if($jinkcount==null) $jinkcount=0;
         $SizedJids [$jinkcount][] = $jid;
         
         
         //echo $r2htm->htm_divaimg($jid);  
      }
      
      foreach($SizedJids as $indx => $arr){
         echo "<table border='1'><tr><td>i=".$indx.",c=".count($arr)."</td></tr> <tr><td>";
         foreach($arr as $jid) {
            echo $r2htm->htm_divaimg($jid);  
         }
         echo "</td></tr></table>";
      }
}

public function get_layer4_symbolic($xc){
      $sql = "SELECT jid FROM Jiaguwen WHERE L='4' AND xa='x' AND xb='0'  AND xc='$xc'";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      //echo "Tot compound word count=". count($ret) . ",sql=$sql; ,";
      
      $r2htm = new DbRow2Htm();
      foreach($ret as $row){
         echo $r2htm->htm_divaimg($row[0]); 
         echo "\n";
         
      }
}
public function get_layer4_hand($xc){
      $sql = "SELECT jid FROM Jiaguwen WHERE L='4' AND xa='x' AND xb='h'  AND xc='$xc'";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      //echo "Tot compound word count=". count($ret) . ",sql=$sql; ,";
      
      $r2htm = new DbRow2Htm();
      foreach($ret as $row){
         echo $r2htm->htm_divaimg($row[0]); 
         echo "\n";
         
      }
}
public function get_layer4_son($xc){
      $sql = "SELECT jid FROM Jiaguwen WHERE L='4' AND xa='x' AND xb='z'  AND xc='$xc'";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      //echo "Tot compound word count=". count($ret) . ",sql=$sql; ,";
      
      $r2htm = new DbRow2Htm();
      foreach($ret as $row){
         echo $r2htm->htm_divaimg($row[0]); 
         echo "\n";
         
      }
}

public function get_layer4_shen($xc){
      $sql = "SELECT jid FROM Jiaguwen WHERE L='4' AND xa='x' AND xb='y'";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      //echo "Tot compound word count=". count($ret) . ",sql=$sql; ,";
      
      $r2htm = new DbRow2Htm();
      foreach($ret as $row){
         echo $r2htm->htm_divaimg($row[0]); 
         echo "\n";
         
      }
}

public function get_layer4_wood($xc){
      $sql = "SELECT jid FROM Jiaguwen WHERE L='4' AND xa='x' AND xb='w'  AND xc='$xc'";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      //echo "Tot compound word count=". count($ret) . ",sql=$sql; ,";
      
      $r2htm = new DbRow2Htm();
      foreach($ret as $row){
         echo $r2htm->htm_divaimg($row[0]); 
         echo "\n";
         
      }
}


public function get_layer4_center($xc){
      $sql = "SELECT jid FROM Jiaguwen WHERE L='4' AND xa='x' AND xb='c'  ";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      //echo "Tot compound word count=". count($ret) . ",sql=$sql; ,";
      
      $r2htm = new DbRow2Htm();
      foreach($ret as $row){
         echo $r2htm->htm_divaimg($row[0]); 
         echo "\n";
         
      }
}





public function get_layer4_T($xb){
      $sql = "SELECT jid FROM Jiaguwen WHERE L='4' AND xa='T' AND xb='$xb'  ";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      //echo "Tot compound word count=". count($ret) . ",sql=$sql; ,";
      
      $r2htm = new DbRow2Htm();
      foreach($ret as $row){
         echo $r2htm->htm_divaimg($row[0]); 
         echo "\n";
         
      }
}



public function echo_count_of_layer4(){
      $sql = "SELECT COUNT(*) FROM Jiaguwen WHERE L='4'";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      print($ret[0][0]);
}
public function echo_count_of_layer5(){
      $sql = "SELECT COUNT(*) FROM Jiaguwen WHERE L='5'";
      $db = new MysqlJiaguwen();
      $ret = $db->query($sql);
      print($ret[0][0]);
}



}


?>