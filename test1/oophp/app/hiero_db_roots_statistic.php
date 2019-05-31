<!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
                <title> </title>

          
                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
                </head>
 <style type="text/css">
.menu_container_xxx{
   float: left;
}
.menuItem
{
   width  : *;
   height : 18px;
   float: left;
   padding : 0;
   margine : 0;
}
.contents_container
{
   float: top;
}
</style>                
<script type="text/javascript">

$(document).ready(function(){   
   $("img.zhid").click(function(){
      var str = $(this).attr("src");
      jQuery.cookie( "jid", str);
      //alert(  jQuery.cookie( "jid") );
      return;
   });
   
   $("img").click(function(){
      var str = $(this).attr("src");
      str = u_basename(str);
      if( null == str || str.length==0) {
         return alert("err no name for this img");
      }
      jQuery.cookie( "roots", str) ;
      //alert(  "cookie::roots = " + str);
      $(this).attr("title","cookie::roots="+str);
      return;
   }).mouseout(function(){
      $(this).attr("title","Click to set cookie::roots.");
      });
 

////////////////////////////////

  $(".menuItem").click(function(){
         $(this).next().css('background-color', 'red');
         var indx = $(this).index();
         //alert(indx);
         $(".content").hide();
         $(".content").eq( indx ).toggle();
         
         ///colorize the clicked
         $(".menuItem").css('background-color', 'white');
         $(this).css('background-color', 'red');
  });     
//////////////////////////////////////  
});                                           
 </script>

</head>     
                
<body bgcolor="<?php echo '#eeeeee'; ?>">		
<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>

<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlHieroglyphics.php");

//$rootdir = $_REQUEST["dir"];

$harr = new MysqlHieroglyphics();
$myarr = $harr->getRootsStatistic( );

arsort($myarr);
print("[total roots = " . count($myarr) ."]");

if(0){
   print("<table border='1'>");

   $i=0;
   foreach( $myarr as $key => $ar )
   {  
      $freq = $ar["freq"];
      $i++;
      print("<tr><td>$i</td>");
         $src = MysqlHieroglyphics::imgsrc($key);
         print("<td><img class='db' name='$key' src=$src /><a>$key</a></td>");
         print("<td><a>$freq</a></td>");
      print("</tr>\r\n");
   }
   print("</table>");
}

if( isset($_REQUEST["sort"]) && $_REQUEST["sort"] == "ksort") {
   ksort($myarr);
}

foreach( $myarr as $key => $ar )
{  
   $freq = $ar["freq"];
      $src = MysqlHieroglyphics::imgsrc($key);
      print("<img class='addroot' name='$key' src=$src /><a href='#$key'>$key</a>");
      print("<a>($freq)</a>");
   print("\r\n");
}

print("<div><br></div>\r\n");



print("<table border='1'>");
foreach( $myarr as $key => $ar )
{  
   print("<tr>");
   
      $src = MysqlHieroglyphics::imgsrc($key);
      print("<td><img class='db' name='$key' src=$src /><a name='$key'>$key</a></td>");
      
      print("<td>");
      $arrChildren = $ar["children"];
      foreach( $arrChildren as $img){
         $src = MysqlHieroglyphics::imgsrc($img);
         print("<img class='zhid' name='$img' src=$src /><a class='zhid'>$img</a>");
      }
      print("</td>");
   print("</tr>\r\n");
}
print("<div><br></div>");
print("</table>");

?>
</body>

</html>