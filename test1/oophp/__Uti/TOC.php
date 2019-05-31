<?php
//require_once("Uti.php");
//require_once("Wsss.php");
//$SCANDIR_SORT_DESCENDING 1
class UmgTreeCalc{
	private $depth=0;
	public $nDepthMax=-1;
	public $nTotalLeaf=0;
	public $nLeaf=0;
	private $path="";
	public function UmgTreeCalc($path, $basename){
		$this->path=$path;
		$this->depth=0;
		$this->WalkFolderDepth($path, $basename);
		$this->nLeaf = $this->countLeaf($path);
	}
	static function GetLeafPath($pathStart){
		$cwd = getcwd();
		$arr= explode($pathStart, $cwd);
		if(count($arr) !== 2){
			die("GetLeafPath() Error: " . $cwd.",".$pathStart);
		}
		$cwd = $arr[1];
		$cwd = str_replace("/", "  /  ", $cwd);
		$cwd = str_replace("_", "  ", $cwd);
		return $cwd;
	}
	public function WalkFolderDepth($path, $basename){

		$this->depth+=1;
		if( $this->nDepthMax < $this->depth ) $this->nDepthMax = $this->depth;
		$this->nTotalLeaf += $this->countLeaf($path);
		$pathArr = scandir( $path);
		foreach ( $pathArr as $i => $entry ) {
			if ( $entry === "."  || $entry === ".."  || $entry[0] === '_') {
				continue;
			}
			$dir="$path/$entry";
			if ( is_dir($dir) ){
				$this->WalkFolderDepth($dir,$entry);
			}
		}
		$this->depth-=1;
	}
	public function countLeaf($path){
		$nLeaf=0;
		$files = scandir( $path);
		foreach ( $files as $i => $entry ) {
			$dir="$path/$entry";
			if ( is_dir($dir) ){
				if( '~'===$entry[0]){
					$nLeaf+=1;
				}
			}
		}
		return $nLeaf;
	}
	public function isLeaf(){
		if( $this->nLeaf >0 ||  $this->nDepthMax>1) return false;
		return true;
	}



}


class UmgTreeNodeImg{
	private $imgsrc="_js/jqwidgets/images/";

	private $imgDefault="";

	// singleton instance
	private static $instance;

	// private constructor function
	// to prevent external instantiation
	private function __construct() {
		$this->initImgSrcDir();
	}

