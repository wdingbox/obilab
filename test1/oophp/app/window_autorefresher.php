<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
                <title>sql2tbler</title>

                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

    <style type="text/css" media="screen">
    .container{
    float: left; 
    width:100%;
    border: 1px solid #777;
    background-color: yellow;
    padding:0px;
    margin: 0 0 0px 0px;
    }
    .urlstr{
        width: 98%;
    }
    input.tms{
        width: 2em;
    }
    </style>

</head>







<body>

    <script type="text/javascript">

    jQuery(document).ready(function(){
    //window.close();
    //refreshiframe();
    //setTimeout(refreshiframe, 1000);
    refreshiframe();
    function refreshiframe(){
      var idelay  = $("#time").val();
      if(idelay<=0) $("#time").val(1);
      setTimeout(refreshiframe, idelay*1000);
      
      var isEnableAutoRefresh = $("#enable_autorefresh").attr("checked");
      if( !isEnableAutoRefresh) return;
      
      
      var idimg = $.cookie("clickimg");
      
      var sUrl = "./sql2tbler.php";
      sUrl = "./statistic_children_of.php";
      
      //sUrl +="?sql="+ get_sql_for_lister(idimg);//get_sql_for_tbler(idimg);
      sUrl +="?idimg="+idimg;
      
      $("#url").val(sUrl);
      if( idimg != $("body").attr("idimg")){
         $("body").attr("idimg",idimg);
         $("body").attr("timeout_counter",0);
         $("#myFrame").attr("src",sUrl);
         var src = u_src_of(idimg);
         //$("#idimg").attr("src",src);
         $("#counter").text(100);
      }
      else{
         var timeout_counter = $("#counter").text();
         if( timeout_counter <0){
            window.close();
         }
         timeout_counter--;
         $("#counter").text(timeout_counter);
      }
    }
    function get_sql_for_tbler(idimg){
      var sql="";
      if(isNaN(idimg)){
         sql = "SELECT * FROM Hieroglyphics WHERE hink  LIKE '";
      }
      else{
         sql = "SELECT * FROM Jiaguwen WHERE jink  LIKE '";
      }
      sql+="%25";
      sql+=idimg + ",";
      sql+="%";
      sql+="'";
      return sql;
    }
    function get_sql_for_lister(idimg){
      var sql="";
      if(isNaN(idimg)){
         sql = "SELECT hid FROM Hieroglyphics WHERE hink  LIKE '";
      }
      else{
         sql = "SELECT jid FROM Jiaguwen WHERE jink  LIKE '";
      }
      sql+="%25";
      sql+=idimg + ",";
      sql+="%";
      sql+="'";
      return sql;
    }
    
    /////////////
    
    $("#statitis_option").change(function(){
      var sUrl = $(this).val();
      $("#myFrame").attr("src",sUrl);
    });
    });
    //-->
    </script>

<div class="container">
    <button onclick="document.getElementById ('time').value--;">-</button> <button onclick="document.getElementById ('time').value++;">+</button>
    <input class="tms" type="text" id="time" name="time" value="3"/>
    <input type="checkbox" id="enable_autorefresh" checked='1'>auto-refresh</input>
    <select id="statitis_option">
    <option></option>
    <option>statistic_jink_uniq.php</option>
    </select>
    <a id="counter" >100</a>
    
    <input class="urlstr" type="text" id="url" name="url" value="http://css.maxdesign.com.au/floatutorial/index.htm"/>
</div>
<div class="container">
    <iframe id="myFrame"
            src="http://css.maxdesign.com.au/"
            width="100%"
            height="9000"
            frameborder="no"
            framespacing="5">
    </iframe>
</div>

<br>


</body>
</html>

