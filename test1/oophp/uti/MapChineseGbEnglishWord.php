<?php
require_once("MysqlBase.php");
require_once("EnglishVerbing.php");

class MapChineseGbEnglishWord extends MysqlBase
{

public $MapGbWord;
public function MapChineseGbEnglishWord()
{
   $this->MysqlBase();

   $this->Databasename="mysql:dbname=otest;host=localhost";

   syslog(LOG_DEBUG,"IrregularVerbs");
   $this->loadFrDb();
}


public function getChineseGB($word, $IsChinese)
{
   if( $IsChinese ) {
      if( !is_numeric( $word ) ) {
         //convert Endglish word to chinese GB code;
         $word = array_search( $word, $this->MapGbWord );
      }
   }
   else{
      //english
      if( is_numeric( $word ) ) {
         //convert chinese code into english word;
         $word = $this->MapGbWord[$word];//"son";
      }
   }
   return $word;
}
public function loadFrDb()
{
   $db = $this->connect();

   $sql = "SELECT * from MapChineseGbEnglishWord";
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
               //Array ( [id] => 4 [0] => 4 [GB] => 20182 [1] => 20182 [Word] => he [2] => he ) ?
               $this->MapGbWord[ $row[1] ] = $row[2];
               //print_r($row);
               //print("&#".$row[1].";<br>");
           }
       }
       return $this;
}

public function showDB()
{
   $db = $this->connect();

   $sql = "SELECT * from MapChineseGbEnglishWord";
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
               print_r($row);
               print("&#".$row[1].";<br>");
           }
       }
       return $this;
}
}//class MysqlBase




if( 0 && isset ( $_REQUEST["key"]) ){
   //=================
   //usage sample
   //=================
   print("<br>======<br>");

   ///////////////////
   $db = new MapChineseGbEnglishWord();

   
   echo $db->getChineseGB($_REQUEST["key"], true) . " - chinese<BR>";
   echo $db->getChineseGB($_REQUEST["key"], false) . " - english<BR>";
   print("<br>======<br>");
   $ret = $db->showDB();  
}












?>