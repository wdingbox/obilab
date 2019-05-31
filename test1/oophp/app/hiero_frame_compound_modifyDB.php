<!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
                <title> </title>

          
                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
                </head>
<style>
body{
   padding : 0;
   margine : 0;
}
.menuItem
{
   width  : *;
   height : 18px;
   float: left;
   padding : 0;
   margine : 0;
}
div{
padding:0;
margine:0;
}
.myword
{
   float: left;
   width : 120px;
}
.myctr
{
   float: left;
   width : 60px;
}
</style>                   
<script type="text/javascript">
var oid=57345;
$(document).ready(function(){

   $("#imgid").mouseover(function(){
      var oldwidth = $(this).css("width");
      $(this).css("width","80px");
   }).mouseout(function(){
      $(this).css("width","60px")
      });   

function show(){
   $.post("../uti/svc/test.php", 
                     {   
                         jid:  oid
                     },
                     function(data, status){
                        $("#textoid").html(data);
                        $("#imgid").attr("src","../../odb/tbi/img/jgif/"+oid+".gif");
                     },
                      "datastring"
   );// post
}
$("#next").click(function(){
   oid += parseInt( $("#dlta").val() );
   show();			  
});
$("#prev").click(function(){
   oid -= parseInt( $("#dlta").val() );
   show();			  
});

$("#Update").click(function(){
  UpdateDatabase();
});
      
   /////////////////////////////
   $("img.root").click(function(){
      $(this).attr("src","0");
      $(this).nextAll("a:first").text("") ;     
       
      var idz = $(this).attr("id");
      $('#textoid').attr("upIndx",idz);      

      ////clear the text bg colors.
      $("a.root").css('background-color', 'white');
   });  
   
   
   $("#imgid").click(function(){
      LoadDatabase();
   });  
   
   $("#textoid").click(function(){
      LoadTheCookie();
   });
         
         
         
   ////////////////////
   $("#AutoSave").click(function(){
      $("#AutoLoad").text("AutoLoad");
      if( 2 == gAutoRun){
         gAutoRun = 0; //stop 
         return;
      }
      gAutoRun = 2;
      AutoRun();
   });
   $("#AutoLoad").click(function(){
      $("#AutoSave").text("AutoSave");
      if( 1 == gAutoRun){
         gAutoRun = 0; //stop 
         return;
      }
      gAutoRun = 1;
      AutoRun();
   });
   $("#StopAuto").click(function(){
      gAutoRun = 0;
      $("#autotxt").text("---");
   });

   ////////////////////////////////////////
   $("#addroot_fromcookie").click(function(){
      var addroots = jQuery.cookie( "roots");
      if( addroots == null ) return alert("addroots is null");
      //alert(addroots);
      var cookieRootsArr = addroots.split(",");
      for(var jdx=0; jdx < cookieRootsArr.length; jdx++ ){
         var chid = cookieRootsArr[jdx];
         if( "" == chid || null ==chid ) continue;
         
         var iMin=-1;
         $("img.root").each(function(indx){
            var atxt = $(this).nextAll("a:eq(0)").text();
            if( ( null == atxt || ""==atxt ) && -1 == iMin ) iMin = indx;
            if( atxt == chid ) chid = "";
         });
         if( -1 == iMin ) return alert("img is full");
         if( ""==chid ) continue;         
         var src = getImgSrc(chid);
         $("img.root:eq("+iMin+")").attr("src",src)
                                   .nextAll("a:eq(0)").text(chid);
         
      }
      return;        
   });
   ////////////////////////////////////////
   $("#Save2cookies").click(function(){
      var strroots="";
      $("a.root").each( function(i){
         strroots += $(this).text()+",";
      });
      jQuery.cookie( "roots", strroots);
   });
});//$(document).ready(function(){  

