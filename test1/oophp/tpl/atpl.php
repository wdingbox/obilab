<?php
//append tpl class
class atpl {

   public $contents;
	
   //print tpl content
	public static function printent($tplname){
        @session_start();        

        ob_start();
        include ($tplname);
        $contents = ob_get_contents ();
        ob_end_clean ();

        echo $contents;
    }
	
}


?>