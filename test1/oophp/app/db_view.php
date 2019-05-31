
<html>
<head>
                <title>jgw db viewer</title>

                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
                </head>

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
 <style type="text/css">
img { 

height:30px;
width: 30px;
}
img.m2 { 

height:230px;
width: 230px;
}
div { 
float: left;
}
div.sql_editor{
position: absolute; 
  zIndex: 5000; 
  left: 0;  
  top: 0; 
}
</style>   

                
<script type="text/javascript">
var oid=57345;
$(document).ready(function(){     
      $("#sss").change(function(idx){
         var sql = $(this).val();
         //alert(sql[0]);
         $("#sql").val(sql);
      });
      
      
      $("img").click(function(event){
         if($("body").attr("ctrlKey")!=true) return;
         $("body").attr("ctrlKey",false);
         event.stopPropagation();
         var src = $(this).attr("src");    
         //alert($(this).get(0).nodeName);
            //alert($(this).prop("tagName"));
         $.post("../uti/svc/_imgClick.php", 
                            {   
                              src:src
                            },
                            function(data, status){
                              alert(status + ":\n"+ data);
                           },
                            "datastring"
            );// post     
         //alert("src="+src);
      });
      $("td").click(function(event){
         if($("body").attr("ctrlKey")!=true) return;
         $("body").attr("ctrlKey",false);
         event.stopPropagation();
         //alert("www"+ $(this).get(0).nodeName);
         var pars = $(this).attr("pars");
         if(pars.length==0) return;
         if (true != confirm("Add?\n" + pars) ) return;
         $.post("../uti/svc/_imgAppend.php", 
                            {   
                              pars:pars
                            },
                            function(data, status){
                              alert(data);
                              $("#ajx_containter").html(data);
                             
                           },
                            "datastring"
            );// post 
      });
      $("a.m").click(function(event){
         if($("body").attr("ctrlKey")!=true) return;
         $("body").attr("ctrlKey",false);
         event.stopPropagation();
         var pars = $(this).attr("pars");
         if(pars.length==0) return;
         pars+=","+$(this).html();
         //alert( "["+pars+"]" );
         if (true != confirm("Delete?\n" + pars) ) return;
         $.post("../uti/svc/_imgDelete.php", 
                            {   
                              pars:pars
                            },
                            function(data, status){
                              alert(data);
                              $("#ajx_containter").html(data);
                             
                           },
                            "datastring"
            );// post 
      });
      $("a.ed").click(function(event){
         if($("body").attr("ctrlKey")!=true) return;
         $("body").attr("ctrlKey",false);
         event.stopPropagation();
         
         var pars = $(this).attr("pars");
         if(pars.length==0) return;
         var myval = $(this).html();
         var newstr = prompt("[table,primKey,primVal,youKey,youVal]=["+pars + ","+myval + "], youNewVal:", myval);
         if( null==newstr) return;
         if(newstr== myval) {
            return alert(myval + " not changed.");
         }
         pars += "," + newstr;
         //alert( "["+pars+"=" + newstr);
         //if (true != confirm("Update?\n ["+pars+"]\n repplace '"+ myval + "' with " + newstr) ) return;
         //$(this).html(newstr);
         $(this).attr("id","TmpId");
         $(this).attr("youVal",newstr);
         $.post("../uti/svc/_itemUpdate.php", 
                            {   
                              pars:pars
                            },
                            function(data, status){
                              $("#TmpId").html( $("#TmpId").attr("youVal") ); 
                              $("#TmpId").attr("id","");
                              $("#TmpId").attr("youVal","");
                              //alert(data);                            
                           },
                            "datastring"
            );// post 
      });
      
      
   $("body").keypress(function(e){
      var k = e.which;
      //alert(e.ctrlKey);
   }).keyup(function(e){
      $("body").attr("shiftKey",e.shiftKey);
      $("body").attr("ctrlKey",e.ctrlKey);
      //alert(e.ctrlKey);
   }).keydown(function(e){
      $("body").attr("shiftKey",e.shiftKey);
      $("body").attr("ctrlKey",e.ctrlKey);
      //alert(e.ctrlKey);
   }).mousemove(function(e){
      if($("body").attr("shiftKey")!=true) return;
      $("div.sql_editor").show().css( {  
                position: 'absolute', 
                zIndex: 5000, 
                left: e.pageX/10000,  
                top: e.pageY-80 
        }); 
   });
   

});//$(document).ready(function(){                                            
</script>
 


<body bgcolor="<?php echo '#eeaaee'; ?>">		

<?php
//require_once("../tpl/atpl.php");
//atpl::printent("../tpl/mmdiv.php");
?>


<?php
$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
$sql = "SELECT * FROM Jiaguwen";
$sql = "SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' LIMIT 0,10";
if( isset($_REQUEST["sql"]) && strlen($_REQUEST["sql"])>0 ){
   $sql = $_REQUEST["sql"];
}
else{
   $_REQUEST["sql"]="";
}
?>






