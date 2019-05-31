<?php
require_once("MysqlBase.php");
require_once("EnglishVerbing.php");

class EnglishIrregularVerbs extends MysqlBase
{

public $ChangedVerbs;
public function show_FoundUsed(){
   asort($this->ChangedVerbs);
   foreach ($this->ChangedVerbs as $key => $val){
      print $key." => ".$val."<br>";
   }
}

public function EnglishIrregularVerbs()
{
   $this->MysqlBase();

   $this->Databasename="mysql:dbname=otest;host=localhost";

   syslog(LOG_DEBUG,"IrregularVerbs");
   
   $this->loadChangedVerbs();
}


public function getBaseForm($word, &$bChanged)
{
    if(array_key_exists($word,$this->ChangedVerbs) )
   {
      $bChanged = true;
      return $this->ChangedVerbs[$word];
   }
   else{
      $bChanged = false;
      return $word;
   }   
}
public function loadChangedVerbs()
{
   $db = $this->connect();

   $sql = "SELECT * from IrregularVerbs ";
   //syslog(LOG_DEBUG, $sql );
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
           while( $row = $result->fetch() ){
               $ving = EnglishVerbing::get_ing( $row[1] ); 
               $this->ChangedVerbs[$ving] = $row[1];
               $this->ChangedVerbs[$row[2]] = $row[1];
               $this->ChangedVerbs[$row[3]] = $row[1];
           }
       }
       return $this;
}
}//class MysqlBase




if(0){
   //=================
   //usage sample
   //=================
   print("<br>======<br>");

   ///////////////////
   $db = new EnglishIrregularVerbs();
   $ret = $db->getBaseForm("broke");
   print_r($ret);
   $ret = $db->getBaseForm("broken");
   print_r($ret);
   syslog(LOG_DEBUG,"ret=".$ret);
}












?>