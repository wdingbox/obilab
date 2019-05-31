<?php
@session_start();

require_once( "../uti/graph/glib.php" );
require_once( "../uti/StatisticFileReader.php" );


$img = "/tmp/test.png";
//$ge->saveAsPng( $img );
//$ge->showPng();

//print_r($_REQUEST);

$file0 = $_SESSION["sel_0"];
$file1 = $_SESSION["sel_1"];
//$_SESSION["sel_0"] = $file0;
//$_SESSION["sel_1"] = $file1;

syslog(0, "file0=$file0,file1=$file1");


$scmp = new StatisticCompare();
$scmp->compare($file0,$file1);
//$scmp->show();
//exit(0);

//$sfr0 = new StatisticFileReader();
//$sfr0->load("/tmp/$file0");

//$sfr1 = new StatisticFileReader();
//$sfr1->load("/tmp/$file1");

//$stam = new StatisticMatch();
//$stam->match2($sfr0->words, $sfr1->words);


/////////////////////////////////////
$ge = new GraphicsEnvironment( 1000, 1000 );

$mat = new MatchLines( array(0,0,255) );
$mat->SetPairs($scmp->match->pairs);
$mat->render( $ge );

$curv =  new Curve();

$curv->bUp=1;
$curv->color = array(0,0,255);
$curv->SetYarr( $scmp->sfr0->rfrqs );
$curv->render( $ge );

$curv->bUp=1;
$curv->color = array(255,0,0);
$curv->SetYarr( $scmp->sfr1->rfrqs );
$curv->render( $ge );


if( isset($_REQUEST["key"] ) ){
   $keyword = $_REQUEST["key"];
   $pairs = $scmp->compareKeyword( $keyword );
   $mat->matchRange = -1;
   $mat->SetPairs($pairs);
   $mat->render( $ge );
}


$ge->showPng();
?>