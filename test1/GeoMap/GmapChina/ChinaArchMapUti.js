
var DATE_LEGACY_RELICS_SITE_FEATURES=[
    {iEnd:-7400,clr:"#000000",radius:70000,circFillClr:"#FFFFFF",name:"旧石器时代(距今约260万年或250万年)"},
    {iEnd:-2200,clr:"#0000ff",radius:65000,circFillClr:"#808080",name:"新石器时代(-7400-2200 BC)"},
    {iEnd:-1700,clr:"#9900ff",radius:60000,circFillClr:"#FF0000",name:"夏(-2200 -1700 BC)"},
    {iEnd:-1400,clr:"#990000",radius:50000,circFillClr:"#FFA500",name:"商(-1701 -1045 BC)"},
    {iEnd:-1046,clr:"#90f00f",radius:55000,circFillClr:"#FF00FF",name:"殷商(商朝后期的专有代称，从公元前14世纪到公元前11世纪)"},
    {iEnd:-770, clr:"#00ff00",radius:40000,circFillClr:"#0000FF",name:"周(西周（-1046 -770 BC）東周（-770 -256 BC）)"},
    {iEnd:-476,  clr:"#ff0000",radius:30000,circFillClr:"#00FF00",name:"春秋(-770- 476 BC)"},
    {iEnd:-221,  clr:"#ff0000",radius:25000,circFillClr:"#008000",name:"战国(-476/453/403 -221 BC)"},
    {iEnd:-202,  clr:"#ff0000",radius:20000,circFillClr:"#00FFFF",name:"秦(-221-202 BC)"},
    {iEnd:+25,  clr:"#ff0000",radius:10000,circFillClr:"#800080",name:"西漢 新(-221 BC +25 AD)"},
    {iEnd:+220,  clr:"#ff0000",radius:10000,circFillClr:"#0000A0",name:"東漢(+25 +220 AD)"},
    {iEnd:+280,  clr:"#ff0000",radius:9000,circFillClr:"#808000",name:"三國(+220 +280 AD)"},
    {iEnd:+420,  clr:"#ff0000",radius:8000,circFillClr:"#800000",name:"晉(+280 +420 AD)"},
    {iEnd:+589,  clr:"#ff0000",radius:7000,circFillClr:"#A52A2A",name:"南北朝(+420 +589 AD)"},
    {iEnd:+979,  clr:"#ff0000",radius:6000,circFillClr:"#ADD8E6",name:"隋 唐 五代 (+589 +979 AD)"},
    {iEnd:+1206,  clr:"#ff0000",radius:5000,circFillClr:"#ADD8E6",name:"宋 金 (+979 +1206 AD)"},
    {iEnd:+1912,  clr:"#ff0000",radius:4000,circFillClr:"#ADD8E6",name:"元 明 清(+1206 +1912 AD)"},
];
var DATE_LEGACY_SITE_BRONZE=[
    {date:-1400,clr:"#000000",radius:70000,circFillClr:"#FF0000",name:" "},
    {date:-1200,clr:"#0000ff",radius:60000,circFillClr:"#00FF00",name:""},
    {date:-1000,clr:"#9900ff",radius:50000,circFillClr:"#0000FF",name:""},
    {date:-300, clr:"#990000",radius:40000,circFillClr:"#FF00FF",name:""},
    {date:-200, clr:"#90f00f",radius:35000,circFillClr:"#00FFFF",name:""},
    {date:-25,  clr:"#00ff00",radius:30000,circFillClr:"#FFFF00",name:""},
    {date:200,  clr:"#ff0000",radius:25000,circFillClr:"#dddddd",name:""}
];




