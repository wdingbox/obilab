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
   $("img").click(function(){
      if( null == window.parent || null == window.parent.frames[0] || window.parent.frames[0].document) return; 
      var str = $(this).attr("src");
      var arr = str.split("/");
      
      
      //search available postion to add.
      var i=0;
      var upIndx=0;
      for( i=1; i<=10; i++ ){
         var text = $('#textoid'+i, window.parent.frames[0].document).text();
         if( text.length>1) continue; //already have img.
         upIndx = i;
         break;
      }
      if( 0==upIndx  ){
         alert("no space to add");
         return;
      }
      
      //add image and data at available place.
      for( i=1; i<=10; i++ ){//clear colors;
         $('#textoid'+i, window.parent.frames[0].document).css('background-color', 'white');
      }
      $('#root'+upIndx, window.parent.frames[0].document).attr("src",str);
      $('#textoid'+upIndx, window.parent.frames[0].document).text( arr[ arr.length-1].split(".")[0] );  
      $('#textoid'+upIndx, window.parent.frames[0].document).css('background-color', 'red');
      
      
      ////for cookie
      var imgfile = $(this).attr( "src" );
      jQuery.cookie( "jid", imgfile);
      //alert(  jQuery.cookie( "jid") );
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
                
<body bgcolor="<?php if(isset($_GET['bgc'])) echo '#'.$_GET['bgc']; else echo "#ffffff";?>">		
<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>

<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/JiaguwenNode.php");

$rootdirarr = array();

if( isset($_REQUEST["dir"])){
   $rootdirarr[] = $_REQUEST["dir"];
}
else{
   $rootdirarr[] ="../../odb/tbi/mer/root/a/i/basic";
   $rootdirarr[] ="../../odb/tbi/mer/root/a/i/cross";
   $rootdirarr[] ="../../odb/tbi/mer/root/a/i/son";

   $rootdirarr[] ="../../odb/tbi/mer/root/a/p/creatures";
   $rootdirarr[] ="../../odb/tbi/mer/root/a/p/DailyLife";
   $rootdirarr[] ="../../odb/tbi/mer/root/a/p/plant";
   $rootdirarr[] ="../../odb/tbi/mer/root/a/p/weapon";
   $rootdirarr[] ="../../odb/tbi/mer/root/a/p/worship";

}

function show_roots_in_dir($rootdir)
{
   $urd = new Ureaddir();
   $urd->readdir2arr_RecursFiles( $rootdir );

   $myarr = array();
   foreach( $urd->dirFolders as $dirname )
   {
      $base = basename( $dirname );
      $myarr[$base] = $dirname;
   }
   ksort($myarr);

   print("<div class='workingarea'>");
   ///create menu-list.
   print("<div class='menu_container'>\r\n");
      foreach( $myarr as $key=>$dir ){
         //$dir = basename( $dir );
         print("<div class='menuItem'><a> | $key </a></div>\r\n");
      }
   print("</div><br>\r\n");//menu_container

   print("<div class='contents_container'>\r\n");
   $jianod = new JiaguwenNode();
   foreach( $myarr as $dir ){
      //print("<br>".$dir."<br>");
      print("<div class='content'><a>\r\n");
      $jianod->loadDir($dir);
      $jianod->show();
      print("$dir</a></div>\r\n");
   }
   print("</div>\r\n");

   print("</div>");
}

foreach($rootdirarr as $rdir) {
   show_roots_in_dir($rdir);
}
?>
</body>

</html>