







<?php
@session_start();
require_once("../uti/Ureaddir.php");


require_once("../uti/MysqlJiaguwen.php");
require_once("../uti/MysqlHieroglyphics.php");

?>






<style type="text/css">

#mv2{
   border-color: #0000ff;
   border-style: solid;
   border-width: 1px;
}
#divajxmmsg{
   float:left;
}
div.clkimg{
   border-color: #ff0000;
   border-style: solid;
   border-width: 1px;
   float: left;
}
div.hidden{
   visibility:hidden;
   display: none;
}

img.mimg { 
   height:15px;
   width: 15px;
}
img.magified { 
   height:190px;
   width: 190px;
}
a.norm { 
   font-size: 12px;
}
div.cfg{
   float: top;
   border-color: #0000ff;
   border-width: 1px;
   border-style: solid;
   width: 600px;
}

div#histainer{
   float: top;
   border-color: #0000ff;
   border-style: solid;
   border-width: 1px;
   background-color:#ffaaff;
}
div.histi{
   float: left;
   border-color: #0000ff;
   border-style: solid;
   border-width: 1px;
   //background-color:#ffddff;
}
img.histimg{
   height:16px;
   width: 18px;
}
a.hista{
   font-size: 8px;
}
div#ajx_containter{
   float: top;
   border-color: #ffff00;
   border-style: solid;
   border-width: 1px;
}
div#dbg{
   float: top;
   background-color:#ffeefe;
}
a#ajxmmsg{
    background-color: #aabbff;
}
a#src_path{
    background-color: #ffffff;
}

textarea.cta{
rows:0;
cols:0;
}

a.m{
font-size:8px;
}
textarea.m{
FONT-SIZE: 8pt; 
LINE-HEIGHT: 10px; 
FONT-FAMILY: simsun,mssong,mingliu,arial;
}
</style>   



<script type="text/javascript">

