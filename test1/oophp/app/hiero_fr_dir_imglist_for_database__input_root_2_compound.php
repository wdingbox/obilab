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
   width  : *;
}
.menuItem
{
   position:relative;

   height : 18px;
   float: left;
   padding : 0;
   margine : 0;
}
.contents_container
{
   float: top;
}
.db
{
   width  : 55px;
}
.db0
{
   width  : 15px;
}
.links
{
   width  : 50px;
}
.links0
{
   width  : 15px;
}
.segeration{
height : 180px;
width  : 100px;
float: top;
}
.empty{

width  : 1px;
}
</style>         
<script type="text/javascript">
$(document).ready(function(){  
   $("a.cj").mouseover(function() {
      $(this).attr("title", "Save cookie::roots for jiaguwen map");
   }).click(function(){
      var s = $(this).text();
      jQuery.cookie("roots",s);
   });
});
</script>     

   
<script type="text/javascript">

$(document).ready(function(){   
   //$("img[src='']").attr("width","1px");
   //menu
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

 
   //view imgs of cookie::roots
   $("#loadcookie_roots").click(function(){
      
      var strroots = jQuery.cookie( "roots");      
      if( null == strroots ) return alert("cookie roots is null");
      var rootarr = strroots.split(",");
      var k=0;
      $("img.roots").attr("src","");
      for(var i=0; i<rootarr.length; i++){
         var cod = rootarr[i];
         if(null==cod || "null"==cod || ""==cod) continue;
         var imgfile = "../../odb/hiero/ccer-h/"+cod+".gif";
         $("img.roots:eq("+k+")").attr("src",imgfile);
         $("img.roots:eq("+k+")").attr("title",cod);
         //$("img.roots:eq("+k+")").attr("width","80px");
         k++;
      }
      return;
   });
   
   // pick root for input
   $("img.roots").click(function(){
      return;
      //alert($(this).css("width"));
      if( $(this).css("width") != "80px"){
          $(this).css("width","80px");
      }
      else{
         $(this).css("width","60px");
      }
      //cook all picked roots.
      var inputs = "";
      $("img.roots").each(function(k){
               if( $(this).css("width") != "80px" ) return;
               inputs += $(this).attr("title") + ",";
         });
      //alert(inputs);
      jQuery.cookie("roots", inputs);
      //$("#loadcookie_roots").attr("roots",inputs);
      
   });
   
function  jImgs(clsid, compound, linkedroots){
   //alert(linkedroots);  
   var arr = linkedroots.split(",");
   var htm_img="";
   for(var i=0; i<arr.length; i++){
      var rid = arr[i];
      if( null==rid || ""==rid) continue;
      var fname = "../../odb/hiero/ccer-h/" + rid + ".gif";
      
      htm_img+="<img class='links' title='[del]:" + compound + ":" + rid + "' src='";
      htm_img+=fname +"' ></img><a ";
      htm_img+=" class='links' title='rev:" + rid +"'>" + rid +"</a>\r\n";
   }
   //alert(htm_img); 
   return htm_img;
}

function  add_roots_2_compound(clsID, linkedroots){
   //alert(linkedroots);  
   var cmpsrc = $("#"+clsID).parent().find("img.db:eq(0)").attr("src");
   var cmpID = u_basename(cmpsrc);
   
   var arr = jlinks2arr(linkedroots);//.split(",");  
   $("#"+clsID).parent().find("img[src='']").each(function(idx){
      if( null==arr[idx] || 0==arr[idx].length) return ;//alert("arr end as null"); 
      var srcfile = "../../odb/hiero/ccer-h/"+arr[idx]+".gif";
      $(this).attr("class","links").addClass("links")
      .attr("src",srcfile)
      .attr("title","[del]:"+cmpID+":"+arr[idx])
      .next().text(arr[idx]);  
   });
   return;
}

function  show_roots_hids(clsID, linkedroots){
   //alert(linkedroots);  
   var cmpsrc = $("#"+clsID).parent().find("img.db:eq(0)").attr("src");
   if(null == cmpsrc || "" == cmpsrc) return alert(cmpsrc);
   var cmpID = u_basename(cmpsrc);
   
   var arr = jlinks2arr(linkedroots);//.split(",");  
   $("#"+clsID).parent().find("img.links").each(function(idx){
      if( null==arr[idx] || 0==arr[idx].length) {
         $(this).attr("src","").attr("width", "1px");
         return ;//alert("err : arr end as null"); 
      }
      var srcfile = "../../odb/hiero/ccer-h/"+arr[idx]+".gif";
      $(this).attr("class","links")
      .attr("src",srcfile).attr("width","60px")
      .attr("title","[del]:" + cmpID + ":"+arr[idx])
      .next().text( arr[idx] );  
   });
   return;
}


   //hit compound hid img to input roots.
   $("img.db").click(function(){
            var addroots= jQuery.cookie("roots");
            if( addroots==null || addroots.length == 0 ) {
               return alert("cookie::roots is null.");
               addroots = jQuery.cookie( "addroot");   
            }
            //alert(rootStr);

            var src = $(this).attr("src");
            compound = u_basename (src);
            //var htm_img = jImgs("", compound ,addroots);
            //$(this).parent().find("a:eq(0)").append(htm_img);
            //$(this).parent().append(htm_img);
            
            $(this).attr("id","addid");
            
            $.post("../uti/svc/Hieroglyphics_update_add_roots.php", 
                            {   
                               jid:    compound,
                               roots:  addroots
                            },
                            function(data, status){
                              $("#msg").text(data);
                              $("#msg").css('background-color', '#eeddee');
                              if(data.search("err")!=-1) {
                                 $("#msg").css('background-color', '#ff0000');
                                 $("#addid").attr("id","");
                                 return alert(data);
                              }
                              var retarr = data.split("; ");
                              var ret = retarr[2];
                              var retarr2 = ret.split("=");
                              var ret2 = retarr2[1];
                              
                              show_roots_hids("addid", ret2);
                              //compound = jbasename (src);
                              //add_roots_2_compound("addid", addroots);
                              //var htm_img = jImgs("", compound ,addroots);
                              //alert(htm_img);
                              //$("#addid").parent().find("a:last").append(htm_img);
                              //$(this).parent().append(htm_img);
                              $("#addid").attr("id","");
                           },
                            "datastring"
               );// post                              
               if( $(this).css("width") != "65px" ){
                     $(this).css("width","65px");
               }
               else{
                     $(this).css("width","60px");
               }  
   });
   //$("img").click(function(){alert("")});
   // del or undel root
   $("img.links").click(function(){
      //alert("");
      var ts = $(this).attr("title");
      var arr = ts.split(":");
      var hid = arr[1];
      var rootStr = arr[2];
      for(var i=0;i<arr.length; i++){ 
         //alert(arr[i]);
      }
      var url = "../uti/svc/Hieroglyphics_update_delete_root.php";
      if( arr[0] != "[del]") {
          url = "../uti/svc/Hieroglyphics_update_add_roots.php";
      }
      
      if( $(this).attr("id") == "addid" ) {
         return alert("previous add item has not been finished yet");
      }
      $(this).attr("id", "addid");
      
      $.post(  url, 
                               {   
                                  jid:    hid,
                                  roots:  rootStr
                               },
                               function(data, status){
                                 $("#msg").text(data);
                                 $("#msg").css('background-color', '#eeddee');
                                 //alert(data.search("err"));
                                 if(data.search("err")==-1) {
                                    //$("#delid").css("width", "5px");
                                    $("#msg").css('background-color', '#00ff00');
                                 }
                                 else {
                                    $("#msg").css('background-color', '#ff0000');
                                 }
                                 
                                 var tit = $("#addid").attr("title");
                                 //alert(tit + tit.search("del"));
                                 //var arr = tit.split(":");
                                 if( tit.search("del") >=0  ) {
                                    tit = tit.replace("[del]", "[add]");
                                    $("#addid").css("width", "10px");
                                 }
                                 else{
                                    tit = tit.replace("[add]", "[del]");
                                    $("#addid").css("width", "60px");
                                 }
                                 //alert(tit);
                                 $("#addid").attr("title",tit);
                                 $("#addid").attr("id","");
                              },
                               "datastring"
                  );// post  
   });
   
   //toggle freq. if it is 0, to hide img.
   $("a.freq").click(function(){
      var txt = $(this).text();
      var freq = 1;
      if( txt.search("===")>=0 ){
         ///$(this).text("*");
         freq = 0;
      }
      else{
         //$(this).text("=");
         freq = 1;
      }
      var hid = $(this).attr("name");
      
            
      if( $(this).attr("id") == "aaddid" ) {
         return alert("previous add item has not been finished yet");
      }
      $(this).attr("id", "aaddid");
      
      url = "../uti/svc/Hieroglyphics_update_freq.php";
      $.post(  url, 
                               {   
                                  jid:    hid,
                                  freq:  freq
                               },
                               function(data, status){
                                 $("#msg").text(data);
                                 
                                 if(data.search("err")>=0) {
                                    //$("#delid").css("width", "5px");
                                    $("#msg").css('background-color', '#ff0000');
                                    return alert(data);                                    
                                 }
                                 $("#msg").css('background-color', '#00ff00');
                                 
                                 if(data.search("freq=0")>=0) {
                                    $("#aaddid").text("***");
                                    $("#aaddid").parent().find("img.db").attr("class","db0"); //removeClass("db").addClass("db0");
                                    $("#aaddid").parent().find("img.links").attr("class","links0"); 
                                 }
                                 else{
                                    $("#aaddid").text("===");
                                    $("#aaddid").parent().find("img.db0").attr("class","db"); //.removeClass("db0").addClass("db");
                                    $("#aaddid").parent().find("img.links0").attr("class","links"); 
                                 }
                                 
                                 //alert(tit);
                                 $("#aaddid").attr("title",data);
                                 $("#aaddid").attr("id","");
                              },
                               "datastring"
                  );// post  
      
      
   });
   
   
   
   $("#UseStatisticRootCookie").click(function(){
      jQuery.cookie("inputRoots","");
      alert("disable cookie from DB editer: roots. Use 'addroot' from root statistic cookie");
      alert("addroot="+jQuery.cookie("addroot"));
   });
}); ////jQuery
   



 </script>

