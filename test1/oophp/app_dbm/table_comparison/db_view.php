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
  border:1px;
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
  border:1;
}
</style>   

                
<script type="text/javascript">
var oid=57345;
$(document).ready(function(){
    //$(".tmpimg").attr("title","c : copy zoom to current;\n n : next\n z : toggle zoom.");
    
            $("#sss").change(function(idx){
                                   var sql = $(this).val();
                                  //alert(sql[0]);
                                  $("#sql").val(sql);
                                  $(this).val("...");
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
$sql = "SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' LIMIT 0,10";
if( isset($_REQUEST["sql"]) && strlen($_REQUEST["sql"])>0 ){
   $sql = $_REQUEST["sql"];
}
else{
   $_REQUEST["sql"]="";
}
?>






<div class="sql_editor">
<form method="get" action="<?php echo basename(__FILE__);?>" id="formsubmit">
   <a href="../../oMySql/phpMyAdmin-3.3.8/phpmyadmin_wei/index.php">DBM</a> <button id="oksubmit" type="submit">OK</button>
   <input id="sql" name="sql" size='170%' value="<?php echo htmlentities($_REQUEST["sql"]);?>"></input><br>
   <select id="sss" name="sss"  style="max-width:20px;">
      <option></option>
      <option>...</option>
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

<a id="opText">bottomDbg</a>
<select id="opcmd">
<option id=""></option>
<option id="a">add</option>
<option id="a">edit</option>
<option id="a">update</option>
<option id="a">---</option>
<option id="a">zoom</option>
</select>
<br/>
<img id="zoomedpicture" src="."></img><br/>
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

      $fname = $r2htm->img_src_of($hid,$hid);  
      print("<img src='$fname' /img>$hid");
   }
}


?>






<!-- id="clentarea"-->


<br><br>
<a>---</a><br><br>
<button id="jink_roots_freq_list">jink_roots_freq_list</button><button id="jink_roots_freq_list1">jink_roots_freq_list1(merged)</button><button id="roots_merge_list">roots_merge_list</button><br/>
<p id="jq_data_analysis">jq_data_analysis results</p>


<hr/>
Help:<br>

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
<br><br><br><br><br><br><br><br>
</body>
</html>