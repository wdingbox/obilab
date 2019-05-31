<?php
@session_start();

require_once("../MysqlJiaguwen.php");
require_once("../MysqlHieroglyphics.php");
//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);

class Hid2jinks {
   public  $odb;
   public function Hid2jinks(){
      $this->odb = new MysqlJiaguwen();
   }
   public function get_jinks($hid){
       $sql="SELECT jid FROM Jiaguwen WHERE jtoh LIKE '%$hid,%'";
       $ret = $this->odb->query($sql);
       if( count($ret)<1 ) return "";

       $jidstr="";
       foreach($ret as $indx => $row){
         $jidstr.=$row[0] . ",";
       }

       
       //print_r($ret);
       //echo $jidarr;
       //syslog(0, "jidstr=".  $jidstr);
       //echo $jidstr;
       return $jidstr;
    }
}

die();



$h2j = new Hid2jinks();
//echo $jc->get_jinks($hid);

$sql = "SELECT hid FROM Hieroglyphics";//
$hiero = new MysqlHieroglyphics();
$ret = $hiero->query($sql);
foreach($ret as $indx => $row){
   $hid = $row[0];
   $htoj = $h2j->get_jinks($hid);
   if(""==$htoj) continue;
   //echo $htoj ;
   //echo "<br>";
   $sql = "UPDATE Hieroglyphics SET htoj='$htoj' WHERE hid='$hid'";
   $ret = $hiero->execute($sql);
   echo $sql . "<br>";
}

die();

//'58740,61788,58733,58723,61786,58721,58724,58725,58741,58742,63044,58754,63379,61539,61772,61789,58722,63296,'

?>