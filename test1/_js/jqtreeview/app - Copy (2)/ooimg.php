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
	
   
	<h1 id="">jQuery Treeview OOA TBI</h1>
	<div id="main">

	<a>TBI OOA TreeView</a>
	<ul id="browser" class="filetree">


      <?php





require_once("../../../oophp/tpl/atpl.php");
$last_line = system('../../../oopy/mdb/Jiaguwen_OoaTreeviewDataGenerator.py', $retval);
echo '
</pre>
<hr />Last line of the output: ' . $last_line . '
<hr />Return value: ' . $retval;


#atpl::printent("treeview.htm");




?>




	</ul>
</div>
 
</body></html>