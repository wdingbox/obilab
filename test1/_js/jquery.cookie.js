/**
 * Cookie plugin for JQuery
 *
 *
 */

/**
 * Create a cookie with the given name and value and other optional parameters.
 *
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Set the value of a cookie.
 * @example $.cookie('the_cookie', 'the_value', { expires: 7, path: '/', domain: 'jquery.com', secure: true });
 * @desc Create a cookie with all available options.
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Create a session cookie.
 * @example $.cookie('the_cookie', null);
 * @desc Delete a cookie by passing null as value. Keep in mind that you have to use the same path and domain
 *       used when the cookie was set.
 *
 * @param String name The name of the cookie.
 * @param String value The value of the cookie.
 * @param Object options An object literal containing key/value pairs to provide optional cookie attributes.
 * @option Number|Date expires Either an integer specifying the expiration date from now on in days or a Date object.
 *                             If a negative value is specified (e.g. a date in the past), the cookie will be deleted.
 *                             If set to null or omitted, the cookie will be a session cookie and will not be retained
 *                             when the the browser exits.
 * @option String path The value of the path atribute of the cookie (default: path of page that created the cookie).
 * @option String domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).
 * @option Boolean secure If true, the secure attribute of the cookie will be set and the cookie transmission will
 *                        require a secure protocol (like HTTPS).
 *
 * @name $.cookie
 */

/**
 * Get the value of a cookie with the given name.
 *
 * @example $.cookie('the_cookie');
 * @desc Get the value of a cookie.
 *
 * @param String name The name of the cookie.
 * @return The value of the cookie.
 * @type String
 *
 */
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};




jQuery.cookie_history_size = function(name, value) {
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


jQuery.cookie_history = function(name, value, option ) {
    if (typeof value != 'undefined') { // name and value given, push to cookie hisotry
      value = jQuery.trim(value);
      if( value.length==0) return alert("cookie_history value length is 0.");
      
      var chis = $.cookie( name );
      if( null == chis ) chis = "";
      var ar = chis.split(",");
      var iMax = ar.length;
      var iSize = $.cookie_history_size(name);
      if( iMax >iSize) iMax=iSize;
      var hist =  "";
      for(var i=0;i<iMax; i++ ) {
         var s = jQuery.trim(ar[i]);
         if( s.length ==0 )continue;
         if( s == value) continue;
         hist += s + ",";
      }
      if( "-1" != option) {
         hist = value+","+hist;
      }
      $.cookie(name,hist);
    } else { // only name given, get cookie history
         var chis = $.cookie( name );
         if( null != chis ) return chis.split(",");
        return null;
    }
};
jQuery.cookie_history_poptail = function(name) {
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









