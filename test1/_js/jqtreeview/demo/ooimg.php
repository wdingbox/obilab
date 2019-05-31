<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>jQuery treeview</title>
	
	<link rel="stylesheet" href="../jquery.treeview.css" />
    <link rel="stylesheet" href="../red-treeview.css" />
	<link rel="stylesheet" href="screen.css" />
	
	<script src="../lib/jquery.js" type="text/javascript"></script>
	<script src="../lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="../jquery.treeview.js" type="text/javascript"></script>
	
	<script type="text/javascript">
		$(function() {
			$("#browser").treeview();
		});
	</script>
	
	</head>
	<body>
	
	<h1 id="">jQuery Treeview Plugin Demo</h1>
	<div id="main">

	<a>Sample 1 - default</a>
	<ul id="browser" class="filetree">
		<li><img src="../images/folder.gif" /> 123999
			<ul>
				<li>blabla <img src="../images/file.gif" />0000</li>
			</ul>
		</li>
		<li><img src="../images/folder.gif" />
			<ul>
				<li><img src="../images/folder.gif" />
					<ul id="folder21">
						<li><img src="../images/file.gif" /> more text</li>
						<li>and here, too<img src="../images/file.gif" /></li>
                  <li><img src="../images/folder.gif" />
			<ul>
				<li><img src="../images/folder.gif" />
					<ul id="folder21">
						<li><img src="../images/file.gif" /> more text</li>
						<li>and here, too<img src="../images/file.gif" /></li>
					</ul>
				</li>
				<li><img src="../images/file.gif" /></li>
			</ul>
		</li>
					</ul>
				</li>
				<li><img src="../images/file.gif" /></li>
			</ul>
		</li>
		<li class="closed">this is closed! <img src="../images/folder.gif" />
			<ul>
				<li><img src="../images/file.gif" /></li>
			</ul>
		</li>
		<li><img src="../images/file.gif" /></li>
<?php
require_once("../tpl/atpl.php");
$last_line = system('../../oopy/mdb/Jiaguwen_OoaTreeviewDataGenerator.py', $retval);
//atpl::printent("../tpl/mmdiv.php");
?>

	</ul>
		
</div>
 
</body></html>