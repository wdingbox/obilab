

var TimeOrderSites=[
{Hebei:'537,327'},{Jiangsu:'584,365'},{Gansu:'414,361'},{Henan:'526,364'},{Zhejiang:'657,420'},{Shaanxi:'491,358'},{Zhejiang:'618,433'},{Shandong:'573,325'},{Sichuan:'425,447'},{InnerMongolia:'599,229'},{Zhejiang:'624,427'},{Henan:'504,359'},{Gansu:'388,347'},{Shandong:'578,325'},{Hubei:'516,422'},{Gansu:'385,346'},{Henan:'512,359'},{InnerMongolia:'570,230'},{Henan:'535,336'},{Shaanxi:'440,366'},{Shaanxi:'458,366'},
];//generated from table.




var archinfo00=new ChinaArchDataUti(ChinaArchData00);

$(document).ready(function(){
	
	$("#flipMapPlus").click(function(){		
		FilpMap(1);
	});
	$("#flipMapMinus").click(function(){		
		FilpMap(-1);
	});
	
	
    $(".overlayDiv").click(function(e){
		var ss = $("#points").text();
		ss+=e.pageX+","+e.pageY+" ";
		$("#points").text(ss);
		return true;
	}).mousemove(function (e){
		$("#aaa").text(e.pageX+","+e.pageY);
	});
	
	
	
	$("#NextSite").click(function(){
		NextSite();
		});
	$("#bt1").click(function(){
		//main_2(TimeOrderSites);
        NextSiteTimeDist();
		});
	$("#bt2").click(function(){
		run2();
		});	
	$("#AllSites").click(function(){
		run2();
		});	
	$("#MapToggler").click(function(){
		$(".overlayDiv").slideToggle();
	});
});//ready
var NextSiteTimeDistArrIdx=0;
var OffsetY_Idx=-1;
function NextSiteTimeDist(){
    var obj=archinfo00.ChronicleInfoArr[NextSiteTimeDistArrIdx];
    var latlng = obj.LatLng;
    var tdArr=archinfo00.GenTimeDistanceArrForLatLng(latlng);
    
    var d3paths="M";
    OffsetY_Idx++;
    if(OffsetY_Idx>=20){
        OffsetY_Idx=0;
        //d3.select("#mysvg").selectAll("*").remove();
        $("#mysvg").empty();
    }    
    var offsetY=OffsetY_Idx*40;
    var nXcof=4;
    for(var i=0;i<tdArr.length;i++){
        var x = nXcof*i;
        var y=offsetY+parseFloat(tdArr[i].distance)*2;
        d3paths+=" " +x+ " " + parseInt(y);
    }
    console.log(d3paths);
    var horz="M 0 "+offsetY+" 800 " + offsetY;
    
    var vX=(NextSiteTimeDistArrIdx*nXcof);
    var vY=offsetY + 50;
    var vert="M "+vX+" "+offsetY+" "+vX + " "+ vY;
    
    svg_path({d:horz,linewidth:1, linecolor:"black", fillcolor:''});    
    svg_path({d:vert,linewidth:1, linecolor:"red", fillcolor:''});    
    svg_path({d:d3paths,linewidth:1, linecolor:"blue", fillcolor:''});
    $("#points").text(NextSiteTimeDistArrIdx);
    
    
    NextSiteTimeDistArrIdx++;

}

var imgFilpMapArrIdx=0;
function FilpMap(iNext){
	var imgArr=[
	"china-map_blank.gif",
	"provmap.png",
	"google_34.5839078N-97.769129E-5.18z.png",
	"china_terrain_map.png",
	"china-southern0712rm-domestic-combined_23174.jpg",
	"china-rivers.jpg",
	"china_Population_Map.png",
	"China-internet-penetration-rate-map-by-province.jpg",
	"china-map.gif",
	"china-map_blank.gif",
	"china_provinces_blank_map.png",
	];	
	var fname="./Interactive Map of Chinese Provinces_files/"+imgArr[imgFilpMapArrIdx];		
	$("#myimg").attr("src",fname);
	imgFilpMapArrIdx+=iNext;
	if(imgFilpMapArrIdx<0){imgFilpMapArrIdx=imgArr.length-1;};	
	if(imgFilpMapArrIdx>=imgArr.length){imgFilpMapArrIdx=0;};
}

