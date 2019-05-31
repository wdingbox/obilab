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







<?php
require_once("../tpl/atpl.php");
atpl::printent("../tpl/mmdiv.php");
?>





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

</div>
</body>
</html>