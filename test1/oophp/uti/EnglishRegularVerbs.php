<?php
require_once("EnglishVerbing.php");

class EnglishRegularVerbs{

public $ChangedVerbs;

public function EnglishRegularVerbs(){
   $this->load("../uti/EnglishRegularVerbs.txt");
}

public function get_ing($str)
{
   return EnglishVerbing::get_ing($str);
}

public function get_ed($str)
{
      $match;
      if ( preg_match("/e$/", $str, $match)>0 ){
         return $str."d";
      }
      else if ( preg_match("/[^aeiou]y$/", $str, $match)>0 ){
         return  preg_replace("/y$/i", "ied", $str); //
      }
      else if ( preg_match("/[aeiou]y$/", $str, $match)>0 ){
         return  $str . "ed" ;//
      }
      else if ( preg_match("/[^aeioury][aeiu][^aeioulrnyxw]$/", $str, $match)>0 ){
         if($str != "visit") {
            return  $str . substr($str,-1)."ed" ;//
         }
         else{
            return  $str . "ed" ;//
         }
      }
      else{
         return $str . "ed" ;//
      }
}
public function load($filename){

   $data = file_get_contents( $filename );
   if( false == $data ){
      print("failed4 to read file:" . $filename );
      die();
   }
   
   //$data = str_replace("'s ", " ", $data);
   $data = strtolower ( $data );   
   $data = preg_replace("/([a-z]+[0-9]+[:][0-9]+[\s])/i", " ", $data); //del verse name.
   $data = preg_replace("/[a-z]['][s][\s]/i", " ", $data); //del  ---'s .
   //$data = preg_replace("/[:'\"\?\.,=+()_[]{}|\\\/~`!@#\$%^&\*<>]/i", " ", $data); //del  ---'s .
   $data = preg_replace("/[^a-z]/i", " ", $data); //del symbols . ^:not letters. 

   $out = preg_split("/[\s\r\n]+/", $data); //space
   foreach ($out as $idx=>$str) 
   {
      $str = trim ($str);
      if( strlen($str)==0 ) continue;
      
      $this->ChangedVerbs[$this->get_ed($str)] = $str;
      $this->ChangedVerbs[$this->get_ing($str)]= $str;
   }
   return $this;
}
public function show()
{
   foreach( $this->ChangedVerbs as $key=>$past )
   {
      printf("%s => %s <br>",$key, $past);
      
   }
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
}






if(0){
   $rv = new EnglishRegularVerbs();
   $rv->show();
   



}


?>