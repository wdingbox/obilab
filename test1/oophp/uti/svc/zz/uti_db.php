<?php

require_once("../MysqlHieroglyphics.php");
class uti_db{

   static function merge_str_links($str1, $str2){
      $arr1 = array();
      $arr1 = preg_split("/[,]/i",$str1);
      
      $arr2 = array();
      $arr2 = preg_split("/[,]/i",$str2);
      
      $arrIn = array_merge ($arr1, $arr2);

      $arr = array_unique($arrIn);
      sort($arr);
      
      $str="";
      foreach( $arr as $val){
         if($val==0) continue;
         if( strlen($val) == 0 ) continue;
         $str .+= $val + ",";
      }
      return $str;
   }

}

if( !isset($_REQUEST["jid"])) die ("err: no hid");

$hid =$_REQUEST["jid"];
syslog(0,"hid=".$hid);
if(strlen( $hid ) ==0) die (" err: hid is empty");

if( !isset($_REQUEST["roots"])) die ("err: no roots");
$roots =$_REQUEST["roots"];

syslog(0,"to add roots=".$roots);
if(strlen( $roots ) ==0) die (" err: roots is empty");

$arrIn=array();
$arrIn = preg_split("/[,]/i",$roots);

$arrIn = array_unique($arrIn);
sort($arrIn);

if(count($arrIn)==0) die("err no input");





   $jgw = new MysqlHieroglyphics();
   

   $sql="SELECT hink FROM Hieroglyphics WHERE hid='$hid'";
   $ret = $jgw->query($sql);

   //print_r($ret);
   $linksRead = "";
   if( isset($ret[0])){
      $linksRead = ( $ret[0]["hink"] );
      //$linksRead = ltrim($linksRead,",");
   }
   else{
      print("err: no ret");
   }

   if(strlen($linksRead)>0){
   
      $arrRead = preg_split("/[,]/i",$linksRead);
      $arrIn = array_merge ($arrIn, $arrRead);
   }
  
   
   $arr = array_unique($arrIn);
   sort($arr);
   
   $linkjidcodes="";
   foreach( $arr as $val){
      $val = trim($val);
      if( strlen( $val ) == 0) continue;
      $linkjidcodes .= $val . ",";
   }
   //$linkjidcodes = ltrim($linkjidcodes,",");
   //$linkjidcodes = trim ( $linkjidcodes) ;
   if(strlen( $linkjidcodes) ==0 ) die ("err: input roots is null");
   
   
   
   
   
   $sql="UPDATE Hieroglyphics SET hink='$linkjidcodes' WHERE hid='$hid'";//0:idx,1:hid,2:zid,3:freq
   
   syslog(0,$sql);
   
   $ret = $jgw->execute($sql);
   
   //if( !$ret) die("err: $sql");
   
   //print_r( $result );
   
   printf("ret=%d; hid=%s; updatedlinkjidcodes=%s; ",$ret, $hid, $linkjidcodes);
   
   print_r($_REQUEST);
?>