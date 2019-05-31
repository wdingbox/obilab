<!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
                <title> </title>

          
                <script type="text/javascript" src="../_js/jquery.js"></script>
                <script type="text/javascript" src="../_js/jquery.cookie.js"></script>

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

function show(){
   $.post("./uti/svc/test.php", 
                     {   
                         jid:  oid
                     },
                     function(data, status){
                        $("#textoid").html(data);
                        $("#imgid").attr("src","../odb/tbi/img/jgif/"+oid+".gif");
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
      
   $("img.update").click(function(){
      $(this).attr("src","0");
      var idz = $(this).attr("id");
      
      idz = idz.substr(4,2);//alert(idz); //4:pos, 2:length
      $('#textoid'+idz).text("");
      
      $('#textoid').attr("upIndx",idz);
      
      ////clear the text bg colors.
      $("a.update").css('background-color', 'white');
   });  
   
   
   $("#imgid").click(function(){
      LoadDatabase();
   });  
   
   $("#textoid").click(function(){
      LoadTheCookie();
   });
         
         
         
   ////////////////////
   $("#AutoSave").click(function(){
      gAutoRun = 2;
      AutoRun();
   });
   $("#AutoLoad").click(function(){
      gAutoRun = 1;
      AutoRun();
   });
   $("#StopAuto").click(function(){
      gAutoRun = 0;
      $("#autotxt").text("---");
   });

});//$(document).ready(function(){  

var gAutoRun = 0 ;  
var giAutoCounter=0;
   
   function AutoRun(){
      if( gAutoRun == 1 ){
         LoadTheCookie();
         LoadDatabase();
      }
      else if( gAutoRun == 2 ){
         UpdateDatabase();
      }
      giAutoCounter++;
      $("#autotxt").text(giAutoCounter);
      if(gAutoRun==0) return;
      timerID = setTimeout("AutoRun()",1000);
   }  
   function UpdateDatabase(){
       //alert(0);			  
      $.post("./uti/svc/Hieroglyphics_update.php", 
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
         $.post("./uti/svc/Hieroglyphics_read.php", 
                      {   
                         jid:  $("#textoid").text()
                      },
                      function(data, status){
                        if(data.search("err")>=0) {
                           $("body").css('background-color', '#ff0011');
                           return;
                        }
                        $("body").css('background-color', '#11ff11');
                        
                        $("#msg").text(data);
                        var arr = data.split(",");
                        var idx = 0;
                        $("img.root").each(function(indx){
                           var src = "";
                           var hid = "";
                           for( idx; idx < arr.length;idx++) {
                              hid = arr[idx];
                              if( null ==  hid || hid.length == 0) continue;
                              src = "../odb/hiero/ccer-h/"+hid+".gif";
                              break;
                           }
                           if( src.length > 0 ) {
                              $(this).attr("src",src)
                                .nextAll("a:eq(0)").text(hid);
                           }
                        });
                        return;
                     },
                      "datastring"
         );// post
   }
   function LoadTheCookie(){
      var imgfile = jQuery.cookie('jid');
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
   
   
   

 </script>

</head>     
                
<body  bgcolor="#ddee22">
<div class="myword">
<div class="myctr">
<img id='imgid' src="../odb/tbi/img/jgif/57344.gif" alt="load linkstr">
</img></div>
<div class="myctr">

<a id='textoid' upIndx='1'  alt="load cookie">cookie</a><br><br>
<button id='Update'>Save</button>
</div></div>

<div>
<img id='root1' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid1' class='update' ></a>
<img id='root2' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid2' class='update' ></a>
<img id='root3' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid3' class='update' ></a>
<img id='root4' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid4' class='update' ></a>
<img id='root5' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid5' class='update' ></a>
<img id='root6' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid6' class='update' ></a>

<img id='root7' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid7' class='update' ></a>
<img id='root8' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid8' class='update' ></a>
<img id='root9' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid9' class='update' ></a>
<img id='root10' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid10' class='update' ></a>


<img id='root11' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid11' class='update' ></a>
<img id='root12' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid12' class='update' ></a>
<img id='root13' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid13' class='update' ></a>
<img id='root14' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid14' class='update' ></a>
<img id='root15' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid15' class='update' ></a>
<img id='root16' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid16' class='update' ></a>

<img id='root17' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid17' class='update' ></a>
<img id='root18' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid18' class='update' ></a>
<img id='root19' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid19' class='update' ></a>
<img id='root20' class='update' src="../odb/tbi/img/jgif/57344.gif"></img><a id='textoid20' class='update' ></a>




<button id='prev'>&lt;</button><button id='next'>&gt;</button><input id='dlta' size='2' value=1 />


<br>

</div>
<a id='msg' ></a><br>
<button id='AutoSave'>AutoSave</button>
<button id='AutoLoad'>AutoLoad</button><button id='StopAuto'>StopAuto</button><a id='autotxt' >---</a><br>

</body>

</html>