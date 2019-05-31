<?php
require_once("../uti/Ureaddir.php");

@session_start();

function select($selid)
{
   $ur = new Ureaddir();
   $dir = "/tmp";
   $files = $ur->readdir2arr( $dir );


   $stafiles = array();
   foreach( $files[1] as $file){
      if( preg_match( "/^xyz/i",$file ) == 0 ) continue;
      $stafiles[] = $file;
      //print("<a href='$file'>$file</a><br>\r\n");
   }
   
   //print_r($_SESSION);
   $idsel = "sel_$selid";
   
   print("<select id='$idsel'  name='$idsel'>");
   foreach( $stafiles as $file){
      $selected="";
      if( $_SESSION[$idsel] == $file ) {
         $selected = "selected";
      }
      printf("<option value='%s' $selected>%s</option>\r\n",$file,$file);
   }
   print("</select>");
   
}

function ui()
{
print("<form id='submitform' name='submitform' action='book_statistic_compareData.php' method='POST'>");
   select(0);
   print("<br>\r\n");
   select(1);
   print("<br>\r\n");
   print("<button type='submit'>Compare books you have viewed in list.</button>\r\n");
print("</form>\r\n");
}

?>




<html>


<body>

<a href="book_list.php">book_list</a><br>

<?php ui(); ?>
</body>
</htm>