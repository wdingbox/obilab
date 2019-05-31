



$(document).ready(function(){

$("#bt").click(function(){
   // validate data quantity.
   $("#result").html("total(should be 5197)="+$(".b53").length);
   $(".b53").each(function(idx){
      var val=(1+idx) +".";
      var txt=$(this).text();
      if(val != txt ){
         $("#result").append("<br/>Err::Inconsistant Data: idx="+idx+",txt="+txt);
      }
   });

   // statistic calc process

   var stat=new Object();
   $("#result").append( "=="+$(".curio1").length );
   $(".curio1").each(function(idx){
      $("#result").append("<br/>"+(idx+1)+". ");
      var str = $(this).text();   
      var maxlen = str.length;
      if ( maxlen>100 ) {
         //alert(str);
         str=str.substring(0,maxlen);
         //alert(str);
      }
      $("#result").append( "[ "+str+" ]" );
      //$("#result").append( " ["+str.length+"] ");
      var i=0,iStart=0;

      for(i=0;i<maxlen-1;i++){
         var cc1=str.charCodeAt(i);
         var cc2=str.charCodeAt(i+1);
         if("12288"==cc1 && cc1==cc2 ) break;//space
      }
      iStart=i+1;
      var iMax=maxlen-1;//remove the last one as type.
      for(i=iStart;i<iMax;i++){
         var cc=str.charCodeAt(i);
         var cs=str.charAt(i);
         if(cc<256) continue;//ascii codes. may be more.
         if(12288==cc) continue;//space
         if(22120==cc) break;//for bad char, stop at Qi
         if(39006==cc) break;//for bad char, stop at Lei
         //if("/"==cs) break;
         $("#result").append("-"+cs+"("+cc+")");
         var key = cs+"("+ cc +")";
         if( undefined == stat[key] ) stat[key]=0;
         stat[key]+=1;
      }
   });
   
   // display stat results.
   
   var statRevSortArr = [];
   i=0;
   $.each(stat,function(key,val){
      //$("#result").append("<br/> @ "+key+"="+val);
      var sval="0"+val;
      while(sval.length<10){
         sval="0"+sval;
      }
      var key2="_" + sval + "__" + key;
      statRevSortArr.push(key2);
   });
   statRevSortArr.sort();
   statRevSortArr.reverse();
   i=0;
   var strDisp="";
   strDisp="<br/>stat output:<table border='1'> ";
   $.each(statRevSortArr,function(key,val){
      i+=1;
      strDisp+= "<tr><td> "+i+"</td><td>"+ val +"</td></tr>";
   });
   strDisp+= "</table>";
   //alert(strDisp);
   $("#result").append(strDisp);
});  ////////////




});//$(document).ready(function(){  