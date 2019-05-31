<?php


//======================================
//======================================
openlog("error_log", LOG_PID | LOG_PERROR, LOG_LOCAL0);

require_once("MysqlBase.php");
class MysqlJiaguwen
{
public $Databasename;
public $Username;
public $Password;
protected $dbh;
public function MysqlJiaguwen()
{
   $this->Databasename="mysql:dbname=Jiaguwen;host=localhost";
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
   $sql="SELECT * FROM `Jiaguwen` LIMIT 1";//0:idx,1:jid,2:zid,3:freq
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
               if(strlen($key)==0) continue;
               $cols[] = $key;
           }
           return $cols;
       }
       return false;
}
public function print_js_colnames_Jia(){
   print ( "<script>var Jia=[" );
   $arr = $this->get_colnames();
   foreach ($arr as $val ){
      if(strlen($val)==0) continue;
      print("'$val',");
   }
   print("''];</script>\r\n");
}




public function getAssocList($colIdx)
{
   $db = $this->connect();
   $sql="SELECT * FROM `Jiaguwen`";//0:idx,1:jid,2:zid,3:freq
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
               $arr [ $row[$colIdx] ] = ($row);
               //print("<br>----<br>");
           }
           return $arr;
       }
       return false;
}
static function imgsrc($id)
{
   //old: "../../odb/tbi/jgif/".$id.".gif";
   return "../../../../../___bigdata/___compact/___solid/odb/tbi/jgif/".$id.".gif";
}
public function showimg(){
   $sql="SELECT * FROM `Jiaguwen`";//0:idx,1:jid,2:zid,3:freq
   $arr = $this->query($sql);

   $totword=0;
   
   foreach( $arr as $row ){
      printf("%d,<img src='../../odb/tbi/img/jgif/%s.gif'/>%s.gif, &#%s;[%s],%05d<br>",$row[0],$row[1],$row[1],$row[2],$row[2],$row["freq"]);
      //print_r($row);
      //echo "<br>";
      $totword += $row["freq"];
   }
   
}

public function append_img($params){
      
   //////////////////////////////////////////////
   print_r($_REQUEST);
   syslog(0, "params=".$params);
   echo "\n" ;
   $tok = explode(",", $params);//tabname, primarykey, primaryval, appendkey

   $tabname     = $tok[0];
   $primary_key = $tok[1];
   $primary_val = $tok[2];
   $append_key  = $tok[3];

   syslog(0,"tabname=" . tabname);
   syslog(0,"primary_key=" . $primary_key);
   syslog(0,"primary_val=" . $primary_val);
   syslog(0,"append_key=" .  $append_key);

   /////////////////////////////////////
   $jgw = new MysqlJiaguwen();
   
   
   //////////////////////////////////
   $sql0="SELECT * FROM  ttt  ORDER BY idx DESC LIMIT 1";
   //echo $sql0;
   $ret = $jgw->query($sql0);
   $append_value = basename($ret[0]["src"]);
   if( "jink"==$append_key ){
       $append_value= basename($append_value,".gif");
   }
   if( "hink"==$append_key ){
       $append_value= basename($append_value,".gif");
   }
   if( "jtoh"==$append_key ){
       $append_value= basename($append_value,".gif");
   }
   syslog(0,"append_value=" . $append_value);


   ///
   $mysql = "SELECT * FROM $tabname WHERE $primary_key='$primary_val'";
   syslog(0,"mysql=" . $mysql);
   $ret = $jgw->query($mysql);
   print_r($ret);
   $append_orig="";
   foreach ($ret as $row ) {
      $append_orig = $row[$append_key];
      break;
   }
   syslog(0,"append_orig=" . $append_orig);
   if(strlen($append_orig)>0){
      $append_orig = $append_orig.",". $append_value;
   }
   else{
      $append_orig =  $append_value;
   }
   //system("../../../oopy/mdb/PictureToday.py  $sql $img");
   //print_r ($ret);
   $append_ary = explode(",", $append_orig);
   $append_ary = array_unique( $append_ary );
   sort($append_ary);
   if( count($append_ary)>0) {
      $append_newval =implode(",",$append_ary);
      $append_newval .= ",";
   }
   
   if( substr($append_newval,0,1)=="," ) {
      $append_newval = substr($append_newval,1);
   }


   syslog(0,"append_newval=" . $append_newval);


   $mysql = "UPDATE   $tabname SET  $append_key='$append_newval' WHERE $primary_key='$primary_val'";
   syslog(0,"mysql=" . $mysql);
   $jgw->execute($mysql);
}

public function delete_img($params){
      
   //////////////////////////////////////////////
   print_r($_REQUEST);
   syslog(0, "params=".$params);
   echo "\n" ;
   $tok = explode(",", $params);//tabname, primarykey, primaryval, appendkey

   $tabname     = $tok[0];
   $primary_key = $tok[1];
   $primary_val = $tok[2];
   $append_key  = $tok[3];
   $append_val  = $tok[4];

   syslog(0,"tabname=" . tabname);
   syslog(0,"primary_key=" . $primary_key);
   syslog(0,"primary_val=" . $primary_val);
   syslog(0,"append_key=" .  $append_key);
   syslog(0,"append_val=" .  $append_val);

   /////////////////////////////////////
   $jgw = new MysqlJiaguwen();
   

   /////////////////
   $mysql = "SELECT * FROM $tabname WHERE $primary_key='$primary_val'";
   syslog(0,"mysql=" . $mysql);
   $ret = $jgw->query($mysql);
   print_r($ret);
   $append_orig="";
   foreach ($ret as $row ) {
      $append_orig = $row[$append_key];
      break;
   }
   syslog(0,"append_orig  =" . $append_orig);
   
   ////////////////
   $append_newval = preg_replace("/$append_val\,/", "", "$append_orig"); //
   syslog(0,"append_newval=" . $append_newval);
   
   if( substr($append_newval,0,1)=="," ) {
      $append_newval = substr($append_newval,1);
   }

   //////////
   $mysql = "UPDATE   $tabname SET  $append_key='$append_newval' WHERE $primary_key='$primary_val'";
   syslog(0,"mysql=" . $mysql);
   $jgw->execute($mysql);
}


public function udpate_item($params){
      
   //////////////////////////////////////////////
   print_r($_REQUEST);
   syslog(0, "params=".$params);
   echo "\n" ;
   $tok = explode(",", $params);//tabname, primarykey, primaryval, appendkey

   $tabname     = $tok[0];
   $primary_key = $tok[1];
   $primary_val = $tok[2];
   $append_key  = $tok[3];
   $append_val  = $tok[4];

   syslog(0,"tabname=" . tabname);
   syslog(0,"primary_key=" . $primary_key);
   syslog(0,"primary_val=" . $primary_val);
   syslog(0,"append_key=" .  $append_key);
   syslog(0,"append_val=" .  $append_val);

   /////////////////////////////////////
   $jgw = new MysqlJiaguwen();
   

   /////////////////
   $mysql = "UPDATE $tabname SET $append_key='$append_val' WHERE $primary_key='$primary_val'";
   syslog(0,"mysql=" . $mysql);
   $ret = $jgw->execute($mysql);
   echo "\n$ret : $mysql" ;
}

}//class 

//exit(0);


if(isset($_GET["test"]) && $_GET["test"]==1){
//=================
//usage sample
//=================
print("<br>======<br>");

///////////////////
$db = new MysqlJiaguwen();
//$sql="SELECT * FROM `Jiaguwen`";
//$ar = $db->query($sql);
//print_r($ar);
$db->showimg();


}//if










?>