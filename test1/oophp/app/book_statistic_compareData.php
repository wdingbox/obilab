<?php
@session_start();

require_once( "../uti/graph/glib.php" );
require_once( "../uti/StatisticFileReader.php" );


$img = "/tmp/test.png";
//$ge->saveAsPng( $img );
//$ge->showPng();

//print_r($_REQUEST);
function setfile($i)
{
   $selid="sel_".$i;
   if( !isset($_REQUEST[$selid]))
   {
      return $_SESSION["sel_0"];
   }
   $_SESSION[$selid] = $_REQUEST[$selid];
   return $_SESSION[$selid]; 
}

$file0 = setfile(0);//$_REQUEST["sel_0"];
$file1 = setfile(1);//$_REQUEST["sel_1"];
//$_SESSION["sel_0"] = $file0;
//$_SESSION["sel_1"] = $file1;

print("$file0 <=> $file1 <a href='book_statistic_compareGraph.php'>View Graph</a><br>\r\n");






syslog(0, "file0=$file0,file1=$file1");
$sc = new StatisticCompare();
$sc->compare($file0,$file1);
$sc->show("statistic_compareGraph.php");
exit(0);



















$sfr0 = new StatisticFileReader();
$sfr0->load("/tmp/$file0");

$sfr1 = new StatisticFileReader();
$sfr1->load("/tmp/$file1");

$stam = new StatisticMatch();
$stam->match2($sfr0->words, $sfr1->words);

$iMax = count($sfr0->statistic);
if( $iMax > count($sfr1->statistic) ) $iMax = count($sfr1->statistic);
for( $ii=0; $ii<$iMax ; $ii++)
{

   if( $stam->IsMatch($ii) ) print "*****";
   else print ("- - - -");
   
   print($sfr0->statistic[$ii]."===".$sfr1->statistic[$ii] . "<br>");
}

exit(0);










/////////////////////////////////////
$ge = new GraphicsEnvironment( 1000, 1000 );

$mat = new MatchLines( array(0,0,255) );
$mat->SetPairs($stam->pairs);
$mat->render( $ge );

$curv =  new Curve();

$curv->bUp=1;
$curv->color = array(0,0,255);
$curv->SetYarr( $sfr0->rfrqs );
$curv->render( $ge );

$curv->bUp=1;
$curv->color = array(255,0,0);
$curv->SetYarr( $sfr1->rfrqs );
$curv->render( $ge );



//$ge->showPng();
?>