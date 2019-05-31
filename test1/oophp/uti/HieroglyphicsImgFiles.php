<?php

require_once("Ureaddir.php");


// merged similar words in one folder to form one word.
class HieroglyphicsImgFiles 
{

public $imgList;

public $Tot;
public $cat;
public $dir;
public function HieroglyphicsImgFiles($dir){
   $this->load( $dir );
}
private function load($dir){
   $this->dir = $dir;
   $ur = new Ureaddir();
   $ur->readdir2arr_RecursFiles($dir);
   if(count($ur->dirFiles)==0) die("$dir : is empty");
   $this->Tot = 0;
   foreach( $ur->dirFiles as $file ){
      $bname = basename($file,".gif");
      if( preg_match("/[^.][.][^\/]/i",$bname )>0 ) continue;
      $this->imgList[ $bname ] = $file;
      $this->Tot ++;
   }
}
///////////////////////////////////////////////////////
static public function GetClassifiedNamesDirs (){
   $urd = new Ureaddir();
   $urd->readdir2arr_RecursFiles( "../../odb/hiero/ccer" );
   $myarr = array();
   foreach( $urd->dirFolders as $dirname )
   {
      if( 0 == preg_match("/index_logo_data/i", $dirname) ) continue;
      $narr = preg_split("/[\/]/i",$dirname );
      if( count( $narr ) < 5 ) continue;      
      //$base = basename( $dirname );
      
      $classifiedName = $narr[5];
      syslog(0, "name=". $narr[5] );
      
      $myarr[ $classifiedName ] = $dirname;
   }
   return $myarr;
}


public function show(){
   foreach( $this->imgList as $key => $fil ){
      echo $key."=".$fil . "<br>";
   }
}

}/////class


//////////////////////////////









?>