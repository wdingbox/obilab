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
   width  : *;
   float: top;
}
.db
{
   width  : 55px;
}
</style>                
<script type="text/javascript">

$(document).ready(function(){   
   $("img").mouseover(function(){
      //var oldwidth = $(this).css("width");
      //$(this).css("width","100px");
   }).mouseout(function(){
      //$(this).css("width","60px")
      });
      
      
   $("img").click(function(){
      if( $(this).css("width") != "65px" ){
         $(this).css("width","65px");
      }
      else{
         $(this).css("width","60px");
      }
      var srcfile = $(this).attr("src");
      
      if( window.parent.frames[0]==null) {
         jQuery.cookie( "jid", srcfile);
         return;
      }
      
      //var arr = srcfile.split("/");
      var hid = u_basename(srcfile); //arr[ arr.length-1].split(".")[0];
      if( hid == null ) return alert("hid does not exist!");
      jQuery.cookie("roots",hid);
      var iMin=-1;
      $("img.root", window.parent.frames[0].document).each(function(indx){
         var src = $(this).attr("src");
         if( src.length <= 1 && iMin == -1 ) iMin = indx ;
         var bname = u_basename( src );
         if( bname == hid ) {
            srcfile="";
         }
         $(this).nextAll("a:eq(0)").css("background-color", "white");   
      });
      if( "" == srcfile ) return alert(hid + " already in roots.");
      if( -1 == iMin ) return alert("roots is full.");
      $("img.root:eq("+iMin+")", window.parent.frames[0].document)
        .attr("src",srcfile)
        .nextAll("a:eq(0)").text(hid).css('background-color', 'red');
      return;
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
                
<body bgcolor="<?php if(isset($_GET['bgc'])) echo '#'.$_GET['bgc']; else echo '#11eeee'; ?>">		
<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>


<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/HieroglyphicsImgFiles.php");
require_once("../uti/MysqlHieroglyphics.php");

$hdb = new MysqlHieroglyphics();
$HidLinksArr = $hdb->getAssocHidLinks();

$destDir       = "../../odb/hiero/ds/compound";
if( isset($_REQUEST["dir"]) ) {
   $destDir = $_REQUEST["dir"];
}




$roots = new HieroglyphicsImgFiles( $destDir );



$myarr = HieroglyphicsImgFiles::GetClassifiedNamesDirs();

print("<div class='workingarea'>");
///create menu-list.
print("<div class='menu_container'>\r\n");
   $indx=0;
   foreach( $myarr as $key=>$dir ){
      //$dir = basename( $dir );
      $indx ++;
      $indx = $indx % 2;
      $clr = "#000ff";
      if($indx==0) $clr = "#000000";

     
      print("<div class='menuItem'><a>| <font color='$clr'>$key</font></a></div>\r\n");
   }
print("</div><br>\r\n");//menu_container
print("<div>-------------</div>\r\n");
print("<div class='contents_container'>\r\n");

foreach( $myarr as $dir ){
   $urf = new Ureaddir();
   $urf->readdir2arr_RecursFiles( $dir );

   //print("<br>".$dir."<br>");
   print("<div class='content'><a>\r\n");
   //$jianod->loadDir($dir);
   //$jianod->show();
   foreach( $urf->dirFiles as $file) {
      //if( substr($file,-4,4) !=".gif" ) continue;
      $bname = basename( $file, ".gif" );
      if( !isset( $roots->imgList[ $bname ] ) ) continue;
      $cls = "";
      if( strlen( $HidLinksArr[$bname] )>0) {
         $cls = "class='db'";
      }
      print("<img $cls title='$bname' src='$file'/>");
      print("");
   }
   
   print("$dir</a></div>\r\n");
}
print("</div>\r\n");

print("</div>");
?>
</body>

</html>