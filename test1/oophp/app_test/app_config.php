<!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
                <title>j</title>

                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>
                


                <!-- Users  -->
</head>
<body bgcolor="<?php echo '#eeeeee'; ?>">	
<a href="../audio/a.wav" id="aa">Play Sound</a>
<a href="../audio/c.wav">Play Sound</a>
<embed src="../audio/a.wav" autostart=true loop=false id="a1">
<embed src="../audio/c.wav" autostart=false loop=false id="c1">



<?php
session_start();
require_once("../uti/Ureaddir.php");


require_once("../uti/MysqlJiaguwen.php");
require_once("../uti/MysqlHieroglyphics.php");

?>






 <style type="text/css">
img { 

height:30px;
width: 30px;
}
.h { 

height:20px;
width: 20px;
}
az { 
font-size: 5px;

}







#mv2{
   border-color: #0000ff;
   border-style: solid;
   border-width: 1px;
}
div.clkimg{
   border-color: #ff0000;
   border-style: solid;
   border-width: 0px;
}
img.mimg { 
   height:65px;
   width: 65px;
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
div.mimg{
   float: left;
   border-color: #0000ff;
   border-style: solid;
   border-width: 1px;
}




</style>   


<?php $d = new MysqlJiaguwen();
$d->print_js_colnames_Jia();
?>
<?php $d = new MysqlHieroglyphics();
$d->print_js_colnames_Hia();
?>
<script type="text/javascript">
jQuery(document).ready(function(){
   $("body").mousemove(function(e){
      //$("#a1").attr("src", "../audio/c.wav" );
      $("#aa").html("<embed src='../audio/a.wav' hidden=true autostart=true loop=false>");
      $("#aa").html("<embed src='../audio/c.wav' hidden=true autostart=true loop=false>");

      
       //$("#info").css("font-size","10px").text(e.pageX +', '+ e.pageY);
       $("#mv2").show();
       var zz = $.cookie("zz");
       if( null == zz || "0"==zz) {
         return;
       }
       $("#mv2").css( {  
                position: 'absolute', 
                zIndex: 5000, 
                left: e.pageX,  
                top: e.pageY+20 
        } ); 
        
   }); 
})
</script>

<script type="text/javascript">
jQuery(document).ready(function(){
   $("a.norm").each(function(){
      var href = $(this).attr("href");
      if( null == href ) return;
      $(this).text( href );
   });
   function ajx_query(){
      //alert($("#keyval").text());
                        $.post("../uti/svc/i_query.php", 
                            {   
                              db:  $.cookie("db"),
                              keyval:  $("#keyval").text()
                            },
                            function(data, status){
                              $("#ajx_containter").html(data);
                             
                           },
                            "datastring"
            );// post    
   }
   
   function ajx_undo(){
                        $.post("../uti/svc/i_update_undo.php", 
                            {   
                               dump:  "1"
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
                             
                           },
                            "datastring"
            );// post    
   }
   function ajx_update(){
                     $.post("../uti/svc/i_update.php", 
                            {   
                               db:    $.cookie("db"),
                               sc:    $.cookie("sc"),
                               op:    $.cookie("op"),
                               setid:    $.cookie("setid"),
                               where:    $.cookie("where"),
                               dump:  "-"
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
                           },
                            "datastring"
            );// post    
   }
   
      
   $("img").click(function(){
      var s = $(this).attr( "src" );
      s = u_basename(s);
      $.cookie("clickimg",s);
      
      showcfg(null);
      
      $.cookie("setid",$("#sql_setid").text());
      $.cookie("where",$("#sql_whereid").text());
      //if( $.cookie("ex") != "1") return;
      
      //store
      $.cookie_history("hisoryimg",s);
   });
   function getDbColArr(){
         var ar=null;
         if("Jiaguwen"==$.cookie("db")) {
            ar = Jia;
         }
         else {
            ar = Hia;
         }
         return ar;
   }
   function showcfg(e){
         var op = $.cookie("op");//op add vs del.
         var ff = $.cookie("ff");//fix vs var
         var db = $.cookie("db");//database
         var sc = $.cookie("sc");//select col
         var ex = $.cookie("ex");//execute
         var vi = $.cookie("clickimg");//var img
         
         var setid = $.cookie("setid");
         var where = $.cookie("where");
         
         $("#sql_setid").text(setid);
         $("#sql_whereid").text(where);
         
         $("#sql_setimg").attr("src", u_src_of(setid));
         $("#sql_whereimg").attr("src", u_src_of(where));


         $("#dbname").text(db);
   
         var ar=getDbColArr();

         var str1="[var]",str2="[fix]";
         var keyid = ("Jiaguwen"==db)?"jid":"hid" ;
            str1 = ar[sc]+op+"=";
            str2 = keyid+"=" ;
            
         $("#sql_setco").text(str1);
         $("#sql_where").text(str2);  
        

         $("div.clkimg").css("border-width", "0px");
         if("1"==ff) {
            //$("#clkimg1").css("background-color","#ff0000");
            $("#clkimg1").css("border-width","1px");
            //$("#sql_setid").css("color","#ff0000");
            //$("#sql_whereid").css("color","#000000");
         }
         else{
            $("#clkimg2").css("border-width","1px");
            //$("#sql_setid").css("color","#000000");
            //$("#sql_whereid").css("color","#ff0000");           
         }
         
         if(null != e ) return;
         
         //click img change the value.
         if("1"==ff) {//first value fixed.
            $("#sql_setimg").attr("src", u_src_of(vi));
            $("#sql_setid").text(vi);
         }
         else{  
            $("#sql_whereimg").attr("src", u_src_of(vi));
            $("#sql_whereid").text(vi);
         }         
   }
   
   function toggle_op(){
         var op = $.cookie("op");
         if( null==op || op=="-") {
            op = "+";
         }
         else{
            op = "-";
         }
         $.cookie("op",op);
   }
   function toggle_ff(){
         var op = $.cookie("ff");
         if( null==op || op=="0") {
            op = "1";
         }
         else{
            op = "0";
         }
         $.cookie("ff",op);
   }
   function toggle_db(){
         var op = $.cookie("db");
         if( null==op || op=="Hieroglyphics") {
            op = "Jiaguwen";
         }
         else{
            op = "Hieroglyphics";
         }
         $.cookie("db",op);
   }
   function toggle_sc(){
         var op = $.cookie("sc");
         if( null==op ) {
            op = -1;
         }
         op ++;
         
         var ar=getDbColArr();
         
         if(op>=ar.length-1) op=2;
         
         $.cookie("sc",op);
   }
   function toggle_ex(){
         var op = $.cookie("ex");
         if( null==op || "0" == op) {
            op = 1;
         }
         else{
            op = 0;
         }
         
         $.cookie("ex",op);
         ajx_update();
   }
   function toggle_zz(){
         var op = $.cookie("zz");
         if( null==op || "0" == op) {
            op = 1;
         }
         else{
            op = 0;
         }
         
         $.cookie("zz",op);
   }

   function show_usage(e){
      var s=e.type + "= " +  e.which + "   (The key is not used. Please see following Menu for Help.)\n----------\n";
      s+="a: + or - \n";
      s+="s: select column\n";
      s+="d: database of Hieroglyphics or Jiaguwen\n";
      s+="f: toggle var and fix of img when click\n";
      s+="e: execute the sql\n";
      s+="q: sql string\n";
      s+="z: toggle to show moving menu\n";

      alert(s);
   }
   $(this).keypress(function(e){
      //alert(e.type + ": " +  e.which );
      var k = e.which;
      switch(k) {
      case 97: //'a'
         toggle_op();
      break;
      case 102://f: toggle fix and var
         toggle_ff();
      break;
      case 100://d : toggle database.
         toggle_db();
      break;
      case 101://e: execute sql
         toggle_ex();
      break;
      case 113://q: qery
         ajx_query();
      break;
      case 115://s: select col
         toggle_sc();
      break;
      case 117://u: undo update
         ajx_undo();
      break;
      case 120://exe
         toggle_ex();
      break;
      case 122://zz
         toggle_zz();
      break;
      case 32://space
         //space_bar_fix_last_click();
      break;
      default:
         show_usage(e );
      break;
      }
      showcfg(e);
   });
   $(this).keyup(function(e){
      //alert(e.type + ": " +  e.which );
   });
   $(this).keydown(function(e){
      //alert(e.type + ": " +  e.which );
   });
});
</script>

	


<div id="mv2">
    <table border="1" bgcolor="#ffffff">
        <tr>
            <td>UPDATE</td>
            <td>SET</td>
            <td>WHERE</td>
        </tr>
        <tr>
            <td id="sql_updts"><h5 id="dbname">[d:db]</h5></td>
            <td id="sql_setco">[s:col][a:+/-]</td>
            <td id="sql_where">[f: flip var]</td>
        </tr>
        <tr>
            <td></td>
            <td><div class="clkimg" id="clkimg1"><a id="sql_setid" class="mm"></a><br><img id="sql_setimg"  class="mimg"/></div></td>
            <td><div class="clkimg" id="clkimg2"><a id="sql_whereid" class="mm"></a><br><img id="sql_whereimg"  class="mimg"/></div></td>
         </tr>
    </table>
    <div id="ajx_containter">ajx_containter</div>
    <div >
    <img/><br/><a id="msg">--</a>
    </div>
    <h5 id="cfg"></h5>
    <h5 id="sqltxt">sqltxt</h5>
    <h2 id="mv2cookie"></h2>
    <h2 id="ajxmsg">--</h2>
    <img class="magified"/><a>*</a>
    <a class='norm'></a>
</div>





















<div>

<?php
require_once("../uti/Ureaddir.php");


require_once("../uti/MysqlJiaguwen.php");
require_once("../uti/MysqlHieroglyphics.php");

$againstDir = "../uti/jgw/mer/compound/p/";
$againstDir = "../../odb/tbi/img/jgif/";




//die("aa");
function htm_img_jqw( $val ){
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if(strlen($bname)==0) continue;
      $fname = "../../odb/tbi/img/jgif/$bname.gif";
      $ret .= "<img src='$fname'/><a>$bname</a>";
   }
   return $ret;
}
function htm_img_zid( $val ){
   $ret="&#".$val.";"."<a>".$val."</a>";
   return $ret;
}
function htm_img_hid( $val ){
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if('0'==$bname || strlen($bname)==0) continue;
      $fname = "../../odb/hiero/ccer-h/$bname.gif";
      $ret .= "<img src='$fname'/><a>$bname</a>";
   }
   for($i=0; $i<1;$i++) $ret.="<img class='h'/><a>@</a>";
   return $ret;
}
function htm_img_hink( $val ){
   $ret="";
   $arr = preg_split("/[,]/i",$val);
   foreach($arr as $bname){
      if('0'==$bname || strlen($bname)==0) continue;
      $fname = "../../odb/hiero/ccer-h/$bname.gif";
      $ret .= "<div><img class='h' src='$fname'/><br><a>$bname</a></div>";
   }
   for($i=0; $i<1;$i++) $ret.="<div><img class='h'/><br><a>@</a></div>";
   return $ret;
}


function htm_tr($row) {
   echo "<tr>";
      foreach($row as $key => $val ) {
         if(is_numeric($key) ) continue;
         echo "<td><div>";
            switch($key){
            case 'jid':
            case 'jink':
               echo htm_img_jqw($val);
               break;
            case 'zid':
               echo htm_img_zid($val);
            break;
            case 'jmn':
               echo htm_img_hid($val);
            break;
            case 'jtoh':
               echo htm_img_hink($val);
            break;
            default:
            echo $val;
            }
         echo "</div></td>";
      }
      echo "</tr>\r\n";
}
$jia = new MysqlJiaguwen();
$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
$sql = "SELECT * FROM Jiaguwen ORDER BY idx";
$ret = $jia->query($sql);

echo "<table border='1'>\r\n";
   echo "<tr>";
   foreach($ret[0] as $key => $val ) {
      if(is_numeric($key)) continue;
      echo "<td class='col'>";
         echo $key;
      echo "</td>";
   }
   echo "</tr>";
   /////////////////////////////
   foreach ($ret as $row){
      htm_tr($row);
   
         static $tmpi=0;
      $tmpi++;
      if($tmpi>5) break;
    }
echo "</table>\r\n";



?>


</body>
</html>