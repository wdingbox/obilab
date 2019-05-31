

var TimeOrderSites=[
{Hebei:'537,327'},{Jiangsu:'584,365'},{Gansu:'414,361'},{Henan:'526,364'},{Zhejiang:'657,420'},{Shaanxi:'491,358'},{Zhejiang:'618,433'},{Shandong:'573,325'},{Sichuan:'425,447'},{InnerMongolia:'599,229'},{Zhejiang:'624,427'},{Henan:'504,359'},{Gansu:'388,347'},{Shandong:'578,325'},{Hubei:'516,422'},{Gansu:'385,346'},{Henan:'512,359'},{InnerMongolia:'570,230'},{Henan:'535,336'},{Shaanxi:'440,366'},{Shaanxi:'458,366'},
];//generated from table.



//constant
var YelloRiverPoints="321,363 327,363 334,361 340,360 343,366 348,373 355,378 360,377 366,384 369,382 376,383 379,381 379,380 378,377 371,369 368,362 366,357 368,351 370,346 371,342 374,340 375,339 382,340 392,345 399,347 404,347 406,343 410,341 412,340 415,341 420,340 424,338 425,334 427,332 428,327 432,325 435,322 441,320 442,315 445,313 448,304 448,291 451,284 452,278 452,275 453,271 461,265 468,262 469,259 482,263 487,264 492,266 494,264 497,262 503,268 504,276 504,286 504,291 502,296 502,309 501,316 501,331 501,341 502,348 497,358 500,364 500,367 512,367 516,363 523,360 530,360 540,357 550,363 555,360 557,353 562,346 569,338 575,330 576,328 579,323 583,320 585,317 592,315 598,309 603,306 610,300";
//constant
var ChangJiang="260,351 265,357 277,360 291,361 298,360 302,360 310,367 314,377 320,381 326,386 331,396 341,406 343,414 345,434 346,460 350,477 354,485 355,488 359,490 358,483 360,482 362,482 363,487 362,494 361,498 365,503 369,508 370,504 370,502 373,500 379,499 381,498 383,506 386,508 388,511 390,512 393,514 400,511 402,504 404,492 404,489 407,484 408,479 410,475 416,472 423,473 427,471 434,471 436,467 443,467 443,463 446,461 452,456 457,453 460,453 464,453 468,449 474,441 481,433 489,432 501,430 508,431 514,434 521,440 527,435 529,443 532,451 535,447 542,451 547,444 548,440 551,434 558,429 564,428 564,434 574,435 578,440 585,439 589,431 591,425 592,420 602,415 606,412 612,407 612,402 611,393 619,391 627,395 633,395 640,397 642,392 644,391 646,390 656,391";

function getAjustedRiverData(points){
	var rrr=points.split( " " );
	var sd="M ";
	for(var i=0;i<rrr.length; i+=1){
		var arr=rrr[i].split(/,/);
		var x=parseInt(arr[0]);
		var y=parseInt(arr[1]);
		x-=18;
		y-=0;
		sd += x+" "+y+" ";	
	}
	console.log(sd);
	return sd;
}

var rrr=YelloRiverPoints.replace(",", " ");


$(document).ready(function(){
	svg_path({d:getAjustedRiverData(YelloRiverPoints),linewidth:1, linecolor:"blue", fillcolor:''});
	svg_path({d:getAjustedRiverData(ChangJiang),linewidth:1, linecolor:"blue", fillcolor:''});
	

	
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
		main_2(TimeOrderSites);
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
                           .attr("stroke", "blue")
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