var MapLegacy=function(legacy){
    this.legacy=this.init(legacy);
    this.resetStats();
};
MapLegacy.prototype.init=function(DateLegacy){
    for(var i=1;i<DateLegacy.length;i++){
        var objPrev=DateLegacy[i-1];
        var objCurr=DateLegacy[i];
        objCurr.iStart =objPrev.iEnd;
        objCurr.iDlt = objCurr.iEnd - objCurr.iStart;
    }  
    DateLegacy[0].iStart   =-26000000;
    DateLegacy[0].iDlt   = DateLegacy[0].iEnd-DateLegacy[0].iStart;   
    return DateLegacy;    
};
MapLegacy.prototype.resetStats=function(){
    for(var i=0;i<this.legacy.length;i++){
        var objCurr=this.legacy[i];
        objCurr.iTot =0;
        objCurr.fRate=0.0;
    }      
};
MapLegacy.prototype.GetTable=function(){
    var idate="<tr><td>#</td><td>Date</td><td>FillColor</td><td onclick='legacy_clk_calc_tot(this);' title='total sites'>Tot</td><td onclick='legacy_calc_fRate(this);' title='sites/period%'>fRate%</td><td>Dynasty</td><tr>";

    for(var i=0;i<this.legacy.length;i++){
        var obj=this.legacy[i];
        var imax=obj.iEnd;
        var colr=obj.clr;
        var name=obj.name;
        var filclr=obj.circFillClr;
        
        
        var iMin=obj.iStart;//"-~";
        
        var styl=" style=\"color:"+colr+";\" ";
        var tdx="<td id='cr"+i+"'>"+i+"</td>";
        var delta=obj.iDlt;
        var date="<td id='date_"+i+"' onclick='legacy_clk_date(this);' title='click here to add sites on map.' "+styl+">"+iMin+" , "+imax+"</td>";
        var tot="<td id='tot_"+i+"' class='tot' imin='"+iMin+"' imax='"+imax+"'>"+obj.iTot+"</td>";        
        iMin=imax;
        
        var fRate="<td id='dense_"+i+"' class='delta' delta='"+delta+"'>"+obj.fRate+"</td>";
        
        styl=" style=\"background-color:"+filclr+";\" ";
        var circFillClr="<td"+styl+" onmouseover='legacy_clk_date_only(this);'  title='moveover here to show only these period sites on map.'   >"+filclr+"___</td>";
        name="<td>"+name+"</td>";
        
        
        idate+="<tr>"+tdx+date+circFillClr+tot+fRate+name+"</tr>";
    }     
    return "<table id='legecyTb' border='1'>"+idate+"</table>";
};

MapLegacy.prototype.GetObjOfDate=function(date){
        var idate=parseInt(date);
        for(var i=0;i<this.legacy.length;i++){
            var obj=this.legacy[i];
            if( this.IsDateInRange(idate, obj.iStart,obj.iEnd) ){
                return obj;
            }
        }      
        return null;
    };
MapLegacy.prototype.IsDateInRange=function(idate, iMin, iMax){
    if( idate>=iMin && idate< iMax){
        return true;
    };
    return false;
};      
MapLegacy.prototype.updateLegacy_obj=function(obj,Date){
        var idate=parseInt(Date);
        var imax=obj.iEnd;
        var imin=obj.iStart;
        if( this.IsDateInRange(idate, imin, imax) ){
            obj.iTot++;
            obj.fRate= (100*obj.iTot/obj.iDlt).toFixed(1);
        }
};

MapLegacy.prototype.updateLegacy_objs=function(Date){
    for(var i=0;i<this.legacy.length;i++){
        var obj=this.legacy[i];
        this.updateLegacy_obj(obj, Date);     
    }
};
  
MapLegacy.prototype.UpdateLegacy=function(archinfo00){
    this.resetStats();
    for(var i=0;i<archinfo00.ChronicleInfoArr.length;i++){
        var aiobj=archinfo00.ChronicleInfoArr[i];
        var iDate=parseInt(aiobj.Date);
        this.updateLegacy_objs(iDate);
    }
};   

gMapLegacy=new MapLegacy(DATE_LEGACY_RELICS_SITE_FEATURES);









