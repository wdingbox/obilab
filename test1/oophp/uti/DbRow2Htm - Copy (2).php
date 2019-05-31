<?php

//convert a row of db into a htm table.

	class DbRow2Htm {
   
public function DbRow2Htm(){
		$this->get_img_src_cur_dir();
	}
public $TmpArr;
public function push2TmpArr($linkstr){
		$arr1 = preg_split("/[,]/i",$linkstr);
		foreach( $arr1 as $val){
			if ( strlen($val) == 0 ) continue;
			$this->TmpArr[] = $val ;
		}
		if (!isset($this->TmpArr)) return;

		$this->TmpArr = array_unique($this->TmpArr);
	}


public $img_path;
public function get_img_src_cur_dir(){
		$dir = realpath(".");
		$arr = preg_split("/\//i",$dir);
		//print_r($arr);
		$path="";
		$arr = array_reverse ($arr);
		foreach($arr as $nod){
			if ($nod == "wroot") break;
			$path.="../"; 
		}
		$this->img_path = $path;
	}
public function img_src_of( $val ){

		if ( strlen($val)==5 && is_numeric($val)) {
			return $this->img_path . "odb/tbi/img/jgif/".$val.".gif";  
		} else {
			return  $this->img_path . "odb/hiero/ccer-h/".$val.".gif";
		}
	}
public function img_src_of_pic( $val ){
		return $this->img_path . "odb/pictures/today/".$val;  
	}
	//public function css(){
	//   echo "a.m{ font-size: 1px;  }";
	//}


	function htm_img_zid( $val ){
		if ($val < 100 )	return "<br><a class='m'>".$val."</a>";
		$ret="&#".$val.";"."<br><a class='m'>".$val."</a>";
		//$ret="&#".$val.";"."<a class='m'>".$val."</a>";
		return $ret;
	}   
	function htm_jname( $val ){
		$ret="<a class='m'>";
		$ret.=$val;//."=------------sdf----sfd----sdf--------------------------f--------end ";
		$ret.="</a>";

		//$ret .= "&#58333;<a>58333</a>&#62880;<a style='font-size:14.0pt;font-family:ICS3;mso-bidi-font-family:ICS3'>&#57344;&#57344;</a>";

		//for($i=0; $i<1;$i++) $ret.="<img class='h'/><a>@</a>";
		return $ret;
	}
	function htm_textarea($key, $val ){
		$ret="<textarea class='m' rows='20' cols='9' wrap='virtual'>";
		//$ret.="style='FONT-SIZE: 8pt; LINE-HEIGHT: 10px; FONT-FAMILY: simsun,mssong,mingliu,arial;' >";
		$ret.=$val;//."=------------sdf----sfd----sdf--------------------------f--------end ";
		$ret.="</textarea>";

		//$ret .= "&#58333;<a>58333</a>&#62880;<a style='font-size:14.0pt;font-family:ICS3;mso-bidi-font-family:ICS3'>&#57344;&#57344;</a>";

		//for($i=0; $i<1;$i++) $ret.="<img class='h'/><a>@</a>";
		return $ret;
	}

	function htm_imga( $val ){
		$ret="";
		$arr = preg_split("/[,]/i",$val);
		foreach($arr as $bname){
			if ('0'==$bname || strlen($bname)==0) continue;
			$fname = $this->img_src_of($bname);	//"../../odb/hiero/ccer-h/$bname.gif";
			$ret .= "<a class='m'>$bname</a><br><img class='m' src='$fname'/>";
		}
		//for($i=0; $i<1;$i++) $ret.="<img class='seed'/><a>.</a>";
		return $ret;
	}
	function htm_divaimg( $val, $pars ){
		$ret="";
		$arr = preg_split("/[,]/i",$val);
		foreach($arr as $bname){
			if ('0'==$bname || strlen($bname)==0) continue;
			$fname = $this->img_src_of($bname);	//"../../odb/hiero/ccer-h/$bname.gif";
			$ret .= "<div><a class='m' pars='$pars'>$bname</a><br><img class='m' src='$fname'/></div>";
		}
		//for($i=0; $i<1;$i++) $ret.="<img class='seed'/><a>.</a>";
		return $ret;
	}
	function htm_div_a( $val, $pars ){
		$ret="";
		if (''==$val || strlen($val)==0) $val="-";
		$ret .= "<div><a class='ed' pars='$pars'>$val</a><br></div>";
		return $ret;
	}
	function htm_divaimg_pic( $val ){
		$ret="";
		$arr = preg_split("/[,]/i",$val);
		foreach($arr as $bname){
			if ('0'==$bname || strlen($bname)==0) continue;
			$fname = $this->img_src_of_pic($bname);	//"../../odb/hiero/ccer-h/$bname.gif";
			$ret .= "<div><a class='m'>$bname</a><br><img class='m2' width='100px' height='100px' src='$fname'/></div>";
		}
		//for($i=0; $i<1;$i++) $ret.="<img class='seed'/><a>.</a>";
		return $ret;
	}
	function htm_divaimg_src( $val ){
		$ret="";
		$arr = preg_split("/[,]/i",$val);
		foreach($arr as $bname){
			if ('0'==$bname || strlen($bname)==0) continue;
			$fname = $this->img_src_of_pic($bname);	//"../../odb/hiero/ccer-h/$bname.gif";
			$ret .= "<div><a class='m'>$bname</a><br><img class='m2' width='100px' height='100px' src='$bname'/></div>";
		}
		//for($i=0; $i<1;$i++) $ret.="<img class='seed'/><a>.</a>";
		return $ret;
	}

public function htm_tr_dat_edit($row) {
		echo "<tr>";
		foreach($row as $key => $val ) {
			if (is_numeric($key) ) continue;
			echo "<td><div>";
			switch ($key) {
			case 'jid':
			case 'hid':
			case 'jink':
			case 'jtoh':
			case 'htoj':
			case 'hink':
				echo $this->htm_imga($val);
				break;


			case 'zid':
				echo $this->htm_img_zid($val);
				break;
			case 'jmn':
				echo $this->htm_jname($val);
				break;
				//echo $this->htm_img_hink($val);
				//break;
			case 'zid1':
			case 'pyn':
			case 'eng':
			case 'descr':
			case 'L':
			case 'xa'://similar
			case 'xb'://similar
			case 'xc'://similar
				echo $this->htm_textarea($key, $val);//mk it editable.
				break;
			default:
				echo "<a><font size='1'>$val</font></a>";
			}
			echo "</div></td>";
		}//for each
		echo "</tr>\r\n";
	}
public function get_Append_Params($sql, $row, $key) {
		$pos = stripos($sql, "FROM");//Find the position of the first occurrence of a case-insensitive substring in a string
		if ( false === $pos ) return "";
		if ( stripos($sql, "Jiaguwen", $pos+4) > 0 ) {
			//if ( "jink"==$key) {
				return "Jiaguwen,jid,".$row['jid'].",$key";//dbname, primarykey, primaryval, appendkey
			//}
			if ( "jtoh"==$key) {
				//return "Jiaguwen SET $key = ppp WHERE jid = ".$row['jid']."";
				return "Jiaguwen,jid,".$row['jid'].",$key";//dbname, primarykey, primaryval, appendkey
			}
		};
		if ( stripos($sql, "PictureToday", $pos+4) > 0 ) {
			if ( "jink"==$key) {
				return "PictureToday,picname,".$row['picname'].",$key";//dbname, primarykey, primaryval, appendkey
				return "UPDATE PictureToday SET $key = ppp WHERE picname = ".$row['picname']."";
			}
		};

		return "";
	}
public function htm_tr_dat_rd($sql, $row) {
		echo "<tr>";
		$pars="";
		foreach($row as $key => $val ) {
			if (is_numeric($key) ) continue;
			switch ($key) {
			case 'jid':
			case 'hid':
			case 'jink':
			case 'jtoh':
			case 'htoj':
			case 'hink':
				$pars=$this->get_Append_Params($sql,$row,$key);
				echo "<td pars='".$pars."'><div>";
				echo $this->htm_divaimg($val, $pars);
				break;
			case 'picname':
				echo "<td pars=''><div>";
				echo $this->htm_divaimg_pic($val);
				break;
			case 'src':
				$str="";
				echo "<td pars='".$str."'><div>";
				echo $this->htm_divaimg_src($val);
				break;

			case 'zid':
			case 'zid1':
				echo "<td pars=''><div>";
				echo $this->htm_img_zid($val);
				break;
			case 'jmn':
				echo "<td pars=''><div>";
				echo $this->htm_jname($val);
				break;
				//echo $this->htm_img_hink($val);
				//break;
			case 'picname':
				echo "<td><div>";

				echo $this->htm_divaimg_pic($val);
				break;
			case 'pyn':
			case 'eng':
			case 'descr':
			case 'L':
         case 'xa':
         case 'xb':
         case 'xc':
				echo "<td pars=''><div>";
            $pars = $this->get_Append_Params($sql,$row,$key);
				echo $this->htm_div_a($val, $pars);//allow update.
				break;
			default:
				echo "<td pars=''><div>";
				echo "<a><font size='1'>$val</font></a>";
			}//switch
			echo "</div></td>";
		}
		echo "</tr>\r\n";
	}
public function htm_tr_title($row) {
		$dbstr = "<tr>";
		foreach ($row as $key => $val ){
			if ( is_numeric( $key ) )continue;
			$dbstr .= "<td>" . $key . "</td>";
		}
		$dbstr .= "</tr>";
		echo $dbstr;
	}




	//for tmp.php
public function htm_table($row) {
		echo "<table>";
		$this->htm_tr_title($row);
		$this->htm_tr_dat_edit($row);
		echo "</table>";
	}

};//class


?>