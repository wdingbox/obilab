
$(document).ready(function(){

$("#bt").click(function(){
   var stat=new Object();
   $("#result").html("");
   $("#result").append( $(".curio1").length );
   $(".curio1").each(function(idx){
      $("#result").append("<br/>"+(idx+1)+":");
      var str = $(this).text();   
      var maxlen = str.length;
      if ( maxlen>90 ) {
         //alert(str);
         str=str.substring(0,maxlen);
         //alert(str);
      }
      //$("#result").append( str );
      //$("#result").append( " ["+str.length+"] ");
      var i=0,iStart=0;

      for(i=0;i<maxlen-1;i++){
         var cc1=str.charCodeAt(i);
         var cc2=str.charCodeAt(i+1);
         if("12288"==cc1 && cc1==cc2 ) break;//space
      }
      iStart=i+1;

      for(i=iStart;i<maxlen;i++){
         var cc=str.charCodeAt(i);
         var cs=str.charAt(i);
         //if(cc<256) continue;
         if(39006==cc) break;
         //if("/"==cs) break;
         $("#result").append("-"+cs+"("+cc+")");
         if( undefined == stat[cs] ) stat[cs]=0;
         stat[cs]+=1;
      }
   });
   //////////////////////
   var srtedStat = [];
   i=0;
   $.each(stat,function(key,val){
      //$("#result").append("<br/> @ "+key+"="+val);
      var sval="0"+val;
      while(sval.length<10){
         sval="0"+sval;
      }
      var key2="_" + sval + "__" + key;
      srtedStat.push(key2);
   });
   srtedStat.sort();
   $.each(srtedStat,function(key,val){
      $("#result").append("<br/> @ "+val);
   });
});  ////////////




});//$(document).ready(function(){  