var iNextSite=0;
function NextSite(){

	if(iNextSite>=TimeOrderSites.length){
		return alert("end");
	}
	d3.select("#mysvg").attr("width",10000).attr("height",659);
	var objs=GetTargetAreasData();
	
	var i=0;

	ShowSite(iNextSite, TimeOrderSites[iNextSite]);
	iNextSite+=1;
	//ScrollToView_TD_ChinaPrehistoryMap(iNextSite);

}
function ShowSite(i, obj){
		var name= Object.keys(obj)[0];
		
		var txtspace=20;
		var vert=(1+i)*txtspace;//30+30;
		var point=obj[name];
		if(!point) return;
		var points="15,"+vert+" "+point;
		points=vert+","+590+" "+point;
		
		console.log(name+":====centerPoit:"+points);
		var linecolr=['#ffff55', 'green', 'black'];
		var isel=i%3;
		svg_polygon({points:points,linewidth:1,linecolor:linecolr[isel], fillcolor:'none'});		
		
		svg_text(20,vert-10,'black', ""+(i+1)+name);
		svg_circle(point,3, "red");
}


function run1(){
	main_2(TimeOrderSites);
}
function run2(){
	var arr=[
{Hebei:'537,327'},{Jiangsu:'598,365'},{Gansu:'380,361'},{Henan:'524,364'},{Zhejiang:'657,420'},{Shaanxi:'478,358'},{Zhejiang:'641,433'},{Shandong:'584,325'},{Sichuan:'394,447'},{InnerMongolia:'617,229'},{Zhejiang:'650,427'},{Henan:'496,359'},{Gansu:'348,347'},{Shandong:'590,325'},{Hubei:'511,422'},{Gansu:'343,346'},{Henan:'506,359'},{InnerMongolia:'570,230'},{Henan:'535,336'},{Shanxi:'414,366'},{Shanxi:'437,366'},

];
	main_2(arr);
}

function main_2(arr){
	d3.select("#mysvg").attr("width",10000).attr("height",659);
	var objs=GetTargetAreasData();
	
	for(var i=0;i<arr.length;i++){
		var name= Object.keys(arr[i])[0];
		var obj=objs[name];
		svg_area(obj);	
	}
	var i=0;
	for(var i=0;i<arr.length;i++){
		var name= Object.keys(arr[i])[0];
		var vert=i*30+30;
		var point=arr[i][name];
		if(!point) continue;
		var points="15,"+vert+" "+point;
		points=vert+","+590+" "+point;
		
		console.log(name+":====centerPoit:"+points);
		var linecolr=['blue', 'green', 'black'];
		var isel=i%3;
		svg_polygon({points:points,linewidth:1,linecolor:linecolr[isel], fillcolor:'#ffffff'});		
		
		svg_text(20,vert-10,'black', ""+(i+1)+name);
		svg_circle(point,3, "red");
	}
}
function main_1(){
	d3.select("#mysvg").attr("width",10000).attr("height",600);
	var objs=GetTargetAreasData();
	var ChronicalList="Hebei,Jiangsu,Gansu,Henan,Zhejiang,Shaanxi,Zhejiang,Shandong,Sichuan,InnerMongolia,Zhejiang,Henan,Gansu,Shandong,Hubei,Gansu,Henan,Henan,Shanxi,Shanxi,InnerMongolia";
	var arr=ChronicalList.split(/,/);
	for(var i=0;i<arr.length;i++){
		var name=arr[i];
		var obj=objs[name];
		svg_area(obj);	
	}
	for(var i=0;i<arr.length;i++){
		var name=arr[i];
		var obj=objs[name];
		var vert=i*30;
		var points="0,"+vert+" "+obj.center_xy.toString();
		console.log(name+":::centerPoit:"+points);
		svg_polygon({points:points,linewidth:1,linecolor:'blue', fillcolor:'#000000'});		
	}
}
function test_map(){
	$("#FPMap0 area").each(function(idx){
		$(this).bind("click",area_click);
		
		var coords= $(this).attr("coords");
		var onmouseover=$(this).attr("onmouseover");
		console.log(onmouseover);
		
		var arr=coords.split(/,/g);
		if(arr[0] >0 ){
			var clr=getMoseOvered(onmouseover);
			if(!!clr>0){
				svg_draw_arr(arr, clr.color, idx);
			}
		}
	});
}
function test(){
		var circle = d3.select("#mysvg").append("circle")
		.attr("r", "10")
		.attr("cx", "754")
		.attr("cy", "659")
		.attr("style", "fill:white;stroke:black;stroke-width:5");
		
		
	    var polygon = d3.select("#mysvg").append("polygon")
		.attr("points", "0,10 250,190 160,210")
		.attr("style", "fill:white;stroke:black;stroke-width:5")
		;
}
function GetTargetAreasData(){
	var ret={};
	$("#FPMap0 area").each(function(idx){
		$(this).bind("click",area_click);
		
		var coords= $(this).attr("coords");
		var onmouseover=$(this).attr("onmouseover");
		console.log(onmouseover);
		
		var arr=coords.split(/,/g);

		var obj=getMoseOvered(onmouseover);
		if(!!obj){
			//svg_draw_arr(arr, clr, idx);
			obj.coords=coords;
			obj.center_xy=getAreaCenterPoint(coords);
			
			ret[obj.name]=obj;
		}
	});

	return ret;
}
function getAreaCenterPoint(coords){
	var arr=coords.split(/,/g);
	var x=0,y=0;
	for(var i=0;i<arr.length-1;i+=2){
		x+=parseInt(arr[i]);
		y+=parseInt(arr[i+1]);
	}
	x /= arr.length/2;
	y /= arr.length/2;
	return [x,y];
}


