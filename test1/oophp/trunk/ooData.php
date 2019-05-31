

<?php

require_once("../uti/Ureaddir.php");
require_once("../uti/MysqlHieroglyphics.php");

require_once("../uti/MysqlJiaguwen.php");
//require_once("../uti/DbRow2Htm.php");



class ooData{
public $info;
public static function AddChildNode(&$parentNode, $attrName,$jnm, $ulNew, $imgSrc){
    if(null===$ulNew){
        $ulNew= $parentNode->addChild("ul");
    }
	$liNew= $ulNew->addChild("li");
	$FindNode= $liNew->addChild("span");
	$FindNode->addAttribute($attrName, $jnm);
	$txtNode= $FindNode->addChild("div",$jnm );
	$txtNode->addAttribute("class", "ootxt");
	
    if($imgSrc != null) {
        $img = $FindNode->addChild('img');
        $img->addAttribute("src", "");
        $img->addAttribute("class", "ooimg");//class="ooimg"
        $img->addAttribute("title", "$jnm::$imgSrc");//class="ooimg"
    }
	return $FindNode;
}
public function GenXmlDataForTree(){

	$againstDir = "../uti/jgw/mer/compound/p/";
	$againstDir = "../../odb/tbi/img/jgif/";
	if( !file_exists($againstDir)){
		echo "<font color='red'>no file exist:</font>";
	}


	$sql = "SELECT * FROM Jiaguwen ORDER BY jid";
	$sql = "SELECT * FROM Jiaguwen";
	$sql = "SELECT * FROM Jiaguwen WHERE jtoh LIKE '%,%' LIMIT 0,10";
	$sql = "SELECT jnm, jid FROM Jiaguwen  WHERE jnm<>'0' AND jnm <>'-' AND jnm<>'' ORDER BY jnm  LIMIT 0,10000";
	if( isset($_REQUEST["sql"]) && strlen($_REQUEST["sql"])>0 ){
		$sql = $_REQUEST["sql"];
	}
	else{
		$_REQUEST["sql"]="";
	}



	if( preg_match("/Hieroglyphics/i",$sql)==1){
		//$db = new MysqlHieroglyphics();
	}

	$db = new MysqlJiaguwen();


	$ret = $db->query($sql);
	$this->info = "count=". count($ret) .  ", " . $sql . "<br>";

	$attrName="jnm";

	$newsXML = new SimpleXMLElement("<li>0</li>");
	$newsXML->addAttribute('id', "treview");
	self::AddChildNode($newsXML, $attrName, "1", null,"");
	self::AddChildNode($newsXML, $attrName, "2", null,"");
	self::AddChildNode($newsXML, $attrName, "3", null,"");
	self::AddChildNode($newsXML, $attrName, "4", null,"");
	self::AddChildNode($newsXML, $attrName, "5", null,"-");
	self::AddChildNode($newsXML, $attrName, "6", null,"-");

	//////////////////////////////////////
	//add list table

	//$newTable = $newsXML->addChild('table');
	foreach ($ret as $row){
		$jnm = $row['jnm'];
		$jid = $row['jid'];
		if(!isset($jnm) || !isset($jid) ) {

		}
		$imgSrc=$againstDir.  $jid . ".gif";
		$arrJnm = explode(".",$jnm);
		$count = count($arrJnm);
		$arrId=Array();
		$arrId[]="$jnm";
		for($i=$count-1; $i>=0;  $i-=1){
			unset($arrJnm [$i]) ;
			$arrId[]=implode(".",$arrJnm);
		}



		$FindNode=null;
		$FindJNM="$jnm";
		foreach($arrId as $idx => $ID){
			$result = $newsXML->xpath("//*[@" . $attrName . "='" . $ID . "']"); //get all nod with attr is valold.
			while( list(,$node) = each($result) ) {
				//$node[$attrName]=$attrValNew;
				$FindNode = $node;
				$FindJNM = $ID;
			}
			if($FindNode){
				break;
			}
		}

		if($FindNode != null){
			if($FindJNM !=  $jnm){
				$lis = $FindNode->xpath("..");
				$li=null;
				while( list(,$node) = each($lis) ) {
					//$node[$attrName]=$attrValNew;
					$li = $node;
					break;
				}

				if($li!=null){
					$uls = $li->xpath("./ul");
					$ul=null;
					while( list(,$node) = each($uls) ) {
						//$node[$attrName]=$attrValNew;
						$ul = $node;
						break;
					}
                    
                    $FindNode = self::AddChildNode($li, $attrName,$jnm, $ul, null);

				}
				else{
				}
				
			}
		}
		else if(null===$FindNode){
			$FindNode = self::AddChildNode($newsXML, $attrName,$jnm, $FindNode, null, null);
		}

		$img = $FindNode->addChild('img');
		$img->addAttribute("src", $imgSrc);
		$img->addAttribute("class", "ooimg");//class="ooimg"
		$img->addAttribute("title", "$jnm::$jid");//class="ooimg"

	}

	$xstr = $newsXML->asXML();
	echo "\n\n" . $xstr . "\n\n";
}
}//class 
$od = new ooData();
$od->GenXmlDataForTree();

?>



