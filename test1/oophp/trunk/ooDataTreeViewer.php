<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>jgw db viewer</title>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
<script type="text/javascript" src="../../_js/jquery.js"></script>

<script type="text/javascript" src="../_js/uti.js"></script>
<script type="text/javascript" src="db_view_ajx.js"></script>


<link rel="stylesheet" href="../../_js/jqtreeview/jquery.treeview.css" />
<link rel="stylesheet" href="../../_js/jqtreeview/red-treeview.css" />
<link rel="stylesheet" href="../_js/jqtreeview/ootree.css" />
<script src="../../_js/jqtreeview/jquery.treeview.js"
	type="text/javascript"></script>
<script src="../../_js/jqtreeview/lib/jquery.cookie.js" type="text/javascript"></script>


<!-- Users -->
<LINK href="db_view_item.css" rel="stylesheet" type="text/css">
</head>

<style type="text/css">
div.sql_editor {
	position: absolute;
	zIndex: 5000;
	left: 0;
	top: 0;
}
</style>


<script type="text/javascript">
		$(function() {
			$("#browser").treeview({
				control: "#treecontrol2",
				animated: "fast",
				collapsed: true,
				unique: false,
				toggle: function() {
					//window.console && console.log("%o was toggled", this);
				}
			}); 
		});
      $(document).ready(function(){

          
          $("#collapse_all").click(function(){
              $("#browser").find("li").each(function(){
                  $(this).attr("class","collapse");
              });
              $("#browser").find("li").each(function(){
                  //$(this).attr("class","closed");
              });
          });
          
				  $(".ooimg").click(function(idx){
								   prompt("jid", "jid='"+$(this).attr("title")+"'");
								  });
});//$(document).ready(function(){  
</script>

</head>
<body>


	<div id="treecontrol2">
	    <div>OOA TreeView : </div> 
		<a title="Collapse the entire tree below" href="#">Collapse All</a> | 
		<a title="Expand the entire tree below" href="#">Expand All</a> | 
		<a title="Toggle the tree below, opening closed branches, closing open branches" href="#">Toggle All</a>
	</div>	
	<br/>
		
		<ul id="browser" class="">
			<?php
			//require_once("ooData.htm");
			require_once("ooData.php");///

			?>
		</ul>


</body>
</html>