var ChinaArchMapUti={
circleArr:[],
clearCircles:function(){
    for(var i=0;i<ChinaArchMapUti.circleArr.length;i++){
        var cir=ChinaArchMapUti.circleArr[i];
        cir.setMap(null);        
    }
    ChinaArchMapUti.circleArr=[];
},
GenCenterLatLng:function(latlng){
	var centerLatLng = new google.maps.LatLng(35.85343961959182, 101.0302734375);

	if( latlng ){
		var arr=latlng.split(/,/);
		//alert(latlng);
		centerLatLng = new google.maps.LatLng(parseFloat(arr[0]),parseFloat(arr[1]) );
	}
	return centerLatLng;
} ,
UpdateMarkerPos:function(latlng, label){
    console.log(latlng+","+label);
    var arr=latlng.split(/,/);
    marker.setMap(map);
    marker.setPosition(new google.maps.LatLng( arr[0], arr[1] ));
    infowindow.setPosition(new google.maps.LatLng( arr[0], arr[1] ));
    infowindow.setContent(label);  
    infowindow.open(map,marker);
},   
OnClick_CircleOnMapxxx:function (latLng, objCir){
    //var f1=archinfo00.FindCloset(latLng);
    //var f2=archinfo01.FindCloset(latLng);
    //var f=f2;
    //if(f1.distMin<f2.distMin){
    //    f=f1;
    //}
    //console.log("final min dist="+f.distMin);
    //var arr=f.obj.LatLng.split(/,/);
    var arcDat= objCir.m_objAi;

    //infowindow.setPosition(new google.maps.LatLng( arr[0], arr[1] ));
    //infowindow.setContent(f.idx+":"+f.obj.Name+f.obj.LatLng); 
    //infowindow.open(map);
    var slabe=arcDat.Date+","+arcDat.Name+arcDat.LatLng;
    this.UpdateMarkerPos(arcDat.LatLng, slabe);
    
    var slatlng=arcDat.LatLng.replace(/[\s\(\)]/g,"");
    slatlng=$.trim(slatlng);
    $("#tables_container table tr").each(function(){
        var td2=$(this).find("td:eq(2)");
        var txt=td2.text();
        txt=txt.replace(/[\s\(\)]/g,"");
        if(txt.indexOf(slatlng)>=0){            
            td2.css("background-color", objCir.fillColor);
            td2[0].scrollIntoView();
            $("body").scrollTop(0);
        }
    });
    //$("td:contains('"+slatlng+"')").css("background-color","#cccccc")[0].scrollIntoView();
    
},
setLatLngArrAsCirclesOnMap:function (map,LatLngArr, arrId, jsnparm){
    for(var i=0;i<LatLngArr.length; i++){
        var xy=LatLngArr[i].split(/,/);
        if( !jsnparm) jsnparm={};
        if( !jsnparm.radius ) jsnparm.radius=10000;
        if( !jsnparm.strokeColor ) jsnparm.strokeColor="#990099";
        if( !jsnparm.fillColor ) jsnparm.fillColor="#0000FF";        

        var myCity = new google.maps.Circle({
            center:new google.maps.LatLng(xy[0],xy[1]),
            radius:jsnparm.radius,
            strokeColor:jsnparm.strokeColor,
            strokeOpacity:0.8,
            strokeWeight:1,
            fillColor:jsnparm.fillColor,
            fillOpacity:0.4,
            clickable:true
          });
        myCity.setMap(map);
        myCity.m_indx=i;
        myCity.m_arrId=arrId;
      

        google.maps.event.addListener(myCity,'click',function(ev) {
              console.log(ev.latLng+" | "+this.getCenter()+" | "+ this);
              ChinaArchMapUti.OnClick_Circle(ev.latLng.toString() , this );
              //infowindow.setPosition(ev.latLng);
              //infowindow.open(map);
        });
    }
},
setLatLngArrAsCirclesOnMap_ByArchInfoData:function (map, archInfo, jsnparm, gMapLegacy,OnClick_Circle){
    for(var i=0;i<archInfo.ChronicleInfoArr.length; i++){
        var aobj=archInfo.ChronicleInfoArr[i];
        var iDate=aobj["Date"];
        
        console.log("date:"+iDate, aobj);
        
        var LatLngArr=aobj["LatLng"];
        var xy=LatLngArr.split(/,/);
        if( !jsnparm) jsnparm={};
        if( !jsnparm.radius ) jsnparm.radius=10000;
        if( !jsnparm.strokeColor ) jsnparm.strokeColor="#990099";
        if( !jsnparm.fillColor ) jsnparm.fillColor="#0000FF";
        
        var dobj=gMapLegacy.GetObjOfDate(iDate);//DateLegacyUti.GetObj(datLegacy,iDate);
        jsnparm.radius=dobj['radius'];
        jsnparm.fillColor=dobj['circFillClr'];
        jsnparm.strokeColor=dobj['clr'];

        var myCity = new google.maps.Circle({
            center:new google.maps.LatLng(xy[0],xy[1]),
            radius:jsnparm.radius,
            strokeColor:jsnparm.strokeColor,
            strokeOpacity:0.8,
            strokeWeight:1,
            fillColor:jsnparm.fillColor,
            fillOpacity:0.5,
            clickable:true
          });
        myCity.setMap(map);
        myCity.m_objAi=aobj;
        ChinaArchMapUti.circleArr.push(myCity);
      

        google.maps.event.addListener(myCity,'click',OnClick_Circle);
        
        //function(ev) {
        //      console.log(ev.latLng+" | "+this.getCenter());
        //      ChinaArchMapUti.OnClick_Circle(ev.latLng.toString() , this );
        //      //infowindow.setPosition(ev.latLng);
        //      //infowindow.open(map);
        //});
    }
},
//MyCircles:[],
setLatLngArrAsCirclesOnMap_ByArchInfoData_range:function (map, archInfo, jsnparm){
    var istart=jsnparm.istart;
    var istop=jsnparm.istop;
    for(var i=istart;i<=istop; i++){
        var aobj=archInfo.ChronicleInfoArr[i];
        var iDate=aobj["Date"];
        
        console.log("date:"+iDate);
        
        var LatLngArr=aobj["LatLng"];
        var xy=LatLngArr.split(/,/);
        if( !jsnparm) jsnparm={};
        if( !jsnparm.radius ) jsnparm.radius=10000;
        if( !jsnparm.strokeColor ) jsnparm.strokeColor="#990099";
        if( !jsnparm.fillColor ) jsnparm.fillColor="#0000FF";
        
        //var dobj=DateLegacyUti.GetObj(datLegacy,iDate);
        //jsnparm.radius=dobj['radius'];
        //jsnparm.fillColor=dobj['circFillClr'];

        var myCity = new google.maps.Circle({
            center:new google.maps.LatLng(xy[0],xy[1]),
            radius:jsnparm.radius,
            strokeColor:jsnparm.strokeColor,
            strokeOpacity:0.8,
            strokeWeight:1,
            fillColor:jsnparm.fillColor,
            fillOpacity:0.5,
            clickable:true
          });
        myCity.setMap(map);
        myCity.m_indx=i;
        myCity.m_arrId=archInfo.UniqName;
        //ChinaArchMap.MyCircles[i]=myCity;
      

        google.maps.event.addListener(myCity,'click',function(ev) {
              console.log(ev.latLng+" | "+this.getCenter());
              ChinaArchMapUti.OnClick_Circle(ev.latLng.toString() , this );
              //infowindow.setPosition(ev.latLng);
              //infowindow.open(map);
        });
    }
},

setLatLngArrAsPolylineOnMap:function ( map,LatLngArr,jsnparm){
        if( !jsnparm) jsnparm={};
        if( !jsnparm.radius ) jsnparm.radius=10000;
        if( !jsnparm.strokeColor ) jsnparm.strokeColor="#990000";
        if( !jsnparm.fillColor ) jsnparm.fillColor="#0000FF";
        
     /////start Point
     var xy=LatLngArr[0].split(/,/);
     
    var myCityStart = new google.maps.Circle({
      center:new google.maps.LatLng(xy[0],xy[1]),
      radius:20000,
      strokeColor:"#FF0000",
      strokeOpacity:0.8,
      strokeWeight:2,
      fillColor:"#0000FF",
      fillOpacity:0.4
    });
    myCityStart.setMap(map);    
    
    
    //polyline
    
    var myTrip=[];
    for(var i=0;i<LatLngArr.length; i++){
        var xy=LatLngArr[i].split(/,/);
        var marker=new google.maps.LatLng(xy[0],xy[1]);
        myTrip.push(marker);          
    }
    var flightPath=new google.maps.Polyline({
     path:myTrip,
     strokeColor:jsnparm.strokeColor,
     strokeOpacity:0.8,
     strokeWeight:0.5
     });
     
     flightPath.setMap(map);
},
setLatLngArrAsPolylineOnMap2:function ( map,LatLngArr,iMax, jsnparm){
    if(iMax<1) return;
    
        if( !jsnparm) jsnparm={};
        if( !jsnparm.radius ) jsnparm.radius=10000;
        if( !jsnparm.strokeColor ) jsnparm.strokeColor="#990000";
        if( !jsnparm.fillColor ) jsnparm.fillColor="#0000FF";
       
    //polyline
    var start=iMax-1;
    
    var myTrip=[];
    for(var i=start;i<=iMax; i++){
        var xy=LatLngArr[i].split(/,/);
        var marker=new google.maps.LatLng(xy[0],xy[1]);
        myTrip.push(marker);          
    }
    var flightPath=new google.maps.Polyline({
     path:myTrip,
     strokeColor:jsnparm.strokeColor,
     strokeOpacity:0.8,
     strokeWeight:0.5
     });
     
     flightPath.setMap(map);
},
setMyPolylineOnMap:function (map, RiverData, colr){
    var arr=RiverData;
    var myTrip=[];
    for(var i=0;i<arr.length; i+=2){
        if(i>=arr.length-1) break;
        var x=arr[i];
        var y=arr[i+1];
        var marker=new google.maps.LatLng(parseFloat(x),parseFloat(y) );
        myTrip.push(marker);          
    }
    var flightPath=new google.maps.Polyline({
     path:myTrip,
     strokeColor:colr,
     strokeOpacity:0.5,
     strokeWeight:1
     });
     
     flightPath.setMap(map);
},
FindCloestPoint:function (arr, lat,lng){
    var dMin=999999.0,latlng="";
    for(var i=0;i<arr.length; i+=2){
        if(i>=arr.length-1) break;
        var x=parseFloat(arr[i]);
        var y=parseFloat(arr[i+1]);
        var dx=x-parseFloat(lat);
        var dy=y-parseFloat(lng);
        var dist=Math.sqrt(dx*dx+dy*dy);
        if(dist<=dMin){
            dMin=dist;
            latlng=x+","+y;
        }       
    }
    console.log("FindCloestPoint:"+latlng);
    return latlng;
},
setJerusalemLatLineOnMap:function (map){
    var myTrip=[], Vert=[];
    //31.777778, 35.235418
    for(var i=-180;i<180; i+=10){
        var marker=new google.maps.LatLng(31.777778,i);
        myTrip.push(marker);          
    }
    for(var i=-90;i<90; i+=2){
        var marker=new google.maps.LatLng(i,35.235418);
        Vert.push(marker);          
    }
    
    var flightPath=new google.maps.Polyline({
     path:myTrip,
     strokeColor:"#000000",
     strokeOpacity:0.5,
     strokeWeight:1
     });
    var vertPath=new google.maps.Polyline({
     path:Vert,
     strokeColor:"#000000",
     strokeOpacity:0.5,
     strokeWeight:1
     });
     
     flightPath.setMap(map);
     vertPath.setMap(map);

},



setMyTextsOnMap:function (map){
    var arr=Table_Get_LatLng();
    for(var i=0;i<arr.length; i++){
        var xy=arr[i].split(/,/);
        
     var marker1 = new google.maps.MarkerWithLabel({
       position: new google.maps.LatLng(xy[0],xy[1]),
       draggable: true,
       raiseOnDrag: true,
       map: map,
       labelContent: "$425K",
       labelAnchor: new google.maps.Point(22, 0),
       labelClass: "labels", // the CSS class for the label
       labelStyle: {opacity: 0.75}
     });
        marker1.setMap(map);
          
    }
},
setMyInfoOnMap:function (map){
    var arr=Table_Get_LatLng();
    for(var i=0;i<arr.length; i++){
        var xy=arr[i].split(/,/);
        
     var infowindow = new google.maps.InfoWindow({
      content:" "+i
      });
     infowindow.open(map,marker);
          
    }
},
setMyMarkersOnMap:function (map){
    var arr=Table_Get_LatLng();
    for(var i=0;i<arr.length; i++){
        var xy=arr[i].split(/,/);
        
          var marker=new google.maps.Marker({
            position:new google.maps.LatLng(xy[0],xy[1]),
          });
          marker.setMap(map);
                
        var infowindow = new google.maps.InfoWindow({
          content:" "+i
          });
        //infowindow.open(map,marker);
    }
},
setMyCirclesOnMap:function(map){
    var arr=Table_Get_LatLng();
    for(var i=0;i<arr.length; i++){
        var xy=arr[i].split(/,/);
        

        var myCity = new google.maps.Circle({
            center:new google.maps.LatLng(xy[0],xy[1]),
            radius:10000,
            strokeColor:"#990099",
            strokeOpacity:0.8,
            strokeWeight:2,
            fillColor:"#0000FF",
            fillOpacity:0.4
          });
          myCity.setMap(map);
          
          

          google.maps.event.addListener(myCity,'click',function() {
              alert();
              });

          
    }
},
setPolylineOnMap:function (map){
    var arr=Table_Get_LatLng();
    
    
     /////start Point
     var xy=arr[0].split(/,/);
     
    var myCityStart = new google.maps.Circle({
      center:new google.maps.LatLng(xy[0],xy[1]),
      radius:20000,
      strokeColor:"#FF0000",
      strokeOpacity:0.8,
      strokeWeight:2,
      fillColor:"#0000FF",
      fillOpacity:0.4
    });
    myCityStart.setMap(map);    
    
    
    //polyline
    
    var myTrip=[];
    for(var i=0;i<arr.length; i++){
        var xy=arr[i].split(/,/);
        var marker=new google.maps.LatLng(xy[0],xy[1]);
        myTrip.push(marker);          
    }
    var flightPath=new google.maps.Polyline({
     path:myTrip,
     strokeColor:"#990000",
     strokeOpacity:0.8,
     strokeWeight:0.5
     });
     
     flightPath.setMap(map);
}
};


