<?php
class GraphicsEnvironment
{
  public $width;
  public $height;
  public $gdo;
  public $colors = array();

  public function __construct( $width, $height )
  {
    $this->width = $width;
    $this->height = $height;
    $this->gdo = imagecreatetruecolor( $width, $height );
    $this->addColor( "white", 250, 250, 200 );
    imagefilledrectangle( $this->gdo, 0, 0,
      $width, $height,
      $this->getColor( "white" ) );
  }

  public function width() { return $this->width; }

  public function height() { return $this->height; }

  public function addColor( $name, $r, $g, $b )
  {
    $this->colors[ $name ] = imagecolorallocate(
      $this->gdo,
      $r, $g, $b );
  }

  public function getGraphicObject()
  {
    return $this->gdo;
  }

  public function getColor( $name )
  {
    return $this->colors[ $name ];
  }

  public function saveAsPng( $filename )
  {
    imagepng( $this->gdo, $filename );
  }
  public function showPng( )
  {
    header("Content-type: image/png");
    imagepng( $this->gdo );
  }
}





abstract class GraphicsObject
{
  abstract public function render( $ge );
}

class Line extends GraphicsObject
{
  private $color;
  private $sx;
  private $sy;
  private $ex;
  private $ey;

  public function __construct( $color, $sx, $sy, $ex, $ey )
  {
    $this->color = $color;
    $this->sx = $sx;
    $this->sy = $sy;
    $this->ex = $ex;
    $this->ey = $ey;
  }

  public function render( $ge )
  {
    imageline( $ge->getGraphicObject(),
      $this->sx, $this->sy,
      $this->ex, $this->ey,
      $ge->getColor( $this->color ) );
  }
}




////////////////////////////////////////
class Curve extends GraphicsObject
{
  public $Yarr;  
  
  public $color;
  public $bUp;
  public $Yoffset;

  public function __construct( )
  {
    $this->color = array(0,0,0);
    $this->Yoffset = 0.75;
    $this->bUp = 1;
  }
  public function push( $y )
  {
    $this->Yarr[] = $y;
  }
  public function SetYarr( $arr )
  {
    $this->Yarr = $arr;
  }

  public function render( $ge )
  {
      $this->render_grid($ge );
      if( $this->bUp ) {
         $this->render_up( $ge );
      }
      else{
         $this->render_dwn( $ge );
         }
  }
    public function render_up( $ge )
  {
      $geo = $ge->getGraphicObject();
      $clr = imagecolorallocate($geo, $this->color[0], $this->color[1], $this->color[2] );
         
      $xo=0;
      $yo=0;
      $offset =  $ge->height() * $this->Yoffset;///2-10;
      foreach( $this->Yarr as $x=>$y ) 
      {
         $y = $offset - $y;
         imageline( $geo,$xo, $yo, $x, $y, $clr );
         //syslog(0,"x=".$x.", y=".$y);
         $xo = $x;
         $yo = $y;
     }
  }
    public function render_dwn( $ge )
  {
      
      
      $geo = $ge->getGraphicObject();
      $clr = imagecolorallocate($geo, $this->color[0], $this->color[1], $this->color[2] );
         
      $xo=0;
      $yo=0;
      $offset =  $ge->height()/2 + $this->Yoffset;///2-10;
      foreach( $this->Yarr as $x=>$y ) 
      {
         $y = $offset + $y;
         imageline( $geo,$xo, $yo, $x, $y, $clr );
         //syslog(0,"x=".$x.", y=".$y);
         $xo = $x;
         $yo = $y;
     }
  }
  public function render_grid( $ge )
  {
      $geo = $ge->getGraphicObject();
      $clr = imagecolorallocate($geo, 100, 100, 100 );
         
      $offset =  $ge->height() * $this->Yoffset;///2-10;
      imageline( $geo,0, $offset, $ge->width(), $offset, $clr );
    
      
      
  }
  
}



////////////////////////////////////////
class MatchLines extends GraphicsObject
{
  public $color;
  public $pairs;

  public $Yoffset;
  public $matchRange;
  public function __construct( )
  {
    //$this->color = $color;
    $this->Yoffset = 0.75;
    $this->matchRange = 100;
  }
  public function push( $y )
  {
    $this->Yarr[] = $y;
  }
  public function SetPairs( $LineArr )
  {
    $this->pairs = $LineArr;
  }
  public function render( $ge )
  {
      $geo = $ge->getGraphicObject();
      $clr[0] = imagecolorallocate( $geo, 0, 225, 0 );
      $clr[1] = imagecolorallocate( $geo, 0, 0, 0 );
      $clr[2] = imagecolorallocate( $geo, 255, 0, 0 );
         
      foreach( $this->pairs as $indx => $line ) 
      {
         $x0 = $line[0];
         $y0 = $ge->height()* $this->Yoffset;
         $x1 = $line[1];
         $y1 = $ge->height();
         
         $sel=0;
         if($this->matchRange<0) {
            $sel=2;
         }
         else if( abs( $line[0] - $line[1]) > $this->matchRange ) {
            $sel=1;
         }
         
         imageline( $geo,$x0, $y0, $x1, $y1, $clr[$sel] );
 
     }
  }
}








?>
