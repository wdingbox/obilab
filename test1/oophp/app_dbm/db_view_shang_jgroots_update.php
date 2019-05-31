<!DOCTYPE html>
<html>
<head>
    <title>jgw db viewer</title>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
    <script type="text/javascript"  src="./jquery-2.1.1.min.js"></script>   
    <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
    <script type="text/javascript" src="../_js/uti.js"></script>
     <script type="text/javascript" src="db_view_ajx.js"></script>

                <!-- Users -->
    <LINK href="db_view_item.css" rel="stylesheet" type="text/css">


<style type="text/css">
div.sql_editor{
  position: fixed; 
  //zIndex: 5000; 
  left: 0;  
  top: 0; 
}


#ZoomZone{
  position: fixed; 
  right:1px;  
  top: 1px; 
}
#zoomedpicture{
  //zIndex: 0; 
  position: fixed; 
  right: 20px;  
  top: 20px; 
  height: 50px;
  width: 50px;
}

#top_right_view{
  position: fixed; 
  right:1px;  
  top: 20px; 
}


img.tmpimg{
  right: 1px;  
  height: 20px;
  width: 20px;
}
</style>   

                
<script type="text/javascript">
var oid=57345;
$(document).ready(function(){
    $(".tmpimg").attr("title","c : copy zoom to current;\n n : next\n z : toggle zoom.");
    
            $("#sss").change(function(idx){
                                   var sql = $(this).val();
                                  //alert(sql[0]);
                                  $("#sql").val(sql);
                                  });
            $("#formsubmit").submit(function(){
                var sql = $("#sql").val();
                //alert(sql.length);
                var sqlarr = sql.split(";");
                //alert(sqlarr.length);
                var bUpdate=false;
                for(var i=0;i<sqlarr.length;i+=1){
                    sql = sqlarr[i];
                    if ( sql.toLowerCase().search("update ") >=0 ){
                        var b = confirm("Update?\n"+sql);
                        if(b){
                            window.open("db_view.php?sql="+sql);
                            
                        }
                        //return false;
                        bUpdate=true;
                    }
                }
                if(bUpdate){
                    return false;
                }
                return true;
            });
            
            $("#update2select").click(function(){
                var sql=$.trim($("#sqlstr").text());
                var pset=sql.search("SET ");
                var pwhr=sql.search("WHERE ");
                var pupd=sql.search("UPDATE ");
                if(pupd>=0 && pupd<pset){
                    var sql2=sql.substring(0,pset);
                    sql2 = sql2.replace("UPDATE", "SELECT * FROM ");
                    sql2+=sql.substring(pwhr);
                    $("#sql").val(sql2);
                }
            });
            $("#sqlstr").click(function(){
                var s=$(this).text();
                $("#sql").val(s);
                
            });
});//$(document).ready(function(){                                      
</script>
 

</head>
<body bgcolor="<?php echo '#eeaabb'; ?>">       

<?php
//require_once("../tpl/atpl.php");
//atpl::printent("../tpl/mmdiv.php");
?>


<?php
$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
$sql = "SELECT * FROM Jiaguwen";
$sql = "SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' LIMIT 0,100";
if( isset($_REQUEST["sql"]) && strlen($_REQUEST["sql"])>0 ){
   $sql = $_REQUEST["sql"];
}
else{
   $_REQUEST["sql"]="";
}

$sql = "SELECT * FROM Jiaguwen LIMIT 0,10000";
?>






<div class="sql_editor">
<form method="get" action="<?php echo basename(__FILE__);?>" id="formsubmit">
   <a href="../../oMySql/phpMyAdmin-3.3.8/phpmyadmin_wei/index.php">DBM</a> <button id="oksubmit" type="submit">OK</button>
   <input id="sql" name="sql" size='170%' value="<?php echo htmlentities($_REQUEST["sql"]);?>"></input><br>
   <select id="sss" name="sss">
      <option></option>
      <?php
      require_once("../tpl/atpl.php");
      //atpl::printent("../tpl/mmdiv.php");
      atpl::printent("db_view_selectoptions.tpl");
      atpl::printent("db_view_selectoptions2.tpl");
      ?>
   </select>
</form>

</div>

<div id="ZoomZone">
<a id="opText">bottomDbg</a><br/>
<img id="zoomedpicture"></img><br/>
</div>
<div id="top_right_view">
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
<img class="tmpimg"></img><br/>
</div>



<?php
require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlHieroglyphics.php");

require_once("../uti/MysqlJiaguwen.php");
require_once("../uti/DbRow2Htm.php");

