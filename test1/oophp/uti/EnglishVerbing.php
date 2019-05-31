<?php


class EnglishVerbing
{
public static function get_ing($verb)
{
      $match;
      if ( preg_match("/e$/", $verb, $match)>0 ){
         return  preg_replace("/e$/i", "ing", $verb); //
      }
      else if ( preg_match("/[^aeiou]y$/", $verb, $match)>0 ){
         return  preg_replace("/y$/i", "ing", $verb); //
      }
      else if ( preg_match("/[aeiou]y$/", $verb, $match)>0 ){
         return  preg_replace("/y$/i", "ying", $verb); //
      }
      else if ( preg_match("/[^aeioury][aeiu][^aeioulrnyxw]$/", $verb, $match)>0 ){
         if($verb != "visit") {
            return  $verb . substr($verb,-1)."ing" ;//
         }
         else{
            return  $verb . "ing" ;//
         }
      }
      else{
         return $verb . "ing" ;//
      }   
}


}



?>