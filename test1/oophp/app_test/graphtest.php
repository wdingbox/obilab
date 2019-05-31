<?php
require_once( "../uti/graph/glib.php" );
require_once( "../uti/StatisticFileReader.php" );

// Set the content-type


$sfr = new StatisticFileReader();
$sfr->load("/tmp/xyz_.~books~c~cb_gospel.htm");
//$sfr->load("/tmp/xyz_.~books~e~bible_bbe.htm");

//$sfr->test();
//echo "aaa";



$sfr2 = new StatisticFileReader();
$sfr2->load("/tmp/xyz_.~books~c~cb_ot.htm");

$sfr3 = new StatisticFileReader();
$sfr3->load("/tmp/xyz_.~books~e~daughter - Copy (13).htm");

$sfr4 = new StatisticFileReader();
$sfr4->load("/tmp/xyz_.~books~c~HongLouMeng.htm");

$sfr5 = new StatisticFileReader();
$sfr5->load("/tmp/xyz_.~books~c~SanGuoYanYi.htm");

$sfr6 = new StatisticFileReader();
$sfr6->load("/tmp/xyz_.~books~c~MaoZeDongZhuZhuo.htm");


$ge = new GraphicsEnvironment( 4000, 400 );

$ge->addColor( "black", 0, 0, 0 );
$ge->addColor( "red", 255, 0, 0 );
$ge->addColor( "green", 0, 255, 0 );
$ge->addColor( "blue", 0, 0, 255 );

$gobjs = array();
$gobjs []= new Line( "black", 10, 5,      100, 200 );
$gobjs []= new Line( "blue", 200, 150,    390, 380 );
$gobjs []= new Line( "red", 60, 40,       10, 300 );
$gobjs []= new Line( "green", 5, 390,     390, 10 );

foreach( $gobjs as $gobj ) { $gobj->render( $ge ); }

$img = "/tmp/test.png";
//$ge->saveAsPng( $img );
//$ge->showPng();


$curv =  new Curve(array(100,100,100));

$curv->SetYarr( $sfr->rfrqs );
$curv->render( $ge );

$curv->SetYarr( $sfr6->rfrqs );
$curv->render( $ge );

//$curv->SetYarr( $sfr3->rfrqs );
//$curv->render( $ge );

//$curv->SetYarr( $sfr4->rfrqs );
$curv->render( $ge );

//$curv->SetYarr( $sfr5->rfrqs );
$curv->render( $ge );


$stam = new StatisticMatch();
$stam->match2($sfr->words, $sfr6->words);



$mat = new MatchLines( array(0,0,255) );
$mat->SetPairs($stam->pairs);
$mat->render( $ge );

$ge->showPng();

//echo "<img src='$img'/>";
echo $img;
?>
 

