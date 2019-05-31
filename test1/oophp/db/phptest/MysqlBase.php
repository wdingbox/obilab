<?php
//======================================
//======================================
openlog("error_log", LOG_PID | LOG_PERROR, LOG_LOCAL0);


class MysqlBase
{
public $Databasename;
public $Username;
public $Password;
protected $dbh;
public function MysqlBase()
{
   $this->Databasename="mysql:dbname=otest;host=localhost";
   $this->Username="root";
   $this->Password="rootpass";
   
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
}//class MysqlBase

//exit(0);


if(0){
//=================
//usage sample
//=================
print("<br>======<br>");

///////////////////
$db = new MysqlBase();
$sql="SELECT * FROM `IrregularVerbs`";
$ar = $db->query($sql);
print_r($ar);



}//if










?>