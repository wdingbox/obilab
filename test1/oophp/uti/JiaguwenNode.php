<?php
require_once("MysqlJiaguwen.php");
require_once("Ureaddir.php");


// merged similar words in one folder to form one word.
class JiaguwenNode 
{

public $jgw;

public $Totword;
public $cat;
public $dir;
public function JiaguwenNode(){
   $this->loadDB();
}
private function loadDB(){

   $jjj = new MysqlJiaguwen();
   $this->jgw = $jjj->getAssocList(1);
   return $this;
}
private function getJid($ImgFile){
   $arr = preg_split("/\./i", $ImgFile);
   return $arr[0];
}
//non-recursive
public function loadDir( $dir )
{
   $ud = new Ureaddir( );
   $arr = $ud->readdir2arr( $dir );
   $this->loadFilesArr( $arr[1] );//1:file array
   $this->dir = $dir;
   
   $this->Calc();
   
   arsort($this->cat);
}
private function loadFilesArr( $filearr )
{
   $this->cat = array();
   foreach( $filearr as $file )//file list
   {
      $jid = $this->getJid($file);
      
      if( !isset ( $this->jgw[$jid] ) ) continue;
      $row = $this->jgw[$jid];
      
      $arr = array();
      $arr["sort"]=$row["freq"];
      $arr["row"] = $row;
      $this->cat[] = $arr;
   }
}

private function Calc(){

   $this->Totword=0;
   foreach( $this->cat as $arr )
   {
      $row = $arr["row"];
      $this->Totword += $row["freq"];
   }
   return $this;
}






public function show()
{
   printf("<br><FONT COLOR='ff0000'>%s (tot Frq=%d, Rfq=%10.2f, n=%d)</FONT><br>\r\n",
   $this->dir, $this->Totword,$this->Totword/5678, count($this->cat));
   
   foreach( $this->cat as $arr )
   {
      $row = $arr["row"];
      printf("<img src='%s/%s.gif' width='35' height='35'/><a>[%s]",$this->dir,$row[1],$row[1]);
      printf("&#%s;[%s]",$row['zid1'],$row['zid1']);
      printf("(%d, %d)",$row['idx'],  $row['freq']);
      printf("</a>\r\n");
   }
}


public function sortByJID_show()
{
   printf("<br><FONT COLOR='ff0000'>%s (tot Frq=%d, Rfq=%10.2f, n=%d)</FONT><br>\r\n",
   $this->dir, $this->Totword,$this->Totword/5678, count($this->cat));
   
   $arr=array();
   foreach( $this->cat as $item )
   {
      $item["sort"] = $item["row"][1]; 
      $arr[] = $item;
   }
   sort( $arr );
   
   $this->cat = array();
   $this->cat = $arr;
   
   $this->show();
   
}











////

function htm_img_jqw( $val ){
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if(strlen($bname)==0) continue;
      $fname = "../../odb/tbi/img/jgif/$bname.gif";
      $ret .= "<img src='$fname'/><a>$bname</a>";
   }
   return $ret;
}
function htm_img_zid( $val ){
   $ret="&#".$val.";"."<a>".$val."</a>";
   return $ret;
}
function htm_img_hid( $val ){
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if('0'==$bname || strlen($bname)==0) continue;
      $fname = "../../odb/hiero/ccer-h/$bname.gif";
      $ret .= "<img class='g' src='$fname'/><a>$bname</a>";
   }
   //for($i=0; $i<1;$i++) $ret.="<img class='h'/><a>@</a>";
   return $ret;
}
function htm_img_hink( $val ){
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if('0'==$bname || strlen($bname)==0) continue;
      $fname = "../../odb/hiero/ccer-h/$bname.gif";
      $ret .= "<img class='h' src='$fname'/><a>$bname</a>";
   }
   for($i=0; $i<1;$i++) $ret.="<img class='h'/><a>@</a>";
   return $ret;
}

function htm_tr($row) {
   echo "<tr>";
      foreach($row as $key => $val ) {
         if(is_numeric($key) ) continue;
         echo "<td><div>";
            switch($key){
            case 'jid':
            case 'jink':
               echo $this->htm_img_jqw($val);
               break;
            case 'zid':
            case 'zid1':
               echo $this->htm_img_zid($val);
            break;
            case 'jmn':
               echo $this->htm_img_hid($val);
            break;
            case 'jtoh':
               echo $this->htm_img_hink($val);
            break;
            default:
            echo $val;
            }
         echo "</div></td>";
      }
      echo "</tr>\r\n";
}
function htm_tr_title($row){
   echo "<tr>";
   foreach($row as $key => $val ) {
      if(is_numeric($key)) continue;
      echo "<td>";
         echo $key;
      echo "</td>";
   }
   echo "</tr>\r\n";
}
public function show_table()
{
   printf("<br><FONT COLOR='ff0000'>%s (tot Frq=%d, Rfq=%10.2f, n=%d)</FONT><br>\r\n",
   $this->dir, $this->Totword,$this->Totword/5678, count($this->cat));
   
   print("<table border='1'>\r\n");
   $this->htm_tr_title($this->cat[0]["row"]);
   foreach( $this->cat as $arr )
   {
      $row = $arr["row"];
      $this->htm_tr( $row );
      //printf("<img src='%s/%s.gif' width='35' height='35'/><a>[%s]",$this->dir,$row[1],$row[1]);
      //printf("&#%s;[%s]",$row[2],$row[2]);
      //printf("(%d, %d)",$row[0],  $row[3]);
      //printf("</a>\r\n");
   }
   print("</table>\r\n");
}


}//class







?>