	// getInstance method
	public static function getInstance() {
		if(!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function initImgSrcDir(){
		$filename = $this->imgsrc;
		for($i=0;$i<50;$i++){
			if( file_exists($filename) ){
				$this->imgsrc = $filename;
				return;
			}
			$filename="../$filename";
		}
	}

	public function getTreeNodeImg($pathfilename){
		$TreeAttrFilename = "";
		$img=$this->imgDefault;
		if( is_dir ($pathfilename) ) {
			if(strlen($img)==0) $img="folder.png";//defualt for folder notesIcon, inheritable.
			$basename = basename($pathfilename);
			if( '~' === $basename[0] ){
				$img="settings.png";//defualt for leaf node.  un-inheritable.
			}
			$TreeAttrFilename="$pathfilename/_.xml";
		}
		//else{
		//	$img="settings.png";//defualt for file. un-inheritable.
		//	$TreeAttrFilename = str_replace(".php",".xml", $pathfilename);
		//}
		if( file_exists($TreeAttrFilename) ){
			$xml = simplexml_load_file($TreeAttrFilename);
			if( count($xml->img)>0 ) $img = $xml->img;
			if( is_dir ($pathfilename) ) {
				$this->imgDefault = $img; //update default for folder to allow inheritance.
			}
		}
		return $this->imgsrc . $img;
	}
}

















class UmgTree{
	public static function getViewableChildDir($dir){
		$files = scandir( $dir);
		natsort($files);
		return $files;
	}
	public static  function genElementID($path){
		$id = str_replace(" ","_", $path);
		$id = str_replace("/","_", $id);
		$id = str_replace(".","_", $id);
		$id = str_replace("~","_", $id);

		$id = str_replace("(","_", $id);
		$id = str_replace(")","_", $id);

		$id = str_replace("[","_", $id);
		$id = str_replace("]","_", $id);

		$id = str_replace("{","_", $id);
		$id = str_replace("}","_", $id);
		return $id;
	}
	public static  function TreeNodeName($FileName){
		$FileName = str_replace("_"," ", $FileName);
		$FileName = str_replace("~"," ", $FileName);
		return $FileName;
	}
}





//Generate Tree data for jqWidget.
class UmgTreeCreator{
	public $ret="\n";


	public function UmgTreeCreator($directory, $basename){
		$cwd = getcwd();
		//chdir($directory);
		$this->walk($directory, "");
		//chdir($cwd);
	}
	public function getPos($fname){
		$pos0=strpos($fname,"-");
		$pos1=strpos($fname,"_");
		if( $pos0 ===false && $pos1 ===false){
			return -1;
		}
		else if($pos0==false && $pos1>0){
			return $pos1;
		}
		else if($pos0>0 && $pos1 === false){
			return $pos0;
		}

		return ($pos0>$pos1 ? $pos1 : $pos0 );
	}
	//recursive function
	public function walk($dir, $basename){
		$files = UmgTree::getViewableChildDir($dir);
		if( count($files)>0) {
			$this->ret .= "\n<ol >\n";
			//for folders.
			foreach ( $files as $i => $entry ) {
				$pos = $this->getPos($entry);
				
				if($pos<=0)continue;
				$txt = substr($entry, 1+$pos); //echo $pos . "=$txt====".$entry . "<br>";
				$dir2 = "$dir/$entry";
				if ( is_dir($dir2) ){
					$this->ret .= "<li><a href='$dir2'>$txt</a></li>\n";
					$this->walk($dir2,$entry);
					//echo "$i -dir2: $dir2 <br>";
				}
				else{
					$this->ret .= "<li><a href='$dir2'>$txt</a></li>\n";
				}
			}
			$this->ret .= "\n</ol>\n";
		}

		return;
	}

	protected function li_header_folder($path, $basename){
		//$path is always the folder.
		if( strlen($basename)==0) return;
		$utree = new UmgTreeCalc($path,$basename);
		$expand="";
		if( false === $utree->isLeaf() ) {
			$expand=" [+] " ;
		}

		$img = UmgTreeNodeImg::getInstance()->getTreeNodeImg($path);

		$id = UmgTree::genElementID( $path );
		$basename = str_replace("_"," ", $basename);

		$this->ret .= "<li id='$id'>";
		$this->ret .= "<img class='UmgUiTreeImg' src='$img'/>";
		$this->ret .= "<span title='$path/'  class='UmgUiTreeNodName UmgFolderNode'>$basename</span>";
		$this->ret .= "<span class='UmgUiTreeExpand' item-title='true' title='Expand All Subtree ($utree->nTotalLeaf)'> $expand</span>\n";



	}
	public function li_leaf($path, $file) {
		if( '~'!==$file[0]) {
			return;
		}

		$id = UmgTree::genElementID( $path );

		$img = UmgTreeNodeImg::getInstance()->getTreeNodeImg($path);
		$basename = substr($file, 1);
		$basename =  str_replace("_"," ", $basename);

		$this->ret .= "<li id='$id'><img class='UmgUiTreeLeaf' src='$img'/><span title='$path' class='UmgUiTreeNodName UmgFileNode'>$basename</span></li>\n";


		return;
	}
	protected function li_tailer($dir, $basename){
		if( strlen($basename)==0) return;
		$this->ret .="</li>\n";
	}


	public function mktree(){
		echo $this->ret;
	}
}





/* var source =
 [
 { icon: "../../images/mailIcon.png2", label: "Mail", expanded: true, items:
 [
 { icon: "../../images/calendarIcon.png", label: "Calendar" },
 { icon: "../../images/contactsIcon.png", label: "Contacts", selected: true }
 ]
 },

 { icon: "../../images/folder.png", label: "Inbox", expanded: true, items: [
 { icon: "../../images/folder.png", label: "Admin" },
 { icon: "../../images/folder.png", label: "Corporate" },
 { icon: "../../images/folder.png", label: "Finance" },
 { icon: "../../images/folder.png", label: "Other" },
 ]
 },

 { icon: "../../images/recycle.png", label: "Deleted Items" },

 { icon: "../../images/notesIcon.png", label: "Notes" },

 { iconsize: 14, icon: "../../images/settings.png", label: "Settings" },

 { icon: "../../images/favorites.png", label: "Favorites" },
 ]; */

//Generate Tree source for jqWidget.

//Generate Tree data for jqWidget.
class UmgTreeSource{
	public $ret="\n";
	public function UmgTreeSource($directory, $basename){
		$cwd = getcwd();
		$rootdir = "";//Uti::FindRequiredFile($directory);
		$this->walk($rootdir, "");
		//chdir($cwd);
	}
	//recursive function
	public function walk($dir, $basename){
		$files = UmgTree::getViewableChildDir($dir);
		if( count($files)>0) {
			//for folders.
			foreach ( $files as $i => $entry ) {
				if(strlen($entry)===0)continue;
				$dir2 = "$dir/$entry";
				if ( is_dir($dir2) ){
					//echo "$i -dir2: $dir2 <br>";
					switch( $entry[0] ){
						case '_':       // ignored.
							continue;
						case '~' :		//defined leaf node. stop recursive here.
							$this->li_leaf($dir2,$entry);
							break;
						default:       //FolderNode, go deeper.
							$bas=basename($dir2);
							$this->li_begin($dir2, $bas);
							$this->walk($dir2,$bas);
							$this->li_end($dir2, $bas);
							break;
					}
				}
			}
		}
		return;
	}

	protected function li_begin($path, $basename){
		//$path is always the folder.
		$img = UmgTreeNodeImg::getInstance()->getTreeNodeImg($path);
		$basename = UmgTree::TreeNodeName($basename);

		$anode="<a url='$path' title='$path' class='UmgUiTreeNodName'>$basename</a>";
		$this->ret .= "\n { icon: \"$img\", label: \"$anode\", expanded: false, items:[";
	}
	public function li_leaf($path, $basename) {
		//$path is always the folder.
		$img = UmgTreeNodeImg::getInstance()->getTreeNodeImg($path);
		$basename = UmgTree::TreeNodeName($basename);

		$anode="<a url='$path' title='$path' class='UmgUiTreeNodName'>$basename</a>";
		$this->ret .= "\n  { icon: \"$img\", label: \"$anode\", expanded: false},";
	}
	protected function li_end($dir, $basename){
		$this->ret .="\n  ]\n },\n";
	}


	public function mksrcjs(){
		echo $this->ret ;
	}
}


//$tree=new UmgTreeCreator(".","");
//$tree->mktree();






class TreeLeaf {

	public $LeafPaths;
	public function TreeLeaf($rootdirectory){
		$cwd = getcwd();
		$this->walk($rootdirectory, "");
	}
	//recursive function
	public function walk($dir, $basename){
		$dirs = $this->getChildDirs($dir);

		foreach ( $dirs as $i => $entry ) {
			$dir2 = "$dir/$entry";
			if ( is_dir($dir2) ){
				//echo "$i -dir2: $dir2 <br>";
				switch( $entry[0] ){
					case '~' :		//defined leaf node. stop recursive here.
						$this->li_leaf($dir2,'');
						break;
				}
				$this->walk($dir2,$entry);
			}
		}

		return;
	}
	private function getChildDirs($dir){
		$files = scandir( $dir);
		if("."===$files[0]) unset($files[0]);
		if(".."===$files[1]) unset($files[1]);
		$dirs=Array();
		foreach ( $files as $i => $entry ) {
			if ( $entry === "."  || $entry === "..") {
				unset($files[$i]);
				continue;
			}

			$dir2 = "$dir/$entry";
			if ( is_file($dir2)===true){
				continue;
			}
			if ( is_dir($dir2) ){
				//echo "---$dir2 <br>\n";
				$dirs[]=$entry;
			}
		}
		return $dirs;
	}
	public function li_leaf($dir, $file) {
		$this->LeafPaths[]=$dir;
	}
}

class TreeLeafTable{
	public function TreeLeafTable($LeafPaths){
		if(count($LeafPaths)===0) {
			echo "Empty";
			return;
		}
		$trs="";
		foreach($LeafPaths as $idx => $path){
			$url=TreeLeafTable::getURL($path);
			$uiname=TreeLeafTable::getUiNodePathName($path);
			$imgfile=UmgTreeNodeImg::getInstance()->getTreeNodeImg($path);
			$img="<img src='$imgfile'></img>";
			$visit= Ui_Visit::get_count($path);

			if( TreeLeafTable::IsLinkable($path) ){
				$lnk="<a href='$url'>$uiname</a>";
			}
			else{
				$lnk="<a>$uiname</a>";
			}
			//$lnk="<a href='$url'>$uiname</a>";

			$num=1+$idx;
			$trs .= "<tr><td>$num</td><td>$img $lnk</td><td>$visit</td></tr>\n";
		}
		$trh="<tr><th>No.</th><th>Sites</th><th>visit</th><tr>\n";
		$tbl="<table border='1'><caption title='tid:$tid'>Dashboard</atption>$trh$trs</table>";
		echo $tbl;
	}
	public static function getURL($realPath){
		$search=$_SERVER["DOCUMENT_ROOT"];
		$url = str_replace($search, "", $realPath);
		return $url;
	}
	public static function getUiNodePathName($realPath){
		$search=getcwd();//$_SERVER["DOCUMENT_ROOT"];
		$url = str_replace($search, "", $realPath);
		$url = str_replace("/umg/main/", "", $url);
		$url = str_replace("~", "", $url);
		$url = str_replace("_", " ", $url);
		return $url;
	}

	public static function IsLinkable($path){
		if("SpViewer"===basename(getcwd())){
			//$tid=Wsss::tid();
			//$tid=trim($tid);
			if( isset($tid) && strlen($tid)>0 && $tid!= "undefined"){
				//echo "[$tid]".strlen($tid) . "<br>";
				return true;
			}
			//echo "not ".tid . "<br>";
			return false;
		}
		else{
			$pos1=strpos($path,"SpViewer");
			if($pos1===false){
				return true;
			}

			$pos2=strpos(getcwd(),"SpViewer");
			//echo getcwd() ."<br>" . $path . "<br>";

			$tid=Wsss::tid();
			if( isset($tid) && strlen($tid)>0 && $tid!="undefined"){
				return true;
			}
			return false;
		}


	}

}






?>