function area_click(){
		var coords= $(this).attr("coords");
		var arr=coords.split(/,/g);
		//console.log("area coords="+coords);
		svg_draw_arr(arr,"", 0);
}
function coords2points(coords){
		var arr=coords.split(/,/);
		var points="";
		for(var i=0;i<arr.length-1;i+=2){
			var x=Math.floor(arr[i]);
			var y=Math.floor(arr[i+1]);
			points+=x+","+y+" ";
		}
		return points;
}
function svg_area(obj){
	var coords=obj.coords;
	var clor=obj.color;
	var points=coords2points(coords);
	svg_polygon({points:points,linewidth:1, linecolor:clor, fillcolor:clor});
}
function svg_polygon( jsparm ){
		var points=jsparm.points;
		var linewidth=jsparm.linewidth;
		var linecolor=jsparm.linecolor, fillcolor=jsparm.fillcolor;
		//console.log("svg coords="+coords);
		d3.select("#mysvg");
		var polygon = d3.select("#mysvg").append("polygon")
		.attr("points", points)
		.attr("style", "xfill:"+fillcolor+";stroke:"+linecolor+";stroke-width:"+linewidth)
		.attr("fill-opacity",0)
		.on("click",function(e){
			console.log("click:"+points);
			var cct=$(this).attr("clicount");
			if("NaN"===cct||undefined===cct){
				$(this).attr("clicount",'0');
				cct=0;
			}
			cct=parseInt(cct);
			var pt=getPoint(points,cct);
			svg_circle(pt,1,'blue');
			$(this).attr("clicount",1+cct);
			console.log("cct="+cct+',ppt='+pt);
			
		});
}
function svg_path( jsparm ){
		var lineData=jsparm.d;
		var linewidth=jsparm.linewidth;
		var linecolor=jsparm.linecolor, fillcolor=jsparm.fillcolor;
		//console.log("svg coords="+coords);
		d3.select("#mysvg");
		var polygon = d3.select("#mysvg").append("path")
                           .attr("d", lineData) //lineFunction(lineData))
                           .attr("stroke", linecolor)
                           .attr("stroke-width", linewidth)
                           .attr("fill", "none");
}
function getPoint(points,idx){
	var arr=points.split(/\s/);
	if(idx>=arr.length) idx=0;
	idx=idx%arr.length;
	
	return arr[idx];
}
function svg_circle(point,radius, color){
		var arr=point.split(/,/);
		var cx=arr[0], cy=arr[1];
		var circle = d3.select("#mysvg").append("circle")
		.attr("r", radius)
		.attr("cx", cx)
		.attr("cy", cy)
		.attr("style", "fill:"+color+";stroke:black;stroke-width:1");
}
function svg_text( x,y, color, txt ){
		//var points=jsparm.points;
		//var linewidth=jsparm.linewidth;
		//var linecolor=jsparm.linecolor, fillcolor=jsparm.fillcolor;
		//console.log("svg coords="+coords);

		var polygon = d3.select("#mysvg").append("text")
		.attr("x", x)
		.attr("y", y)
		.attr("dy", ".35em")
		.attr("fill",color)
		.attr("transform","translate(10,659) rotate(-90)" )
		.text(txt);
}

