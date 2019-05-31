<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/ChineseCharacterStatistic.php");





class TableOfBooks
{
public function tr_td($bookdir)
{
   $BOOKDIR = $bookdir;//"books/c";

   $ud = new Ureaddir();
   

   $arr = $ud->readdir2arr($BOOKDIR);

      foreach( $arr[0] as $dir )
      {
         echo "<tr>";
         echo "<td><a href='book_statistic.php?book=".$BOOKDIR.$dir."'>".$dir."</a></td>\r\n";
         
         //////////////////////
         echo "<td>";
         $udf = new Ureaddir();
         $udf-> readdir2arr_RecursFiles($BOOKDIR.$dir);
         foreach( $udf->dirFiles as $fname )
         {
            echo "<a href='".$fname."'>".basename($fname)."</a><br>\r\n";
         }
         echo "</td>";
         
         ///////////////////////
         echo "<td>";
         //echo $BOOKDIR.$dir;
         echo $_REQUEST["keyword"];
         echo ChineseCharacterStatistic::FindStatisticFromFile( $BOOKDIR.$dir, $_REQUEST["keyword"] );
         echo "</td>";

      }
   
}

public function GenTable($booksarr)
{
   echo "<table border=1>\r\n";
   foreach( $booksarr as $boook){
      $this->tr_td( $boook );
   }
   echo "</table>\r\n";
}

}

$tb = new TableOfBooks();

$tb->GenTable(array("../../obooks/c/","../../obooks/e/"));

//$tb = new TableOfBooks("./books/e/");








?>
