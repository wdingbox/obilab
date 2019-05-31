<?php

require_once("Ureaddir.php");


// merged similar words in one folder to form one word.
class HieroglyphicsImgFiles 
{

public $HieroList;

public $Totword;
public $cat;
public $dir;
public function HieroglyphicsImgList(){

}
private function load($dir){

   $ur = new Ureaddir();
   $ur->readdir2arr_RecursFiles($dir);
   if(count($ur->$dirFiles)==0) die("$dir : is empty");
   foreach( $ur->$dirFiles as $file ){
      $bname = basename($file,".gif");
      if( preg_match("/[.]/i",$bname )>0 ) continue;
      $this->HieroList[ $bname ] = $file;
   }
}


}







?>