var gAutoRun = 0 ;  
var giAutoCounter=0;
   
   function AutoRun(){
      LoadTheCookie();
      if( gAutoRun == 1 ){
         LoadDatabase();//display
         $("#AutoLoad").text("AutoLoad:"+giAutoCounter);
      }
      else if( gAutoRun == 2 ){
         $("#AutoSave").text("AutoSave:"+giAutoCounter);
         UpdateDatabase();//save
      }
      giAutoCounter++;

      if(gAutoRun==0) return;
      timerID = setTimeout("AutoRun()",1000);
   }  
   function UpdateDatabase(){
       //alert(0);			  
      $.post("../uti/svc/Hieroglyphics_update.php", 
                     {   
                         jid:  $("#textoid").text(),
                         link1: $("#textoid1").text(),
                         link2: $("#textoid2").text(),
                         link3: $("#textoid3").text(),
                         link4: $("#textoid4").text(),
                         link5: $("#textoid5").text(),
                         link6: $("#textoid6").text(),
                         link7: $("#textoid7").text(),
                         link8: $("#textoid8").text(),
                         link9: $("#textoid9").text(),
                         link10: $("#textoid10").text(),
                         link11: $("#textoid11").text(),
                         link12: $("#textoid12").text(),
                         link13: $("#textoid13").text(),
                         link14: $("#textoid14").text(),
                         link15: $("#textoid15").text(),
                         link16: $("#textoid16").text(),
                         link17: $("#textoid17").text(),
                         link18: $("#textoid18").text(),
                         link19: $("#textoid19").text(),
                         link20: $("#textoid20").text()
                      },
                      function(data, status){
                        var ifind = data.search("ret=1");
                        if( data.search("ret=1")>0 ){
                           $("body").css('background-color', '#11ff11');
                        }
                        else if( data.search("ret=0")>0 ){
                           $("body").css('background-color', '#ffff99');
                        }
                        else{
                           $("body").css('background-color', '#ff6666');
                        }
                        $("#msg").text(data + "; ifind=" + ifind);
                     },
                      "datastring"
      );// post
      
   }      
   function LoadDatabase(){
         $.post("../uti/svc/Hieroglyphics_read.php", 
                      {   
                         jid:  $("#textoid").text()
                      },
                      function(data, status){
                        if(data.search("err")>=0) {
                           $("body").css('background-color', '#ff0011');
                           return alert(data);
                        }
                        $("body").css('background-color', '#11ff11');                       
                        $("#msg").text(data);
                        
                        var arr = data.split(",");
                        $("img.root").each(function(indx){
                           $(this).attr("src","");
                           $(this).nextAll("a:first").text("");
                           if(indx < arr.length && arr[indx].length>0){
                              var src = getImgSrc(arr[indx]);//"../../odb/hiero/ccer-h/"+arr[indx]+".gif";
                              $(this).attr("src",src);
                              $(this).nextAll("a:first").text( arr[indx] );
                           }
                        });
                     },
                      "datastring"
         );// post
   }
   function LoadTheCookie(){
      var imgfile = jQuery.cookie('jid');
      imgfile = u_src_of(imgfile);
      $("#imgid").attr("src",imgfile);
      var arr = imgfile.split("/");
      $("#textoid").text( arr[ arr.length-1].split(".")[0] );
      
      if( $("#textoid").css('background-color') != "#9999ff" ){
         $("#textoid").css('background-color', '#9999ff');
      }
      else{
         $("#textoid").css('background-color', '#ff9999');
      }
   }
   
   
   
function getImgSrc(id){
   
   if( null == id || "" == id ) return "";
   return "../../odb/hiero/ccer-h/" + id + ".gif";
}
 </script>

</head>     
                
<body  bgcolor="#ddee22">
<div class="myword">
<div class="myctr">
<img id='imgid' src="../../odb/tbi/img/jgif/57344.gif" title="ajax load roots from DB links">
</img></div>
<div class="myctr">

<a id='textoid' upIndx='1'  title="load cookie for compound img: jid (img src full path file)">cookie</a><br><br>
<button id='Update' title='Save roots links list for compound img into DB'>SaveDB</button>
</div></div>

<div>
<img id='root1' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid1' class='root' ></a>
<img id='root2' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid2' class='root' ></a>
<img id='root3' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid3' class='root' ></a>
<img id='root4' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid4' class='root' ></a>
<img id='root5' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid5' class='root' ></a>
<img id='root6' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid6' class='root' ></a>

<img id='root7' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid7' class='root' ></a>
<img id='root8' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid8' class='root' ></a>
<img id='root9' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid9' class='root' ></a>
<img id='root10' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid10' class='root' ></a>


<img id='root11' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid11' class='root' ></a>
<img id='root12' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid12' class='root' ></a>
<img id='root13' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid13' class='root' ></a>
<img id='root14' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid14' class='root' ></a>
<img id='root15' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid15' class='root' ></a>
<img id='root16' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid16' class='root' ></a>

<img id='root17' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid17' class='root' ></a>
<img id='root18' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid18' class='root' ></a>
<img id='root19' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid19' class='root' ></a>
<img id='root20' class='root' src="../../odb/tbi/img/jgif/57344.gif"></img><a id='textoid20' class='root' ></a>



<button id='prev'>&lt;</button><button id='next'>&gt;</button><input id='dlta' size='2' value=1 />


<br>

<script type="text/javascript">
var oid=57345;
$(document).ready(function(){

   $("#Transfer2jid").click(function(){
      var s = $.cookie("roots");
      $.cookie("jid",s);
      alert($.cookie("jid"));
   });
});
 </script>
</div><br>
<div>

<button id='AutoLoad' title='auto load the compound and its roots img every 3s.'>AutoLoad<br>Compound</button>
<button id='AutoSave' title='auto save the roots of compound and its roots into links of DB'>AutoSave<br>Compound</button>==
<button id='addroot_fromcookie' title='Load cookie::roots and append to img list'>Append<br>Cookie::roots</button>
<button id='Save2cookies' title='save img list into cookie::roots (root1,root2,,,,)'>Save2<br>cookie::roots</button>
<button id='Transfer2jid' title='transfer cookie::roots to jid as compound.'>Transfer cookie::roots<br>To jid Compound</button>
<br>
<a id='msg' ></a><br>
</div>

</body>

</html>