$againstDir = "../uti/jgw/mer/compound/p/";
$againstDir = "../../odb/tbi/img/jgif/";
if( !file_exists($againstDir)){
    echo "<font color='red'>no file exist:</font>";
}











echo "<br><br><a id='sqlstr' title='id:sqlstr'>".$sql . " <a/> ;<button id='update2select'>update2select</button><br>\n";


if( preg_match("/Hieroglyphics/i",$sql)==1){
   //$db = new MysqlHieroglyphics();
}

$db = new MysqlJiaguwen();


$ret = $db->query($sql);
echo "count=". count($ret) .  ", " . $sql . "<br>\n";
$jid2jroot=[];
echo "<table border='1'>"; 
foreach ($ret as $row){
      $jid = $row['jid'];
      $jid2jroot["$jid"]=$row['jink'];
      $tr="<tr><td>".$jid."</td><td>".$jid2jroot["$jid"]."</td><td>". "-" ."</td></tr>\n";
      echo $tr;    
}
echo "</table>"; 


$db2 = new MysqlJiaguwen();
$sql2 = "SELECT idx, jink, jgroots FROM bronze0000shang";
$ret2 = $db2->query($sql2);
echo "count2=". count($ret2) .  ", " . $sql2 . "<br>\n";


$db3up = new MysqlJiaguwen();


$r2htm = new DbRow2Htm();
echo "<table border='1'>\r\n";
   $r2htm->htm_tr_title($ret2[0]);
   foreach ($ret2 as $row){
      $jinkarr=explode(",",$row['jink']);
      $c=count($jinkarr);
      $jk = $row['jink'].$c;
      $roots="";
      foreach($jinkarr as $i=>$val){
          if(strlen($val)>0){
            $rt=$jid2jroot["$val"];
            if( strlen($rt)<1){
              $roots .=$val.",";
            }else{
              $roots.= $rt;
            }
          }
      }
      $rootarr = explode(",",$roots);
      $rootarr2=array_unique ($rootarr);
      asort($rootarr2);
      $rt2=implode(",",$rootarr2);
      $rt2=trim($rt2,",");
      $rt2 .= ",";
      
      $sql3="UPDATE bronze0000shang SET jgroots='$rt2' WHERE idx=" . $row['idx'] .";";
      $ret = $db3up->query($sql3);
      $tr="<tr><td>".$row['idx']."</td><td>".$jk."</td><td>".$rt2." (".count($rootarr2).")<br>$sql3<br>$ret</td></tr>\n";
      
      echo $tr;
      //$r2htm->htm_tr_dat_rd($sql2,$row);
      
      
   }
echo "</table>\r\n";

echo "<br>total hieros=".count($r2htm->TmpArr);
echo "<br>";

if(isset($r2htm->TmpArr)){
   sort($r2htm->TmpArr);
   foreach ($r2htm->TmpArr as $hid  ){

      $fname = $r2htm->img_src_of($hid,$hid);  
      print("<img src='$fname' /img>$hid");
   }
}


?>






<!-- id="clentarea"-->


<br><br>
<a>---</a><br><br>
<button id="jink_roots_freq_list">jink_roots_freq_list</button><br/>
<p id="jq_data_analysis">jq_data_analysis results</p>


<hr/>
Help:<br>
 'a' : toggle state to add zoomed img into td. <br>
 'd' : toggle delete img from td. <br>
 'u' : toggle update sql. <br>
 <br>------<br>
 'm' : toggle mark td. <br>
 'z' : toggle zoom rates. <br>
 <br>------<br>
 'L' : lock zoomed img to current high lighted position<br>
 '&lt;' : goto prev high lighted position to copy <br>
 '&gt;' : goto next high lighted position to copy <br>
 
 <br><br>
 
Shift + OnMouseMove ==> move sql editor. <br>
Shift + OnMouseMoveoverImg ==> Magnefy Img. <br> 

Ctrl + ClickImg ==> Copy, <br>
Ctrl + ClickTD ==> Paste Img into TD, <br>
Ctrl + ClickImgTitle ==> Delete img, <br>
Ctrl + ClickText ==> Update value.<br>
<hr/>
chant font intval=978944 +jid. <br/>
sample:
<?php
$intval=978944  + 60569;
$chant= html_entity_decode("&#$intval;", 0, 'UTF-8');
echo "<font face='chant'>$chant</font>"; 
?>
<hr/>
<div id="sql_data">sql data</div>
<hr/>
<hr/>

<hr/>
</body>
</html>