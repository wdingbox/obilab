<?php
@session_start();

require_once("../MysqlJiaguwen.php");
require_once("../MysqlHieroglyphics.php");
//mysql_query("UPDATE Persons SET Age = '36'
//WHERE FirstName = 'Peter' AND LastName = 'Griffin'");

//"UPDATE animals SET animal_name='bruce' WHERE animal_name='troy'"
//print_r($_REQUEST);

class Hid2jids {
   public  $odb;
   public function Hid2jids(){
      $this->odb = new MysqlJiaguwen();
   }
   public function get_htoj_str_of($hid){
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


?>