jQuery(document).ready(function(){
   $("#mv2").hide();
   //alert($("#mv2").css("visibility"));
   //alert($("#mv2").css("display"));
   //alert($("#mv2").css("block"));
   
   
   function beep(){
      $("#src_path").html("<embed src='../_audio/a.wav' hidden=true autostart=true loop=false>");
   }
   
   $("a").mouseover(function(){
      
   });
   
   
   
   function ajxmmsg(){
      var s=',shft='+$("body").attr("shiftKey")+',ctr='+$("body").attr("ctrlKey");
      //s+=' ,bodymousedn='+$.cookie("bodymousedn");
      //s+=' ,mousedn='+$.cookie("mousedn");
      //s+=",imgovr="+$.cookie("imgovr")+ ",imgout="+$.cookie("imgout");
      //s+=",imgdn="+$.cookie("imgdn")+ ",imgup="+$.cookie("imgup");
      //s+=",aover="+$.cookie("aover");
      //s+=",dtovr="+$.cookie("dtovr");
      //s+=",dtout="+$.cookie("dtout");
      //s+=",dtdn="+$.cookie("dtdn");
      //s+=",dtup="+$.cookie("dtup");
      
      //s+=",textarea="+$("#ta").html();
      s+=",clickimg="+$.cookie("clickimg");
      
      
      s+=",("+ $("body").attr("mousex") + ","+ $("body").attr("mousey") + ")";
      
      s+=",";
      $("#ajxmmsg").css("font-size","12px").html(s);
   }
   
   
   $("body").mousemove(function(e){

      $("body").attr("mousex",e.pageX);
      $("body").attr("mousey",e.pageY);
      //beep();
      ajxmmsg();

      if( true != $("body").attr("shiftKey")){
         return;//released.
      }

       
       //var x = e.pageX;
       //if(x>$(window).width()/2) x=$(window).width()/2;
       $("#mv2").show().css( {  
                position: 'absolute', 
                zIndex: 5000, 
                left: e.pageX+10,  
                top: e.pageY+20 
        } ); 
   }).mousedown(function(e){
      //$.cookie("bodymousedn",1);
      ajxmmsg();
   }).mouseup(function(e){
      //$.cookie("bodymousedn",0);
      ajxmmsg();
   });
   


   
   
   function img_click_post_proc(){
      simg = u_basename( $.cookie("clickimg") );
      
      ajx_query_imgId(simg);
      show_clickimg_history();  
      
      //alert( arr );
      ajxmmsg();
   }
   function img_click_init_index_pos(eImg){
      var img_container_Id = "#clientarea";
      var img_horz_selector =" img[src!='']";
      var img_horz_curr_idx = eImg.index(img_container_Id + img_horz_selector);
      if( img_horz_curr_idx ==-1) {
         img_horz_curr_idx = eImg.index("#histainer img[src!='']");
         if(img_horz_curr_idx ==-1) {
            return ;//alert("img is not in searchable area");
         }
         img_container_Id = "#histainer";
      }
      $("body").attr("img_container_Id", img_container_Id);  
      
      $("body").attr("img_horz_selector", img_horz_selector);
      $("body").attr("img_horz_curr_idx", img_horz_curr_idx);
      
      
      //alert(img_horz_curr_idx);
      //img_horz_curr_idx++;
      
      //var imga = $(img_container_Id).find(img_horz_selector+":eq("+img_horz_curr_idx+")");
      //var curIdx = eImg.index(img_container_Id+" img[src!='']");//current index.
      
      //alert(imga.attr("src"));
      
      //
      //img position is dynamically calcuated.
      //
      var imgx0= eImg.position().left;
      var imgy0= eImg.position().top;
      //alert(imgx0);
      
      //$(img_container_Id).find("img[xpos!=''").attr("xpos","");//init imgx.
      
      $(img_container_Id).find("img[src!='']").each(function(idx){
         var xpos = $(this).position().left;
         var xmin = imgx0 - 10;
         var xman = imgx0 + 10;
         if(xpos >= xmin && xpos <= xman ) {//in range.
            $(this).attr("xpos", "xpos="+xpos);
            //$(this).attr("alt", "xpos="+xpos);
         }
         else{
            $(this).attr("xpos", "");
            //$(this).attr("alt", "");
         }
      });
      
      var img_vert_selector = " img[xpos=='']";
      var img_vert_curr_idx = eImg.index(img_container_Id + img_vert_selector);
      $("body").attr("img_vert_selector", img_vert_selector);
      $("body").attr("img_vert_curr_idx", img_vert_curr_idx);
      
      //alert(eImg.attr("xpos") + ",img_vert_curr_idx="+img_vert_curr_idx);
      //img_vert_curr_idx++;
      //var imgnext = $(img_container_Id).find(img_horz_selector+":eq("+img_horz_curr_idx+")");
      //alert("img next="+imgnext.attr("xpos") + ",sz="+$(img_container_Id).find(img_vert_selector).length);
      //var curIdx = eImg.index(img_container_Id+" img[src!='']");//current index.
   }
   function img_next(inc, selName, inxName){
      if(1!=$("body").attr("img_enable_key_walk")){
         return;
      }
         var img_container_Id = $("body").attr("img_container_Id");  
         
         var img_vert_selector = $("body").attr(selName);
         var img_vert_curr_idx = $("body").attr(inxName);
         
         var oImg = $(img_container_Id).find(img_vert_selector+":eq("+img_vert_curr_idx+")");
      
         img_click_highlit(oImg,"#ffffff");//store color
         
         if(1==inc) img_vert_curr_idx++;
         else if(-1==inc) img_vert_curr_idx--;
         else alert(0);
         
         if(img_vert_curr_idx<0) alert("no more");
         if(img_vert_curr_idx>=$(img_container_Id).find(img_vert_selector).length) alert("end");
         
         oImg = $(img_container_Id).find(img_vert_selector+":eq("+img_vert_curr_idx+")");
         img_click_highlit(oImg,"#ff0000"); //hi lite color
         $("body").attr(inxName,  img_vert_curr_idx);
         
         simg = u_basename( oImg.attr("src") );
         ajx_query_imgId(simg);
   }
   function img_next_ll(inc){
      img_next(inc, "img_vert_selector", "img_vert_curr_idx");
   }
   function img_next_ff(inc){
      img_next(inc, "img_horz_selector", "img_horz_curr_idx");
   }
   
   function img_click_highlit(eImg,clor){
      //return;
       //alert(eImg.parent().get(0).tagName);
      $("img[img_dad_orig_bkcolor!='']").each(function(){
         var Oldclr = $(this).attr("img_dad_orig_bkcolor");
         //if( $(this).parent().get(0).tagName == "DIV"){
            $(this).parent().css("background-color",Oldclr);
         //}
      });
      var opar = eImg.parent();
      if( opar.find("img").length!=1) return;//only support 1 img per container.
      //if( !opar ) return;
      //if( "DIV"!=opar.get(0).tagName) return;
      eImg.attr("img_dad_orig_bkcolor",opar.css("background-color"));
      opar.css("background-color",clor);
   }
   function img_click_toggle_color(eImg,clor){

      var opar = eImg.parent();
      if( opar.find("img").length!=1) return;//only support 1 img per container.
      //if( !opar ) return;
      //if( "DIV"!=opar.get(0).tagName) return;
      if( opar.css("background-color") != clor){
         opar.css("background-color",clor);
      }
      else{
         opar.css("background-color","");
      }
   }
   
   $("img").click(function(){
      if($("#mv2").css("display")=="none") return;
      var simg = $(this).attr( "src" );
      simg = u_basename(simg);
      
      if(null == simg || ""==simg) return $("#ajxmmsg").text("img src is empty.");
      
      if( 1==$("body").attr("enable_sql_set_valu_on_img")) {
         var sql2 = $("body").attr("sql_set_valu_on_img");
         if( sql2.search("Jiaguwen") > 0 ) {
            if( isNaN(simg) ) {
               return alert(simg + " is not correct for sql:"+sql2);
            }
         }
         else if( sql2.search("Hieroglyphics") > 0 ){
         }
         else{
            return alert("Err set sql : "+sql2);
         }
         if( sql2.length>0) {
            sql2+=simg+"'";
            $("#src_path").text(sql2);
            $("#mdata").find("img").remove();
            $("#mdata").find("a").remove();
            //alert(sql2);
            ajx_update_sql(sql2);
            return;
         }
      }
      
      
      var imghist = Get_que_hist_channel_name();
      
      //delete img if in del mode.
      if($("img").css("cursor") == "crosshair"){
         var odiv = $(this).parent();
         var divId = odiv.attr("id");
         if( divId == "histi" ) {
            if( confirm("To remove img "+simg) ){
               $.cookie_history(imghist, simg, -1);  //also remove in history.
               odiv.remove();
               return;
            }
            else return;
         }
         else return alert(simg + " can't be killed. "+".\n\npress 'k' to change mode.");
      }    

      
      ////store last clik in cookie.
      $.cookie("clickimg",simg);
      
      //store in most recent history que.
      $.cookie_history_size(imghist, 50);
      $.cookie_history(imghist, simg);  
      

      //
      if(1==$("body").attr("img_enable_key_walk")){
         if(confirm("Start to set this img as start point to walk by key(d,D,f,F).")) {
            img_click_init_index_pos($(this));
            img_click_highlit($(this),"#ff0000");
         }
      }
      else {
         img_click_toggle_color($(this),"#ff0000");
      }
      
      img_click_post_proc();
      //ajxmmsg();
      
   });
   $("img").mouseover(function(){
      if($("#mv2").css("display")=="none") return;
      //beep();
      //alert($("body").attr("ctrlKey"));
      if(true==$("body").attr("ctrlKey")){
         
         $("#ajxmmsg").css("font-size","10px").text("enter");
         var imgid = $(this).attr("src");
         imgid = u_basename(imgid);
         ajx_query_imgId(imgid);
         beep();
      }
      ajxmmsg();
   });
   $("img").mouseout(function(){
      ajxmmsg();
   });
   $("img").mousedown(function(e){
      $("#mdata").attr("img_mousedwon_src",u_basename($(this).attr("src")));
      ajxmmsg();
      });
   $("img").mouseup(function(e){
      $("#mdata").attr("img_mousedwon_src","");
      ajxmmsg();
   });
   $("img").mousemove(function(e){
      //var img = $(this).attr("src");
      //kill_mouseover_img($(this));
      ajxmmsg();
   });
   
   
   $("#mtitle td").click(function(e){
      var idx = $(this).index();
      var colname = $("#mtbl").attr("tbltype")+idx;
      //alert(colname);
      if( $(this).attr(colname) != "red") {
          $(this).attr(colname,"red");
          //$(this).css("color","#ff0000");
      }else{
         $(this).attr(colname,"");
         //$(this).css("color","#000000");
      }
      ajx_query_imgId($.cookie("clickimg"));
   });
   
   $("#mdata >td").mouseover(function(e){

      var indx = $(this).index();
      var col = $("#mtitle").find("td:eq("+indx+")").text();
      var isValid=0;
      
      var keyid ="";
      if($("#mtitle").find("td:eq(0)").text() == "idx"){
         keyid = $("#mdata").find("td:eq(1)").find("img:eq(0)").attr("src");   
      }
      else{
         keyid = $("#mdata").find("td:eq(0)").find("img:eq(0)").attr("src");
      }
      keyid = u_basename(keyid);
      //alert(keyid);
      
      //
      //drop on dt when button is released.
      var dragimg = $("#mdata").attr("img_mousedwon_src");//get drag img src.
      $("#mdata").attr("img_mousedwon_src","");//must set drag img to empty.
      if( typeof (dragimg) != "undefined" && dragimg != ""  ){ 
            if("jtoh"==col || "jink"==col || "hink"==col || "htoj"==col){
               var isDup=0;
               $(this).find("a").each(function(i){
                  if($(this).text()==dragimg){
                     isDup=1;
                  }
               });
               if(0==isDup){
                  if( isNaN(dragimg) ){
                     if("jtoh"==col ||  "hink"==col ){
                        isValid = 1;
                     }
                  }
                  else{
                     if("jink"==col ||  "htoj"==col ){
                        isValid = 1;
                     }
                  }   
               } 
               else return alert(dragimg+" : already exist in col "+col);
            }
            if(1==isValid){
               if(keyid==u_basename(dragimg)){
                  if( confirm(dragimg+" : is same btw key and item in " + col) ){
                  }
                  else return;
               }
            }
            
            if(1==isValid){
                     clone_div_imgId("#histi",dragimg).appendTo($(this));
                     toggle_zoom_img();
            }else return alert(dragimg+" : is not allowed to put in " + col);
      };
      ajxmmsg();
   }).mouseout(function(e){
     
      ajxmmsg();
   }).mousedown(function(e){
      
      ajxmmsg();
   }).mouseup(function(e){
      
      ajxmmsg();
   });
   
   
   
      

   
   $("textarea").focus(function(){
      //alert("a");
      $("#mv2").attr("disableKeypress",1);
      $("#ajxmmsg").text("disableKeypress=1");
      
      $(this).css("background-color","lightyellow");
      $(this).css("color","#ff0000");
      //$(this).attr("color","#ff0000");
      //alert(ss);
   }).blur(function(){
      //alert("a");
      $("#mv2").attr("disableKeypress",0);
      $("#ajxmmsg").text("disableKeypress=0");
      //if($(this).parent().attr("class")=="td") {
         //$("#mbutton").focus();
      //}
      
      $(this).css("background-color","");
      $(this).css("color","");
      $("#src_path").text(gen_sql_str_fr_tbl());
      
      
         var ss = $(this).parent().get(0).tagName;
         if("TD"==ss){
            var valu = $(this).text();
            var indx = $(this).parent().index(); //td.
            var titl = $(this).parent().parent().parent().find("tr:eq(0)").find("td:eq("+indx+")").text();//tr.
            var sql = gen_sql_str_fr_tbl();
            var arr = sql.split("SET ");
            var sql2 = arr[0] + " SET " + titl + "='" + valu + "' ";
            //alert(title+valu + arr[0]);
            arr = sql.split("WHERE ");
            var whid = arr[1];
            sql2+=" WHERE " + whid.split("=")[0] + "='";
            //alert(title+valu + whid.split("=")[0]);

            //alert(sql2);
            $("body").attr("sql_set_valu_on_img",sql2);  
         }
      
   });
   
   $("#mbutton").focus(function(){
      $(this).css("background-color","#ff0000");
   }).blur(function(){
      move_to_mouse_before_focus();
      $("#init_focus").focus();
      $(this).css("background-color","");
   });
   $("#mbutton").click(function(){
      ajx_update();
   });
   
   $("#init_focus").focus(function(){
      $(this).css("background-color","#ff0000");
   }).blur(function(){
      $(this).css("background-color","");
   }).click(function(){
      toggle_historyChan(-1);
      show_clickimg_history();  
   });
   $("#help").click(function(){
      img_click_post_proc();
      show_usage();
   });
   
   
   function toggle_img_enable_key_walk(){
      var flag = $("body").attr("img_enable_key_walk");
      if(1!=flag){
         $("body").attr("img_enable_key_walk",1);
      }
      else{
         $("body").attr("img_enable_key_walk",0);
         
      }
   }

   function toggle_enble_sql_set_valu_on_img(){
      //$("body").attr("sql_set_valu_on_img","");
      
      if( 1==$("body").attr("enable_sql_set_valu_on_img") ){
         $("body").attr("enable_sql_set_valu_on_img",0);
         alert("turn off p");
         $("body").attr("sql_set_valu_on_img","");
         $("img").css("cursor", "");
         $("body").attr("shiftKey",false);//
      }
      else{       
         var sql = $("body").attr("sql_set_valu_on_img");
         
         if(typeof (sql) =="undefined" ) {
            return alert("Please set a value first before toggle to 'p' state.");
         }
         var ss = "toggle to Enable feature to set value on clicked img.\n\n ";
         ss+=sql+"[what your clicked img]'\n\n\n.";
         ss+="Usage:\n-click column then editable textarea.\n-start to click img.\n\n";
         if(confirm(ss)){
            $("body").attr("enable_sql_set_valu_on_img",1);
            $("img").css("cursor", "hand");
            $("body").attr("shiftKey",true);//  
            
         }
      }
   }
   
   
   
   
   
   $("body").keypress(function(e){
      //alert($("#mv2").css("display"));
      if($("#mv2").css("display")=="none") return;
      //alert(e.type + ": " +  e.which );
      var k = e.which;
      switch( k ) {
         case 13: return ;//enter
         case 24: return ;//ctr+x
      }
      beep();      
      
      if($("#mv2").attr("disableKeypress")==1) return;
      
      var schar = String.fromCharCode(k); 
      //alert(schar);


      switch(schar) {
      
      case 13://enter
      break;

      
      case 'k'://d : toggle database.
         toggle_del();
      break;   
      
      case 's'://s: Set img start point.
         toggle_img_enable_key_walk();
      break;
      
      case 'f'://f: foward img
         img_next_ff(1);
      break;
      case 'F'://F: backward img
         img_next_ff(-1);
      break;
      case 'd'://d: left low.
         img_next_ll(1);
      break;
      case 'D'://D: Vertical up.
         img_next_ll(-1);
      break;
      
      //case 113://q: que img history
         
      //break; 
      case 'e'://e: execute sql
         ajx_update();
      break;
      case 'r'://r: read fr db
         ajx_query_imgId($.cookie("clickimg"));
      break;

      case 'u'://u: undo update
         undo_last_update();
      break;
      case 'U'://u: undo update
         Undo_last_update();
      break;
      
      
      //case 120://x
      case 'X'://ctr x:
         
      break;
      case 'z'://z
         toggle_zoom(1);
      break;
      case 'c'://c:chan
         toggle_historyChan(1);
      break;
      case 'C'://c:chan
         toggle_historyChan(-1);
      break;
      case 'l'://v: view automatically move over
         toggle_vv();
      break;
      
      case 'p'://p: view automatically move over
         toggle_enble_sql_set_valu_on_img();
      break;
      
      case 'o':
         window.open("window_autorefresher.php",'_blank', 'left=0,top=0,width=2000,height=1000,resizable=yes,scrollbars=yes,toolbar=no,location=no,directories=no,statusbar=no,menubar=no');
      break;
      
      
     
      case  ' '://space
         //space_bar_fix_last_click();
      break;
      case 'q'://g
         //space_bar_fix_last_click();
         debug();
      break;
      default:
         
         show_usage(e );
      break;
      }
      //showcfg(e);
      show_clickimg_history();  
   }).keyup(function(e){
      $("body").attr("shiftKey",e.shiftKey);
      $("body").attr("ctrlKey",e.ctrlKey);
   }).keydown(function(e){
      $("body").attr("shiftKey",e.shiftKey);
      $("body").attr("ctrlKey",e.ctrlKey);
   });
   
   function kill_mouseover_img(elm){
      
      
   }

   function show_usage(e){
      var s="";
      if(typeof(e) != 'undefined'){
         s=e.type + "= " +  e.which;
         s+= "   (The key is not used. Please see following Menu for Help.)";
      }
      s+="\n---------- Function Keys -------------\n\n";
      s+="s: set img to go by key.\n";
      
      s+="q: sql string display.\n\n";
      s+="e: execute the sql update.\n\n";
      
      s+="r: read row data of last clicked img fr db.\n\n";
      
      s+="f: read foward; F:backward\n";
      s+="d: read down; D:up\n\n";
      
      s+="u: undo last sql execution. U:keep last update.\n\n";
      s+="k: del img that mouse is over.\n\n";
      
      
      s+="z: zoom img\n";
      //s+="ctr x: menu mobile mode\n";
      s+="c: change history channel. C:reverse.\n";
      
      s+="\n";
      s+="p: patch set data by click img.\n";
      
      s+="-----------\n";
      s+="Shift + mousemove: move menu.\n";
      s+="Ctrl  + mouseover: read.\n";
      
      
      

      alert(s);
   }
   
   function show_clickimg_history(){
      $("#histainer").children().remove();
       
      var ichan = $("#histainer").attr("historyChan");
      switch( ichan ) {
         case 0: $("#histi").css("border-color","#0000ff"); break;
         case 1: $("#histi").css("border-color","#ff0000"); break;
         case 2: $("#histi").css("border-color","#ffff00"); break;
      }
      $("#init_focus").attr("value",ichan);
      var imghist = Get_que_hist_channel_name();
      var arr = $.cookie_history(imghist) ;
      if(null == arr) return ;//alert("cookie history data is none."); 
      
      
      for( var i=0;i<arr.length-1;i++){
         clone_div_imgId("#histi",arr[i]).appendTo($("#histainer"));
      };
      
      $("#histainer").find("img").css("width","18px").css("height","16px").removeClass("histimg").attr("id","");
      if($("#history").attr("clickimgsizeidx")==1){
         $("#histainer").find("img").css("width","36px").css("height","32px");
      }
   }
   function clone_div_imgId(divId,imgId){
         var o = $(divId).clone(true).show();
         //$(divId).removeClass("clkimg");

         o.find("a:eq(0)").text(imgId);
         var src = u_src_of(imgId);
         o.find("img:eq(0)").attr("src", src).attr("alt",src);
         return o;
         
         //o.appendTo($(apnd2id));
   }
   
   $("#seedimg").click(function(){
      if($(this).parent().parent().attr("id")!="history") return;
      //alert($(this).parent().parent().attr("id"));
      if($("#history").attr("clickimgsizeidx")==1){
         $("#history").attr("clickimgsizeidx",0);
      }
      else{
         $("#history").attr("clickimgsizeidx",1);
      }
      //alert($("#history").attr("clickimgsizeidx"));
      show_clickimg_history();
   });
   
   $("a.norm").each(function(){
      var href = $(this).attr("href");
      if( null == href ) return;
      $(this).text( href );
   });
   
      
   function debug(){
      var ss="<br>\n";
      ss+=gen_sql_str_fr_tbl()      + "     ....cur<br>\n";
      ss+=$("#mtbl").attr("sql_tmp")+ "     ....tmp<br>\n";
      ss+=$.cookie("sql_new")+ "     ....last update<br>\n";
      ss+=$.cookie("sql_old")+ "      ....before last update<br>\n";
      $("#ajxmmsg").css("background-color","#aaffaa").html(ss);
      
   }
   function gen_sql_str_fr_tbl(){
      var otbl = $("#ajx_containter").find("table:eq(0)");
    
      var sql_where=" WHERE ";
      var sql_updat="UPDATE ";
      var sql_set="";
      $("#mtitle").find("td").each(function(idx){
         var otd = $("#mdata").find("td:eq("+idx+")");
         var colname = $(this).text();
         switch(colname){
            case "idx":
            break;
            case "jid":
               sql_where += colname +"='" + otd.find("a:eq(0)").text() + "'";
               sql_updat += "Jiaguwen ";
            break;
            case "hid":
               sql_where += colname +"='" + otd.find("a:eq(0)").text() + "'";
               sql_updat += "Hieroglyphics ";
            break;
            case "zid":
            break;
            case "freq":
            break;
            case "jmn":
            break;
            case "rid":
               //sql_updat+=" SET "+colname + "='";
               sql_set+=", "+colname + "='";
               sql_set+=otd.find("a:eq(0)").text() + "'";
            break;
            case "hink":
            case "htoj":
            case "jink":
            case "jtoh":
               sql_set+=", "+colname + "='";
               otd.find("a").each(function(i){
                  sql_set+=$(this).text() + ",";
               });
               sql_set+="'";
            break;
            case "pyn":
            case "eng":
            case "descr":
            case "L":
            case "xa":
            case "xb":
            case "xc":
            case "zid1":
               sql_set+=", "+colname + "='";  
               if(otd.find("textarea").length>0) {
                  sql_set+= $.trim( otd.find("textarea:eq(0)").html() );
               }
               else {
                  sql_set+= $.trim( otd.text() );
               }
               
               sql_set+="'";
            break;
            default:
               //sql_updat+=colname;
            break;
         }
      });
      
      sql_set=sql_set.substring(1);
      
      var sql=sql_updat+ " SET " + sql_set + sql_where;
      //$("#ajxmmsg").text("sql="+sql);
      return sql;
   }
   
   
   

   function ajx_query_imgId(keyval){
      if(null == keyval || ""==keyval) return $("#ajxmmsg").text("img src id is empty.");
      $("#ajxmmsg").text("query img src id:"+u_src_of(keyval));
     
      $("#src_path").css('background-color', '').text(u_src_of(keyval));
         //alert(keyval);
                        $.post("../uti/svc/i_query.php", 
                            {   
                              
                              keyval:  keyval
                            },
                            function(data, status){
                              if(data.search("err")>=0) {
                                 $("#ajxmmsg").css("color","#ff0000");//text(data.substr(0,90)).show();
                              }
                              else{
                                 $("#ajxmmsg").css("color","#000000");
                              }
                              //$("#ta").prepend(status+"<br>");
                              
                              //passed data is a htm table.
                              var tbltype = $(data).find("tr:eq(0)").find("td:eq(0)").html().toString();
                              tbltype += $(data).find("tr:eq(0)").find("td").length + "-";
                              $("#mtbl").attr("tbltype",tbltype);
                              
                              
                              //make clone of table data in order to enable event 
                              //since html() does not support event.
                              $(data).find("tr").each(function(indxTR){
                              
                                 //clear and remove chidren of each td.
                                 var otr = $("#mtbl").find("tr:eq("+indxTR+")");
                                 otr.find("td").each(function(){
                                    $(this).css("color","#000000").text("").children().remove();
                                 });
                                 
                                 //copy this data to append to real td.
                                 $(this).find("td").each(function(indxTD){
                                    var otd = otr.find("td:eq("+indxTD+")");
                                    var otdTitle = $("#mtitle").find("td:eq("+indxTD+")"); 
                                    var attrVale = otdTitle.attr(tbltype+indxTD);
                                    
                                    if( $(this).find("img").length>0) {
                                        $(this).find("a").each(function(idxIMG){
                                             var ssrc = $(this).text();
                                             clone_div_imgId("#histi",ssrc).appendTo(otd);
                                        });
                                    }else if ( $(this).find("textarea").length>0) {
                                       var ss=$(this).find("textarea:eq(0)").html();
                                       
                                       if( attrVale != "red" ){
                                           otdTitle.css("color","#000000");
                                           otd.text(ss).css("color","#0000ff");                                                  
                                       }else{
                                           otdTitle.css("color","#ff0000");
                                           //$("#ta").hide();
                                           $("#ta").clone(true).show().attr("rows","9").attr("cols","9").
                                              appendTo(otd).html(ss); 
                                       } 
                                    }else {
                                       otd.html( $(this).html() );
                                    }
                                 });
                              });       
                              
                              $("#mtbl").attr("sql_tmp", gen_sql_str_fr_tbl());
                              
                              if($("#mdata").find("textarea").length>0){
                                 move_to_mouse_before_focus();
                                 $("#init_focus").focus();
                              }
                              toggle_zoom_img();
                              return;
                           },
                            "datastring"
            );// post    
   }

   function move_to_mouse_before_focus(){
               var x = 20+$("body").attr("mousex");
               var y = 20+$("body").attr("mousey");                
               var dlty = y - $("#mv2").position().top ;
               if(dlty<0) dlty=-1*dlty;
               //alert(dlty);
               if( dlty > 500 ){
                  $("#mv2").css( {left: x, top: y} );
               }
   }
   function ajx_update(){
      var sql_new = gen_sql_str_fr_tbl();
      var sql_old = $("#mtbl").attr("sql_tmp");
      if(sql_new == sql_old) {
         $("#src_path").text("old new same sql:"+sql_new);
         return;
      }
      $.cookie("sql_new", sql_new);
      $.cookie("sql_old", sql_old);
      ajx_update_sql(sql_new);
   }
   function ajx_update_sql(sql){
                     $.post("../uti/svc/i_update_sql.php", 
                            {   
                               sql:   sql,
                               dump:  "-"
                            },
                            function(data, status){
                              $("#src_path").text(data);
                              $("#src_path").css('background-color', '#eeddee');
                              if(data.search("err")!=-1) {
                                 $("#mbutton").css('background-color', '#ff0000');
                                 $("#src_path").css('background-color', '#ff0000');
                               //  $("#addid").attr("id","");
                                // return alert(data);
                              }  
                              else{
                                 $("#mbutton").css('background-color', '');
                                 $("#src_path").css('background-color', '');
                              }
                           },
                            "datastring"
            );// post    
   }
   function undo_last_update(){
      var sql = $.cookie("sql_old");
      if( confirm("The last update is rollbacked to its original:\n"+sql) ){
         ajx_update_sql(sql);
      }
      else alert("canceled");
   }
   function Undo_last_update(){
      var sql = $.cookie("sql_new");
      if( confirm("Keep last update:\n"+sql) ){
         ajx_update_sql(sql);
      }
      else alert("canceled");
   }
   
     
   
 

   
   
 
   
   
   function toggle_del(){
      if($("img").css("cursor") != "crosshair"){
         $("img").css("cursor", "crosshair");
      }else{
         $("img").css("cursor", "");
     }

   }

   function toggle_ex(){
         
   }
   
   function toggle_vv(){
      var s=$("#ajx_containter").html();
      $("#ajxmmsg").css("font-size","10px").text(s);   
   }
   function Get_que_hist_channel_name(){
      var histchan = "imghis"+toggle_historyChan(0);
      return histchan;
   }
   function toggle_historyChan(inc){
         var op = $("#histainer").attr("historyChan");
         if( typeof op == 'undefined' ) {
            //alert("op="+op);
            $("#histainer").attr("historyChan",0);
            op = -1;
         }
         if(typeof inc != 'undefined' && 0==inc){
            return op;
         }
         else if( 1== inc) op++;
         else if(-1== inc) op--;
         else{
            return alert("errrrr");
         }
         
         if(10<=op) op=0;
         if(-1>=op) op=9;
         if(9==op || 0 ==op ) beep();
         //alert("as="+op);
         $("#histainer").attr("historyChan",op);
         return op;
   }
   function toggle_zoom(inc){
         var op = $("#mtbl").attr("zoom");
         //alert(op);
         if( null==op || ""==op || typeof (op) == "undefined") {
            op=0;
         }
         
         //op=parseInt(op);//=op + eval(inc);alert(op);
         op++;
         if( 4==op) op=0;
         
         
         $("#mtbl").attr("zoom",op);
         toggle_zoom_img();
      }
    function toggle_zoom_img(){
         var op = $("#mtbl").attr("zoom");
         
         $("#mtbl").find("div").css("border-color","#0000ff");
         var width = $("#mtbl").find("img").css("width");
         switch(op){
         case 3:
            $("#mtbl img").css("width","200px");
            $("#mtbl img").css("height","200px");
         break;
         case 2:
            $("#mtbl img").css("width","120px");
            $("#mtbl img").css("height","120px");
         break;
         case 0:
            $("#mtbl img").css("width","20px");
            $("#mtbl img").css("height","20px");           
         break;
         default:
            $("#mtbl").attr("zoom",1);
            $("#mtbl img").css("width","65px");
            $("#mtbl img").css("height","65px");

         break;
         }   
   }
   


   $("#mhide").click(function(){
      $("#mv2").hide();
      alert("Shift + mousemove => show");
   });
   
});
</script>

	





<div id="mv2">
    <table><tr><td id="history">
        <div class="histi" id="histi"><a class="hista">*</a><br><img class="histimg" alt="click to zoom history." id="seedimg" /></div>
        <div class="histi" id="histi"><button id="init_focus" alt="init focus">c</button></div>
        

        <div id="histainer"> </div>
        </td></tr>
    </table>    
    
    
    <div id="ajx_containter"> 
        
        <table  id="mtbl" border="1" bgcolor="#a0e0f0">
        <tr id="mtitle">
            <td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/>
        </tr>
        <tr id="mdata">
            <td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/>
        </tr>
         </table>
         <button id="mbutton">e</button>
         <button id="help">?</button>
         <button id="mhide">x</button>
         <textarea id="ta" rows='1' cols='1'>ttaa</textarea><a id="src_path">...</a>
         
         <table><tr><td>
         <a id="ajxmmsg">Press 'h' for help;  </a> 
         </td></tr></table>
    </div>
    

   
    <div id="divajxmmsg">
    
    </div>
   
</div>




<div id="clientarea">














