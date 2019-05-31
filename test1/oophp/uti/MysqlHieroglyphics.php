<?php
//======================================
//======================================
openlog("error_log", LOG_PID | LOG_PERROR, LOG_LOCAL0);
require_once("MysqlBase.php");

class MysqlHieroglyphics
{
public $Databasename;
public $Username;
public $Password;
protected $dbh;
public function MysqlHieroglyphics()
{
   $this->Databasename="mysql:dbname=Hieroglyphics;host=localhost";
   $this->Username="root";
   $this->Password="rootpass";
   //$this->Password=""; //for mysql not secured.
   
   $this->dbh=false;
}

public function connect()
{
      if($this->dbh) return $this->dbh;
   try {
       ///var/lib/mysql/otest
       $db = new PDO($this->Databasename, $this->Username, $this->Password );
       $db->setAttribute(PDO::ATTR_TIMEOUT, 5.0);
       syslog(0, "PDO connection object created<br>");
       }
   catch(PDOException $e)
       {
       echo $e->getMessage();
       die("died");
       }
       
       $this->dbh = $db;
       return $db;
}
public function query($sql)
{
   $db = $this->connect();
   $result = $db->query($sql);
        if( !$result )
        {
           $err = $db->errorInfo();
           //errLastSet($err[2]);
           //errLog(0, "Err database ".$sql, $err[2]);
           echo $err[2]."<br>";
        }
        else
        {
           $arr = array();
           while( $row = $result->fetch() ){
               $arr [] = ($row);
               //print("<br>----<br>");
           }
           return $arr;
       }
       return false;
}
//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
public function execute($sql)
{
    $db = $this->connect();
    $count = $db->exec($sql);
    
    if(0==$count) print_r($db->errorInfo());

    /*** echo the number of affected rows ***/
    return $count;
}

public function execute_array($sqls)
{
    $db = $this->connect();
    $db->beginTransaction();

    $count = 0;
    foreach( $sqls as $sql ) {
      $count += $db->exec($sql);
    }
    $db->commit();

    
    /*** echo the number of affected rows ***/
    return $count;
}


public function get_colnames()
{
   $db = $this->connect();
   $sql="SELECT * FROM `Hieroglyphics` LIMIT 1";//0:idx,1:jid,2:zid,3:freq
   $result = $db->query($sql);
        if( !$result )
        {
           $err = $db->errorInfo();
           //errLastSet($err[2]);
           //errLog(0, "Err database ".$sql, $err[2]);
           echo $err[2]."<br>";
        }
        else
        {
           $arr = array();
           while( $row = $result->fetch() ){
               $arr = $row;
               break;
               //print("<br>----<br>");
           }
           $cols = array();
           foreach($arr as $key=>$val) {
               if(is_numeric($key)) continue;
               $cols[] = $key;
           }
           return $cols;
       }
       return false;
}
public function print_js_colnames_Hia(){
   print ( "<script>var Hia=[" );
   $arr = $this->get_colnames();
   foreach ($arr as $val ){
      print("'$val',");
   }
   print("''];</script>\r\n");
}
public function getAssoc_Hid_rows()
{
   $db = $this->connect();
   $sql="SELECT * FROM `Hieroglyphics`";//0:idx,1:jid,2:zid,3:freq
   $result = $db->query($sql);
        if( !$result )
        {
           $err = $db->errorInfo();
           //errLastSet($err[2]);
           //errLog(0, "Err database ".$sql, $err[2]);
           echo $err[2]."<br>";
        }
        else
        {
           $arr = array();
           while( $row = $result->fetch() ){
               $arr [ $row['hid'] ] = $row;
               //print("<br>----<br>");
           }
           return $arr;
       }
       return false;
}



public function getAssocHidLinks()
{
   $db = $this->connect();
   $sql="SELECT * FROM `Hieroglyphics`";//0:idx,1:jid,2:zid,3:freq
   $result = $db->query($sql);
        if( !$result )
        {
           $err = $db->errorInfo();
           //errLastSet($err[2]);
           //errLog(0, "Err database ".$sql, $err[2]);
           echo $err[2]."<br>";
        }
        else
        {
           $arr = array();
           while( $row = $result->fetch() ){
               $arr [ $row['hid'] ] = $row['hink'];
               //print("<br>----<br>");
           }
           return $arr;
       }
       return false;
}



public function getRootsStatistic()
{
   $db = $this->connect();
   $sql="SELECT * FROM `Hieroglyphics`";/// WHERE hink LIKE '*,*'";  
   $result = $db->query($sql);
        if( !$result )
        {
           $err = $db->errorInfo();
           //errLastSet($err[2]);
           //errLog(0, "Err database ".$sql, $err[2]);
           echo $err[2]."<br>";
        }
        else
        {
           $RootFreqarr = array();
           while( $row = $result->fetch() ){
               $str = $row['hink'];
               $arr = preg_split("/[,]/i", $str);
               foreach( $arr as $img ){
                  $img = trim($img);
                  if(strlen($img)==0) continue;
                  if( !isset( $RootFreqarr[ $img ] ) ) {
                     $RootFreqarr[ $img ]= array("freq"=>0,"children"=>array());
                  }
                  $ar = $RootFreqarr[ $img ];
                  $ar['freq']++;
                  $ar['children'][] = $row['hid'];
                  //syslog(0, "img=$img");
                  $RootFreqarr[ $img ] = $ar;
               }
               //print("<br>----<br>");
           }
           //ksort( $RootFreqarr );
           //print_r($RootFreqarr);
           return $RootFreqarr;
       }
       return false;
}



static function imgsrc($id)
{
   //return "";
   //return "../../../odb/tbi/jgif/".$id.".gif";
   $srcfile = "../../odb/hiero/ccer-h/".$id.".gif";
   if( !file_exists($srcfile )) {
      syslog(0,"Warn! imgsrc:: src file not exit:" . $srcfile);
   }
   return $srcfile ;
}

static function htm_img($ids)
{
   $arr = preg_split("/[,]/i",$ids );
   $img="";
   foreach($arr as $id ){
      if( strlen($id) == 0 ) continue;
      $img .= "<img src='" . self::imgsrc($id) . "' ></img><a>" . $id . "</a>";
   }
   return $img;
}


static function replace_root_of_links($oldroot, $newroot, $lins)
{
   //$oldroot .= ",";
   //$newlnk = preg_replace("/$oldroot/i", $newroot, $lins);
   $arr = preg_split("/[,]/i",$lins );
   foreach($arr as $key => $id ){
      if( strlen($id) == 0 ) continue;
      if( $id == $oldroot ) {
         $arr[$key] = $newroot;
      }
   }
   
   sort($arr);
   
   $newlnstr="";
   foreach($arr as $id ){
      if( strlen($id) == 0 ) continue;
      $newlnstr .=  $id . ",";
   }
   return $newlnstr;
}



public function showimg(){
   $sql="SELECT * FROM `Jiaguwen`";//0:idx,1:jid,2:zid,3:freq
   $arr = $this->query($sql);

   $totword=0;
   
   foreach( $arr as $row ){
      printf("%d,<img src='../../odb/tbi/img/jgif/%s.gif'/>%s.gif, &#%s;[%s],%05d<br>",$row[0],$row[1],$row[1],$row[2],$row[2],$row[3]);
      //print_r($row);
      //echo "<br>";
      $totword += $row["freq"];
   }
   
}














function htm_img_jqw( $val ){
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if(strlen($bname)==0) continue;
      $fname = "../../odb/tbi/img/jgif/$bname.gif";
      $ret .= "<img src='$fname'/>$bname";
   }
   return $ret;
}
function htm_img_zid( $val ){
   $ret="&#".$val.";".$val;
   return $ret;
}
function htm_img_hid( $val ){
   $fname = "../../odb/hiero/ccer-h/$val.gif";
   $ret = "<img class='hid' src='$fname'/><a>$val</a>\r\n";
   return $ret;
}
function htm_img_links( $val ){
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if('0'==$bname || strlen($bname)==0) continue;
      $fname = "../../odb/hiero/ccer-h/$bname.gif";
      $ret .= "<img class='hink' src='$fname'/><a class='hink' >$bname</a>\r\n";
   }
   return $ret;
}
public function htm_tr( $row ){
   echo "<tr>";
   foreach($row as $key => $val ) {
      if(is_numeric($key) ) continue;
      echo "<td>";
         switch($key){
         case 'hid':
            echo $this->htm_img_hid($val);
            break;
         case 'hink':
            echo $this->htm_img_links($val);
            break;
         case 'zid':
         case 'zid1':
            echo $this->htm_img_zid($val);
         break;
         case 'hidzzz':
            echo $this->htm_img_hid($val);
         break;
         default:
         echo $val;
         }
      echo "</td>\r\n";
   }
   echo "</tr>\r\n";
}
public function show_table( $ret ){

   echo "<table border='1' bgcolor='#ffffff'>\r\n";
      echo "<tr>";
      foreach($ret[0] as $key => $val ) {
         if(is_numeric($key)) continue;
         echo "<td>";
            echo $key;
         echo "</td>\r\n";
      }
      echo "</tr>";
   foreach ($ret as $row){
      $this->htm_tr($row);
   }
   echo "</table>\r\n";
}


}//class 

//exit(0);


if(isset($_GET["test"]) && $_GET["test"]==1){
   //=================
   //usage sample
   //=================
   print("<br>======<br>");

   ///////////////////
   $db = new MysqlHieroglyphics();
   //$sql="SELECT * FROM `Jiaguwen`";
   //$ar = $db->query($sql);
   //print_r($ar);
   $db->showimg();
}//if










?>