function svg_area___________(coords, clor){
	var points=coords2points(coords);
		//console.log("svg coords="+coords);
		d3.select("#mysvg");
		var polygon = d3.select("#mysvg").append("polygon")
		.attr("points", points)
		.attr("style", "fill:"+clor+";stroke:black;stroke-width:3")
		.attr("fill-opacity",1);
}
function svg_time_line____________(points, clor){
		//console.log("svg coords="+coords);
		d3.select("#mysvg");
		var polygon = d3.select("#mysvg").append("polygon")
		.attr("points", points)
		.attr("style", "fill:"+clor+";stroke:black;stroke-width:3")
		.attr("fill-opacity",1);
}


function svg_draw_arr(arr,clor,idx){
		var betaX=1,betaY=1;
		var coords='';
		for(var i=0;i<arr.length;i+=2){
			var x=Math.floor(betaX*arr[i]);
			var y=Math.floor(betaY*arr[i+1]);
			coords+=x+","+y+" ";
		}
		//console.log("svg coords="+coords);
		d3.select("#mysvg").attr("width",10000).attr("height",600);
		var polygon = d3.select("#mysvg").append("polygon")
		.attr("points", coords)
		.attr("style", "fill:"+clor+";stroke:black;stroke-width:3")
		.attr("fill-opacity",1);
		//.attr("style", "fill:#66ff66;stroke:black;stroke-width:2").classed("selected", false);
		coords="0,"+idx*10 + " "+arr[0]+","+arr[1];
		d3.select("#mysvg");
		var polygon = d3.select("#mysvg").append("polygon")
		.attr("points", coords)
		.attr("style", "fill:"+"red"+";stroke:black;stroke-width:1")
		.attr("fill-opacity",1);
}


function getMoseOvered(str){
	if(!str) return null;
	var targs=["Henan", "Shaanxi", "Shanxi", "Hebei", "Jiangsu","Shandong", "Gansu", "Zhejiang", "Sichuan", "Hunan","Hubei", "Qinhai","InnerMongolia"];
	for(var i=0;i<targs.length;i++) {
		if(str.indexOf(targs[i])>=0) {
			var ipos= str.lastIndexOf("FGCOLOR");
			var clor=str.substr(ipos+10,7);
			console.log("clor="+clor);
			var obj={};
			obj["color"]=clor;
			obj["name"]=targs[i];
			return obj;
		}
	}
	return null;
}



function canvas_draw_arr(arr){
		var c = document.getElementById("myCanvas");
		var ctx = c.getContext("2d");
		ctx.fillStyle = "#FF0000";
		//ctx.fillRect(0,0,150,75);
		ctx.beginPath();
		var betaX=0.5,betaY=0.5;
		ctx.moveTo(betaX*arr[0], betaY*arr[1]);
		for(var i=0;i<arr.length/2;i+=2){
			var x=Math.floor(betaX*arr[i]);
			var y=Math.floor(betaY*arr[i+1]);
			console.log("x,y="+x+","+y);
			ctx.lineTo(x,y);
		}
		ctx.closePath();
		//ctx.fill();
		ctx.stroke();
}



