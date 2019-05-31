<?php
require_once("../uti/DbRow2Htm.php");

class Jqw2earlycuneiform
{
   public $j4c = array();
   public $h4c = array();
   public $mapcjh = array();
   public function init_mapcjh(){
      $arr = array();
      $arr[]=array('',array(0,0),array(0,0),"desc");
      $arr[]=array('P000225',array(58757,0),array('N12',''),"desc");
      $arr[]=array('P000226',array(61660,59462 ),array('Z11A',''),"desc");
      $arr[]=array('P000248',array(61415 ,0),array('',''),"desc");
      $arr[]=array('P000257',array(59462 ,0),array('',''),"desc");
      $arr[]=array('P000275',array(62629 ,0),array('',''),"desc");
      $arr[]=array('P000295',array(0,0),array('',''),"desc");
      $arr[]=array('P000305',array(63362 ,0),array('',''),"desc");
      $arr[]=array('P000317',array(63463 ,0),array('',''),"desc");
      $arr[]=array('P000320',array(58760 ,0),array('',''),"desc");
      $arr[]=array('P000375',array(0 ,0),array('',''),"desc");
      $arr[]=array('P000433',array(59445 ,0),array('',''),"desc");
      $arr[]=array('P000455',array(58930,0),array('',''),"desc");
      $arr[]=array('P000477',array(60551 ,0),array('',''),"desc");
      $arr[]=array('P000481',array(59983 ,0),array('',''),"desc");
      $arr[]=array('P000488',array(60068 ,0),array('',''),"desc");
      $arr[]=array('P000493',array(61664 ,0),array('',''),"desc");
      $arr[]=array('P000518',array(58754,0),array('',''),"desc");
      $arr[]=array('P000520',array(58882,58820),array('',''),"desc");
      $arr[]=array('P000534',array(59445,0),array('',''),"desc");
      $arr[]=array('P000590',array(59190,62294,62293 ),array('',''),"desc");
      $arr[]=array('P000614',array(62155,58725,61544,59983),array('',''),"desc");
      $arr[]=array('P000790',array(0,0),array('',''),"desc");
      $arr[]=array('P002248',array(61185,61166,57348),array('',''),"desc");
      $arr[]=array('P004735',array(60446,60447),array('',''),"desc");
      $arr[]=array('P004738',array(61502 ,0),array('',''),"desc");
      $arr[]=array('P004784',array(60103 ,0),array('',''),"desc");
      $arr[]=array('P004806',array(59902,63153,58878,62551 ),array('',''),"desc");
      $arr[]=array('P004871',array(0,0),array('',''),"desc");
      $arr[]=array('P004966',array(62293,61660 ),array('',''),"desc");
      $arr[]=array('P005087',array(62231 ,0),array('',''),"desc");
      $arr[]=array('P005162',array(58733 ,0),array('',''),"desc");
      $arr[]=array('P005166',array(63247 ,63475,58733,62443),array('',''),"desc");
      $arr[]=array('P005198',array(62548 ,0),array('D58',''),"desc");
      $arr[]=array('P005252',array(58760 ,0),array('',''),"desc");
      $arr[]=array('P005289',array(59983 ,0),array('',''),"desc");
      $arr[]=array('P005305',array(59445 ,0),array('',''),"desc");
      $arr[]=array('P005469',array(59060,62521,63199,63510,58716 ),array('',''),"desc");
      $arr[]=array('sumeriandevelopment',array(0,0),array('',''),"desc");
      $arr[]=array('P005067',array(0,0),array('',''),"desc");
      $arr[]=array('P005323',array(62257,0),array('T11B',''),"desc");
      $arr[]=array('P005353',array(0,0),array('',''),"desc");
      $arr[]=array('P005381',array(0,0),array('V30',''),"desc");
      $arr[]=array('P005995',array(0,0),array('',''),"desc");
      $arr[]=array('P005996',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('P005988',array(60179,60569),array('',''),"desc");
      $arr[]=array('P221629',array(0,0),array('',''),"desc");
      $arr[]=array('P005626',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('P222407',array(0,0),array('',''),"desc");
      $arr[]=array('P221357',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('P000003',array(62443,0),array('',''),"desc");
      $arr[]=array('P000006',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('P000744',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('P000789',array(0,0),array('',''),"desc");
      $arr[]=array('P000812',array(0,0),array('',''),"desc");
      $arr[]=array('P000813',array(0,0),array('',''),"desc");
      $arr[]=array('P000821',array(63477,0),array('',''),"desc");
      $arr[]=array('P000831',array(0,0),array('',''),"desc");
      $arr[]=array('P000834',array(0,0),array('',''),"desc");
      $arr[]=array('P000846',array(0,0),array('',''),"desc");
      $arr[]=array('P000884',array(0,0),array('',''),"desc");
      $arr[]=array('P000927',array(0,0),array('',''),"desc");
      $arr[]=array('P000958',array(59892,59897,61464),array('',''),"desc");
      $arr[]=array('P001025',array(0,0),array('',''),"desc");
      $arr[]=array('P001137',array(0,0),array('',''),"desc");
      $arr[]=array('P001140',array(60987,0),array('',''),"desc");
      $arr[]=array('P001226',array(60987,0),array('',''),"desc");
      $arr[]=array('P001234',array(0,0),array('',''),"desc");
      $arr[]=array('P001251',array(0,0),array('',''),"desc");
      $arr[]=array('P001259',array(0,0),array('',''),"desc");
      $arr[]=array('P001264',array(0,0),array('',''),"desc");
      $arr[]=array('P001273',array(62454,60356),array('',''),"desc");
      $arr[]=array('P001274',array(62873,62555),array('',''),"desc");
      $arr[]=array('P001275',array(60549,62539),array('',''),"desc");
      $arr[]=array('P001284',array(63429,62368),array('',''),"desc");
      $arr[]=array('P001287',array(0,0),array('',''),"desc");
      $arr[]=array('P001291',array(62556,60570),array('',''),"desc");
      $arr[]=array('P001293',array(58299,0),array('',''),"desc");
      $arr[]=array('P001294',array(58170,0),array('',''),"desc");
      $arr[]=array('P001299',array(58690,58691),array('',''),"desc");
      $arr[]=array('P001301',array(61067,58765),array('',''),"desc");
      $arr[]=array('P001305',array(60569,0),array('',''),"desc");
      $arr[]=array('P001307',array(60469,0),array('',''),"desc");
      $arr[]=array('P001309',array(60442,58921),array('',''),"desc");
      $arr[]=array('P001313',array(0,0),array('',''),"desc");
      $arr[]=array('P001314',array(58945,0),array('',''),"desc");
      $arr[]=array('P001316',array(58945,0),array('',''),"desc");
      $arr[]=array('P001322',array(0,0),array('',''),"desc");
      $arr[]=array('P001326',array(0,0),array('',''),"desc");
      $arr[]=array('P001334',array(62843,62844),array('',''),"desc");
      $arr[]=array('P001344',array(60314,62361),array('',''),"desc");
      $arr[]=array('P001348',array(0,0),array('',''),"desc");
      $arr[]=array('P001349',array(62559,0),array('',''),"desc");
      $arr[]=array('P001353',array(60560,0),array('',''),"desc");
      $arr[]=array('P001357',array(61152,0),array('',''),"desc");
      $arr[]=array('P001361',array(0,0),array('',''),"desc");
      $arr[]=array('P001369',array(0,0),array('',''),"desc");
      $arr[]=array('P001385',array(0,0),array('',''),"desc");
      $arr[]=array('P001391',array(60560,0),array('',''),"desc");
      $arr[]=array('P001394',array(0,0),array('',''),"desc");
      $arr[]=array('P001399',array(0,0),array('',''),"desc");
      $arr[]=array('P001400',array(0,0),array('',''),"desc");
      $arr[]=array('P001412',array(60314,62361),array('',''),"desc");
      $arr[]=array('P001428',array(0,0),array('',''),"desc");
      $arr[]=array('P001472',array(0,0),array('',''),"desc");
      $arr[]=array('P001523',array(0,0),array('',''),"desc");
      $arr[]=array('P001531',array(61897,61898,61891,60995),array('',''),"desc");
      $arr[]=array('P001596',array(0,0),array('',''),"desc");
      $arr[]=array('P001664',array(60387,59852),array('',''),"desc");
      $arr[]=array('P001764',array(0,0),array('',''),"desc");
      $arr[]=array('P001920',array(63358,0),array('',''),"desc");
      $arr[]=array('P002177',array(58926,0),array('',''),"desc");
      $arr[]=array('P002208',array(59853,0),array('',''),"desc");
      $arr[]=array('P002212',array(0,0),array('',''),"desc");
      $arr[]=array('P000037',array(62552,0),array('',''),"desc");
      $arr[]=array('P000161',array(60203,0),array('',''),"desc");
      $arr[]=array('P001063',array(0,0),array('',''),"desc");
      $arr[]=array('P001995',array(58757,63047),array('',''),"desc");
      $arr[]=array('P002004',array(0,0),array('',''),"desc");
      $arr[]=array('P002068',array(60563,0),array('',''),"desc");
      $arr[]=array('P002533',array(0,0),array('',''),"desc");
      $arr[]=array('P002590',array(0,0),array('',''),"desc");
      $arr[]=array('P002611',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      $arr[]=array('',array(0,0),array('',''),"desc");
      
      
      
      
      $this->mapcjh = array();   
      foreach($arr as $ar){
         if($ar[0]=='') continue;
         $this->mapcjh[] = $ar;
         
         foreach($ar[1] as $val){
            if($val==0 || $val=='') continue;
            if(in_array($val,$this->j4c)) continue;
            $this->j4c[] = $val;
         }
         foreach($ar[2] as $val){
            if($val==0 || $val=='') continue;
            if(in_array($val,$this->h4c)) continue;
            $this->h4c[] = $val;
         }
      }
   }
   
   
   public function show_tr(){
      
      foreach($this->mapcjh as $idx => $ar){
         if($ar[0]=='') continue;
         echo "<tr>";
         echo "<td>$idx";
         echo "</td>";
         
         echo "<td>";
         $this->show_cid($ar[0]);
         echo "</td>";
         
         echo "<td>";//jqw
         $this->show_jid($ar[1]);
         echo "</td>";
         
         echo "<td>";//hiero
         $this->show_hid($ar[2]);
         echo "</td>";
         
         echo "<td>";//desc
         echo $ar[3];
         echo "</td>";
         
         echo "</tr>";
      }
      
   }
   
   
   
   
   
   public function Jqw2earlycuneiform(){
      $this->j4c[] = 0;
      $this->init_mapcjh();
   }


   
      
   public function show_all_jqw(){
   
      $d2h = new DbRow2Htm();
      $this->j4c = array_unique($this->j4c);
      $tot=0;
      echo "<br>";
      foreach($this->j4c as $val){
         if($val==0 || $val == '' ) continue;
         $src = $d2h->img_src_of($val);
         echo "<img src='" . $src . "'/>$val";
         $tot++;
      }
      echo "<br>tot=$tot";
   }
   public function show_cid($pid){
      $src = "../../oorsc/cuneiform/cdl/map_j2ec/". $pid . ".jpg";
      
      echo "<img src='" . $src . "' width='120' alt='$pid' class='cid'/>$pid";
   }   
   public function show_jid_single($jid){
      if(is_array($jid) || $jid=='' || $jid==0 ){
         return;
      }

      $this->j4c[] = $jid;
      $d2h = new DbRow2Htm();
      $src = $d2h->img_src_of($jid);
      echo "<img src='" . $src . "'/>$jid";
   }
   public function show_jid($jid){
      if(is_array($jid)){
         foreach($jid as $val){
            $this->show_jid_single($val);
         }
      }
      else{
         $this->show_jid_single($jid);
      }
   }
   
   
   
   public function show_hid_single($hid){
      if($hid == '' ) return;
      $this->h4c[] = $hid;
      $d2h = new DbRow2Htm();
      $src = $d2h->img_src_of($hid);
      echo "<img src='" . $src . "'/>$hid";
   }
   public function show_hid($hid){
      if(is_array($hid)){
         foreach($hid as $val){
            $this->show_hid_single($val);
         }
      }
      else{
         $this->show_hid_single($hid);
      }
   }
}
$j2c = new Jqw2earlycuneiform();


$index = 1;
function idx(){
   global $index;
   echo $index++;
}
?>


<html>
<head>
                <title>jgw db viewer</title>

                <script type="text/javascript" src="../../_js/jquery.js"></script>
                <script type="text/javascript" src="../../_js/jquery.cookie.js"></script>
                <script type="text/javascript" src="../_js/uti.js"></script>

                <!-- Users -->
                </head>

<script type="text/javascript">
$(document).ready(function(){     

   $("img.cid").click( function(){
      var src = $(this).attr("src");
      window.open(src,'_blank', 'left=0,top=0,width=2000,height=1000,resizable=yes,scrollbars=yes,toolbar=no,location=no,directories=no,statusbar=no,menubar=no');

   });
   
});//$(document).ready(function(){                                            
</script>

<body>

<a href="http://cdli.ucla.edu">http://cdli.ucla.edu</a><br>

<a>sumary:</a>
<?php $j2c->show_all_jqw(); 


?>


<table border="1">
<tr>
   <td>indx</td>
   <td>cuneiform</td>
   <td>TBI</td>
   <td>Hieroglyphics</td>
   <td>desc</td>
</tr>
<?php $j2c->show_tr();?>

</table>





</body>
</html>