</head>     
                
<body bgcolor="#eeddee">		
<div>

<button id="loadcookie_roots" title="load cookie : roots (root1,root2,,,,)" >view<br>cookie::roots</button>
<img class="roots" alt="fff" title="aaa" src="../../odb/hiero/ccer-h/A13A.gif"></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>
<img class='roots' src=""></img>


<br><a id='msg'>---</a>
</div>
<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/HieroglyphicsImgFiles.php");
require_once("../uti/MysqlHieroglyphics.php");




function htm_img_linksz( $val ){
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if('0'==$bname || strlen($bname)==0) continue;
      $fname = "../../odb/hiero/ccer-h/$bname.gif";
      $ret .= "<img class='links' title='del:$bname' src='$fname'/><a>$bname</a>\r\n";
   }
   return $ret;
}
function htm_img_links($clsid, $hid, $linkedroots ){
   $ret="";
   $arr = preg_split("/[,]/i",$linkedroots);
   foreach($arr as $bname){
      if('0'==$bname || strlen($bname)==0) continue;
      $fname = "../../odb/hiero/ccer-h/$bname.gif";
      $ret .= "<img class='links$clsid' title='[del]:$hid:$bname' src='$fname'/>";
      $ret .="<a class='links' title='rev:$bname'>$bname</a>\r\n";
   }
   
   
   for($i=0; $i<5;$i++) {
      $ret .= "<img class='links empty' src=''/><a class='links'></a>\r\n";
   }

   return $ret;
}


