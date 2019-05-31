<?php
require_once("../MysqlBase.php");


class IrregularVerbs //extends MysqlBase
{
public $FoundUsed;
public $ChangedVerbs;
public function show_FoundUsed(){
   asort($this->FoundUsed);
   foreach ($this->FoundUsed as $key => $val){
      print $key." => ".$val."<br>";
   }
}

public function IrregularVerbs()
{
   $this->MysqlBase();

   $this->Databasename="mysql:dbname=otest;host=localhost";

   syslog(LOG_DEBUG,"IrregularVerbs");
}


public function getBaseFormFromDB($verb)
{
   $db = $this->connect();

   $sql = "SELECT * from IrregularVerbs where SimplePastTense='$verb' OR PastParticiple='$verb'";
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
               //print_r($row );
               $this->FoundUsed[$verb] = $row[1];
               return $row[1];
           }
       }
       return $verb;
}
public function getBaseForm($word)
{
    if(is_key_exist($word,$this->ChangedVerbs) )
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
               $ving = $row[1]; 
               $this->ChangedVerbs[$ving] = $row[1];
               $this->ChangedVerbs[$row[2]] = $row[1];
               $this->ChangedVerbs[$row[3]] = $row[1];
           }
       }
       return $verb;
}
}//class MysqlBase




if(0){
   //=================
   //usage sample
   //=================
   print("<br>======<br>");

   ///////////////////
   $db = new IrregularVerbs();
   $ret = $db->getBaseForm("broke");
   print_r($ret);
   $ret = $db->getBaseForm("broken");
   print_r($ret);
   syslog(LOG_DEBUG,"ret=".$ret);
}












?>