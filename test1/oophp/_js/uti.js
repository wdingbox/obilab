
function u_basename(pathfile_ext) {
   if(null == pathfile_ext || pathfile_ext.length==0) return "";//alert("jbase input is null");
   if( pathfile_ext.search("@") >=0 ) return "";
      var arr = pathfile_ext.split("/");
      var hid = arr[ arr.length-1].split(".")[0];
      return hid;
      
    return pathfile_ext.replace(/\\/g,'/').replace( /.*\//, '' );
}
function jbasenamexxxx(pathfile_ext) {
   if(null == pathfile_ext ) return "";//alert("jbase input is null");
      var arr = pathfile_ext.split("/");
      var hid = arr[ arr.length-1].split(".")[0];
      return hid;
      
    return pathfile_ext.replace(/\\/g,'/').replace( /.*\//, '' );
}
function u_src_of(s){
   s = u_basename(s);
   if( isNaN(s) ){
      s="../../odb/hiero/ccer-h/" +s+ ".gif";
   }
   else{
      s="../../odb/tbi/img/jgif/" +s+ ".gif";
   }
   //alert(s);
   return s;
}
function img_src_jqw(s){
}
function jdirname(path) {
    return path.replace(/\\/g,'/').replace(/\/[^\/]*$/, '');
} 
function jlinks2arr(linkstr) {
      var arr = linkstr.split(",");
      var arrHid = new Array(0);
      var i=0;
      for(i=0; i<arr.length; i++) {
         arr[i] = jQuery.trim(arr[i])
         if( null == arr[i] || ""==arr[i] ){
            //arr.splice(i,1);
            //alert("splice("+i);
            continue;
         }
         //alert("push="+arr[i]);
         arrHid.push(arr[i]);
      }
      for(i=0; i<arrHid.length; i++) {
         //alert("arrHid["+i+"]=="+arrHid[i]);
      }
      //alert("end");
      return arrHid;
}
function ctttttest(name,option) {

}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}







jQuery.cookie_history_sizexxxxxxxxxxxxxxxxxxxxxxx = function(name, value) {
    if (typeof value != 'undefined') { // name and value given, push to cookie hisotry
      value = eval(value);
      if( value.length==0) return alert("cookie_history value length is 0.");
      if( isNaN(value) ) return alert("history size is not a number.");
      
      $.cookie(name+"_size",eval(value));
    } else { // only name given, get cookie history
         var size = $.cookie( name+"_size" );
         if( null != size ) return size;
         alert(name+": no history size.set default to 20.");//default size.
         $.cookie(name+"_size",20);
        return 20;//alert(name+": no history size");//default size.
    }
};


jQuery.cookie_historyxxxxxxxxxxxxx = function(name, value) {
    if (typeof value != 'undefined') { // name and value given, push to cookie hisotry
      value = jQuery.trim(value);
      if( value.length==0) return alert("cookie_history value length is 0.");
      
      var chis = $.cookie( name );
      if( null == chis ) chis = value;
      var ar = chis.split(",");
      var iMax = ar.length;
      var iSize = $.cookie_history_size(name);
      if( iMax >iSize) iMax=iSize;
      chis =  value + ",";
      for(var i=0;i<iMax; i++ ) {
         var s = jQuery.trim(ar[i]);
         if( s.length ==0 )continue;
         if( s == value) continue;
         chis += s + ",";
      }
      $.cookie(name,chis);
    } else { // only name given, get cookie history
         var chis = $.cookie( name );
         if( null != chis ) return chis.split(",");
        return null;
    }
};
jQuery.cookie_history_poptailxxxxxxxxxxxxxxxxx = function(name) {
   var histarr = $.cookie_history(name);
   if( null==histarr ) return "";
   
   var size = $.cookie_history_size(name);
   //alert("cookie size="+size+",hist size="+histarr.length);
   var imax = histarr.length;
   if(imax>size) imax=size;
   imax-=2;
   //alert("imax="+imax);
   var chis="";
   for(var i=0;i<imax; i++ ) {
         var s = jQuery.trim(histarr[i]);
         if( s.length ==0 )continue;
         chis += s + ",";
   }
   //alert(chis);
   if(!confirm("To remove last one in history:"+histarr[imax]+".")) return;// alert("cancel");
   $.cookie(name,chis);
   //alert("ok");
   
};