$hdb = new MysqlHieroglyphics();
//$HidLinksArr = $hdb->getAssocHidLinks();
$HidLinksArr = $hdb->getAssoc_Hid_rows();
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
print("<div class='segeration'></div>\r\n");
print("<div class='contents_container'>\r\n");

foreach( $myarr as $dir ){
   $urf = new Ureaddir();
   $urf->readdir2arr_RecursFiles( $dir );

   //print("<br>".$dir."<br>");
   print("<div class='content'><a><img/><img/><img/><img/><img/><img/><br>\r\n");
   //$jianod->loadDir($dir);
   //$jianod->show();
   foreach( $urf->dirFiles as $file) {
      //if( substr($file,-4,4) !=".gif" ) continue;
      $bname = basename( $file, ".gif" );
      if( !isset( $roots->imgList[ $bname ] ) ) continue;
      $cls = "class='db'";

      $title = $bname . "(" .  $HidLinksArr[$bname]['hink'] . ")";
      

      $htm_a = "<a class='freq' name='$bname'>===</a>";
      $lnkcls="";
      if(  0 == $HidLinksArr[$bname]['freq'] ){
         $cls = "class='db0'";
         $htm_a = "<a class='freq' name='$bname'>***</a>";
         $lnkcls="0";
      }   
      
      print("<div>");
      print("<img $cls title='$title' src='$file'/>");
      
      print("<a class='cj'>$bname</a>");
      print($htm_a);
      print( htm_img_links($lnkcls, $bname, $HidLinksArr[$bname]['hink']) );
      print("<br></div>\r\n");
   }
   
   print("$dir</a></div>\r\n");
   
   static $tempCount=0;
   $tempCount++;
   //if($tempCount>0) break;
}
print("</div>\r\n");

print("</div>");
?>
</body>

</html>