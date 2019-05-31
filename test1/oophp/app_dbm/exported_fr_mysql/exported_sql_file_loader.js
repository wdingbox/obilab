<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <TITLE>ootbi</TITLE>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8"></META>
	<META name="viewport" content="width=device-witdh, initial-scale=1, maximum-scale=1, user-scale=0"></META>
    <link rel="stylesheet" type="text/css" href="../css/OpMenu.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
    <script src="../js/jquery.contextmenu.js"></script>
    <link rel="stylesheet" href="../css/jquery.contextmenu.css">
    
<script src="../../../../oophp/app_dbm/D3Uti.js"></script>
<script src="../js/OpMenu.js"></script>
<script src="../dat/links_p2p_logo.json"></script>
<script src="../dat/links_p2p_picto.json"></script>
<script>
$(document).ready(function(){

});
</script>
<style>
body{
overflow:scroll;
}
#dout{
overflow:auto;
width:100%;
height:100%;
   border: 1px solid #cccccc;
}

.link {
  fill: none;
  stroke: #666;
  stroke-width: 0.5px;
}

#licensing {
  fill: #9ecae1;
}

.link.licensing {
  stroke: #9ecae1;
  stroke-width: 1.5px;
}

.link.resolved {
  stroke-dasharray: 0,2 1;
}

circle {
  fill: #ffffff;
  stroke: #333;
  stroke-width: 0.5px;
}

text {
  font: 10px sans-serif;
  pointer-events: none;
  text-shadow: 0 1px 0 #fff, 1px 0 0 #fff, 0 -1px 0 #fff, -1px 0 0 #fff;
}

</style>
</head>
<body>
<div id="OpMenu">

<select id="selop">
<option></option>
<option value="UpdateGraphic">UpdateGraphic</option>
<option value="changeParentNode">Save</option>
<option></option>
<option value="ViewD3Links">ViewD3Links</option>
<option value="ViewD3Nodes">ViewD3Nodes</option>
<option value="ViewP2pArr">ViewP2pArr</option>
<option></option>
<option value="ViewTreeNodeList">ViewTreeNodeList</option>
<option value="ViewTreeJson">ViewTreeJson</option>
</select><br/>
<div id='dout'>+</div>

</div>

<script src="//d3js.org/d3.v3.min.js"></script>
<script>
</script>

</body>
</html>