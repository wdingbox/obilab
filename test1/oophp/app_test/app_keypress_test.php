<!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
                <title>jh map editor</title>

                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>
                
<script type="text/javascript" src="i_hierogliphics_jiaguwen_map_db_visual_editor.js"></script>

                <!-- Users  -->
</head>
 <style type="text/css">
img { 

height:30px;
width: 30px;
}
.h { 

height:20px;
width: 20px;
}
img.magified { 
height:190px;
width: 190px;
}
a { 
font-size: 5px;

}
a.norm { 
font-size: 12px;

}
div{
float: left;
border-color: #00ff00;
border-width: 1px;
border-style: solid;

}
div.cfg{
float: top;
border-color: #0000ff;
border-width: 1px;
border-style: solid;
width: 600px;
}
</style>   
<script type="text/javascript">
jQuery(document).ready(function(){
   $("a.norm").each(function(){
      var href = $(this).attr("href");
      if( null == href ) return;
      $(this).text(href);
   });
   
   
      
   $(this).keypress(function(e){
      //alert(e.type + ": " +  e.which );
   });
   $(this).keyup(function(e){
      alert(e.type + ": " +  e.which );
   });
   $(this).keydown(function(e){
      //alert(e.type + ": " +  e.which );
   });
});
</script>

<body bgcolor="<?php echo '#eeeeee'; ?>">		
<div>
<select id='selctrl'>
<option></option>
<option>nop</option>
<option>Add a hieroglphic into jtoh in Jiaguwen database </option>
<option>Delete a hieroglphic from jtoh Jiaguwen database </option>
</select><br></div>
<div><img/><br/><a class="norm" href="hiero_db_roots_statistic.php">Ctrl Menu</a></div>
<div><img/><br/><a class="norm" href="hiero_frameset.htm">Ctrl Menu</a><br></div>
<div><img/><br/><a class="norm" href="hiero_fr_dir_imglist_for_database__input_root_2_compound.php">Ctrl Menu</a><br></div>
<div><img/><br/><a id="msg">--</a></div>
<div id="mv2"><h2 id="mv2cookie"></h2><h2 id="ajxmsg">--</h2><img class="magified"/><a>*</a><a class='norm'></a></div>

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


if(0){
foreach ($ret as $row){

      $srcfile = $againstDir . $row[1].".gif";
      if( !file_exists( $srcfile)) continue;
      
      printf("%d, <img src='%s'/><a>[%s]</a>,&#%d;[%s],%d,",
         $row[0],$srcfile,$row[1],$row[2],$row[2],$row[3]);
         
      $jink = $row[6];
      if( strlen($jink)>0 ){
         $arr = preg_split("/[,]/i",$jink);
         foreach( $arr as $img ){
            $img = trim($img);
            if(strlen($img)==0) continue;
            printf("<img src='../../odb/tbi/img/jgif/%d.gif'/>",$img);
         }
      }
      
      printf("[%s]<br>\r\n",
         $row[6]);
         

}
}


?>

</div>
configuration Set<br>




<div class="cfg">
<form action="" method="GET">
UPDATE <font color="blue">Hieroglyphics</font> SET
<select size='13'>
<?php $d = new MysqlHieroglyphics();
$arr = $d->get_colnames();
foreach($arr as $colname) {
   print "<option>$colname</option>";
}
?>
</select>
=
<select size="3"><option>Add</option><option>Delete</option></select>
<select size="3"><option>var</option><option>fixed</option></select>
WHERE <font color="blue">jid</font>=
<a>?????</a>
<br>
<button type="submit">OK</button>
</form>
</div>


<div class="cfg">
<form action="" method="GET">
UPDATE <font color="blue">Jiaguwen</font> SET
<select size='13'>
<?php $d = new MysqlJiaguwen();
$arr = $d->get_colnames();
foreach($arr as $colname) {
print "<option>$colname</option>";
}
?>
</select>
=
<select size="3"><option>Add</option><option>Delete</option></select>
<select size="3"><option>var</option><option>fixed</option></select>
WHERE <font color="blue">jid</font>=
<select size="3"><option>var</option><option>fixed</option></select>
<br>
<button type="submit">OK</button>
</form>
</div>




</body>
</html>