<div class="sql_editor">
<form method="get" action="<?php echo basename(__FILE__);?>">
<button type="submit">OK</button><input id="sql" name="sql" size='150' value="<?php echo htmlentities($_REQUEST["sql"]);?>"></input><br>
<select id="sss" name="sss">
<option></option>
<option>SELECT * FROM Jiaguwen</option>
<option>SELECT * FROM Jiaguwen WHERE jink LIKE '%62548,%' ORDER BY jink</option>
<option>SELECT jid FROM Jiaguwen</option>
<option>SELECT jid, zid FROM Jiaguwen</option>
<option>SELECT * FROM Jiaguwen LIMIT 0,10</option>
<option>SELECT * FROM Jiaguwen LIMIT 0,500</option>
<option>SELECT * FROM Jiaguwen LIMIT 0,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 1000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 2000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 3000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 4000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 5000,1000</option>
<option>SELECT * FROM Jiaguwen LIMIT 6000,1000</option>

<option>SELECT * FROM Jiaguwen WHERE jink LIKE '_____,' ORDER BY jink</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink=''</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink IS NULL</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink LIKE '_____,'</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen WHERE jink LIKE '_____,_____,%'</option>

<option>SELECT DISTINCT jink FROM Jiaguwen WHERE jink LIKE '_____,'</option>
<option>SELECT idx, jid, jink , pyn, eng, descr, L ,xa  FROM Jiaguwen LIMIT 0,10</option>
<option>SELECT jid, zid FROM Jiaguwen</option>


<option>SELECT * FROM Jiaguwen WHERE jink IS NULL</option>
<option>SELECT * FROM Jiaguwen WHERE jink = ""</option>
<option>SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' ORDER BY jtoh , jink DESC</option>
<option>SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' ORDER BY jtoh , jink ASC</option>
<option>SELECT * FROM Jiaguwen WHERE jmn LIKE '%,%'</option>
<option>SELECT * FROM Jiaguwen WHERE jmn <>""</option>
<option>SELECT * FROM Jiaguwen WHERE jmn IS NULL</option>
<option>SELECT * FROM Jiaguwen WHERE jmn IS NOT NULL</option>
<option>SELECT * FROM Jiaguwen WHERE L IS NULL</option>
<option>SELECT * FROM Jiaguwen WHERE L!='4' AND xa!='x'</option>
<option>SELECT * FROM Jiaguwen WHERE  xa='x'</option>
<option>SELECT * FROM Jiaguwen WHERE jink='' AND L!='1' AND L!='5' AND xa!='x' </option>
<option>SELECT * FROM Jiaguwen WHERE L IS NOT NULL ORDER BY L</option>
<option>SELECT jid,zid, freq  FROM Jiaguwen GROUP BY zid ORDER BY freq</option>

<option>SELECT * FROM Hieroglyphics LIMIT 0,10</option>
<option>SELECT * FROM Hieroglyphics LIMIT 0,100000</option>

<option>SELECT 'Jiaguwen.jid', 'Hieroglyphics.hid' FROM Jiaguwen, Hieroglyphics WHERE Jiaguwen.idx != ''   LIMIT 0,100</option>
<option>SELECT 'Jiaguwen.jid' , 'Hieroglyphics.hid'  FROM Jiaguwen, Hieroglyphics WHERE Jiaguwen.idx <10   LIMIT 0,10</option>
<option>SELECT 'Jiaguwen.jid' jid, 'Hieroglyphics.hid' hid FROM Jiaguwen, Hieroglyphics WHERE Jiaguwen.idx <10   LIMIT 0,10</option>

<option>SELECT *  FROM PictureToday    LIMIT 0,10</option>
<option>SELECT *  FROM PictureToday_jid2pic_    LIMIT 0,10</option>

<option>SELECT *  FROM ttt    LIMIT 0,10</option>
<option>SELECT DISTINCT src FROM ttt ORDER BY idx DESC LIMIT 10</option>
<option>UPDATE Jiaguwen SET hink='xyz' WHERE hink=abc</option>
</select>

</form>
</div>
<?php

require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlHieroglyphics.php");

require_once("../uti/MysqlJiaguwen.php");
require_once("../uti/DbRow2Htm.php");

$againstDir = "../uti/jgw/mer/compound/p/";
$againstDir = "../../odb/tbi/img/jgif/";











//echo $sql . "";


if( preg_match("/Hieroglyphics/i",$sql)==1){
   //$db = new MysqlHieroglyphics();
}

$db = new MysqlJiaguwen();


$ret = $db->query($sql);
echo "count=". count($ret) . "<br>";

$r2htm = new DbRow2Htm();
echo "<table border='1'>\r\n";
   $r2htm->htm_tr_title($ret[0]);
   foreach ($ret as $row){
      $r2htm->htm_tr_dat_rd($sql,$row);
      
      if(isset($row['jtoh'])) {
         $r2htm->push2TmpArr($row['jtoh']);
      }
   }
echo "</table>\r\n";

echo "<br>total hieros=".count($r2htm->TmpArr);
echo "<br>";

if(isset($r2htm->TmpArr)){
   sort($r2htm->TmpArr);
   foreach ($r2htm->TmpArr as $hid  ){

      $fname = $r2htm->img_src_of($hid);  
      print("<img src='$fname' /img>$hid");
   }
}


?>
<!-- id="clentarea"-->
</div>

<br><br>Help:<br>
Ctrl + ClickImg ==> Copy, <br> Ctrl + ClickTD ==> Add Img into TD, <br> Ctrl + ClickImgTitle ==> Delete img, <br> Ctrl + ClickText ==> Update value.
</body>
</html>