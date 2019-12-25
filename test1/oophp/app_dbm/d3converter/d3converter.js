<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta content="en-us" http-equiv="Content-Language" />
		<title></title>
		<script src="https://wdingbox.github.io/ham12/jq/jquery-2_1_3.min.js"></script>
        
        <script src="./flareForceDirectedlabel_sample.json"></script>
       
        <style>
        
        .text_container{
            height:600px;
            width:100%;
            background-color:#eeeeee;
            border-style: solid;
            border-width: 2px;
            overflow:scroll;
        }
        
        .tdclked{
           background-color:#cccccc;
        }
        table:nth-child(1){
            background-color:#ffeedd;
        }
        table:nth-child(2){
            background-color:#eeeeff;
        }
        
        .clickedcircle2td{
            background-color:#00cccc;
        }
        </style>
        
        
        
        <script>
  var ipDatArr=[
  {addr:"1.1.1",img:'1.1.1'},
  {addr:"1.1.2",img:'1.1.2'},
  {addr:"1.1.3",img:'1.1.3'},
  ];
  var ipDatArr=[
  {addr:"1.1.1",img:'1.1.1'},
  {addr:"1.1.2",img:'1.1.2'},
  {addr:"1.1.3",img:'1.1.3'},
  {addr:"1.2.1",img:'1.2.1'},
  {addr:"1.2.2",img:'1.2.2'},
  {addr:"2.1.1",img:'2.1.1'},
  {addr:"2.1.2",img:'2.1.2'},
  {addr:"2.2.1",img:'2.2.1'},
  {addr:"2.2.2",img:'2.2.2'},
  ];
  $(document).ready(function(){
      var sss="";
      $("#run").click(function(){ 
          $.each(ipDatArr,function(i,obj){
              sss+=obj.id+"<br>";
          });
          
          var d3json={name:'root',children:[]};    
          
          $.each(ipDatArr,function(i,obj){
              sss+=obj.id+"<br>";
          });
          
          var d3s=new D3Dat(d3sam);
          d3s.walk(d3sam);
          sss+="<hr/>"+d3s.sss;
          
          $("#out").html(ipDatArr.length+"<br/>"+sss);
          
      });
      
      $("#run1").click(function(){ 
          var srcObj={name:0,children:[]};
          var appObj={name:1,children:[{name:1,children:[]}]};
          
          var d3s=new D3Dat(null);
          D3Uti.merge(srcObj,appObj);
          d3s.walk(srcObj);
          var sss="<hr/>"+d3s.sss;
          
          $("#out").html(sss+"<hr>"+JSON.stringify(srcObj));
          
      });
      
      $("#run2").click(function(){ 
          var addr=ipDatArr[2];
          var d3=D3Uti.d3objOf(addr);
          $("#out").html("<hr>"+JSON.stringify(d3));
      });
      
      $("#run3").click(function(){ 
        var mySrcObj={name:1,children:[]};

        for(var i=0;i<ipDatArr.length;i++){
          var addr=ipDatArr[i];

          var appObj=D3Uti.d3objOf(addr);
          D3Uti.merge(mySrcObj,appObj);
        }
        $("#out").html("<hr>"+JSON.stringify(mySrcObj));
      });
 
  });//doc
  
  
var D3Dat=function(d3json){
    this.d3json=d3json;
    this.sss="";
};
D3Dat.prototype.walk=function(obj){
    this.sss+=obj.name+"<br>";
    if(undefined===obj.children) return;
    for(var i=0;i<obj.children.length;i++){
        var childObj=obj.children[i];
        D3Uti.walk(childObj);
    }    
};

var D3Uti={

d3objOf:function(addrData){
    var addr=addrData.addr;
    var arry=addr.split(".");
    var d3obj={};
    d3obj.name=arry[0];
    d3obj.children=[];
    var children=d3obj.children;
    var obj={};
    for(var i=1;i<arry.length;i++){
        obj={name:arry[i],children:[]};
        children.push(obj);        
        children=obj.children;
    }   
    $.each(addrData,function(key,val){
        if(key != "name" && key != "children"){
            d3obj[key]=val;
        }
    });
    return d3obj;    
},
merge:function(srcObj, appObj){
    if( srcObj.name == appObj.name ){
        if(undefined==srcObj.children || srcObj.children.length == 0) {
            if(undefined != appObj.children && appObj.children.length>0) {
                srcObj.children=[];
                $.each(appObj.children,function(i,aobj){
                    srcObj.children.push(aobj);
                });
            }
            return 0;            //stop
        }        
        else if(undefined != appObj.children && appObj.children.length>0 ) {
            for(var i=0;i<appObj.children.length;i++){
                var find=0;
                for(var j=0;j<srcObj.children.length;j++){
                    if(srcObj.children[j].name == appObj.children[i].name ) {
                        D3Uti.merge(srcObj.children[j], appObj.children[i]);
                        find=1;
                        break;
                    }
                };
                if(0==find){
                    if(undefined==srcObj.children) srcObj.children=[];
                    srcObj.children.push(appObj.children[i]);
                }
            };
            return 0;
        }  
        return 0;
    }
    if(undefined===srcObj.children || srcObj.children.length == 0) {
        srcObj.children=[];
        srcObj.children.push(appObj);
        return;            
    }  
    else{
        srcObj.children.push(appObj);
    } 
},
};


        </script>
	</head>
	<body>
    <button id="run">run</button>
    <button id="run1">run1</button>
    <button id="run2">run2</button>
    <button id="run3">run3</button>
    <hr/>
		<div id="out" style="width:100%;height:800px;"></div>
        
	
	</body>
</html>
