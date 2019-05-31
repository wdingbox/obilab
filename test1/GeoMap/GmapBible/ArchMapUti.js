

var ArchMapUti={
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
OnClick_Circle:function (latLng, objCir){
    //var f1=archinfo00.FindCloset(latLng);
    //var f2=archinfo01.FindCloset(latLng);
    //var f=f2;
    //if(f1.distMin<f2.distMin){
    //    f=f1;
    //}
    //console.log("final min dist="+f.distMin);
    //var arr=f.obj.LatLng.split(/,/);
    var objId= objCir.m_arrId;
    var indx = objCir.m_indx;
    var arcDat=null;
    if(objId===0){
        arcDat=archinfo00.ChronicleInfoArr[indx];
    }
    else{
        arcDat=archinfo01.ChronicleInfoArr[indx];
    }
    //infowindow.setPosition(new google.maps.LatLng( arr[0], arr[1] ));
    //infowindow.setContent(f.idx+":"+f.obj.Name+f.obj.LatLng); 
    //infowindow.open(map);
    var slabe=indx+":"+arcDat.Name+arcDat.LatLng;
    this.UpdateMarkerPos(arcDat.LatLng, slabe);
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
              ArchMapUti.OnClick_Circle(ev.latLng.toString() , this );
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
        if( !jsnparm) jsnparm={};
        if( !jsnparm.radius ) jsnparm.radius=10000;
        if( !jsnparm.strokeColor ) jsnparm.strokeColor="#990000";
        if( !jsnparm.fillColor ) jsnparm.fillColor="#0000FF";
       
    //polyline
    
    var myTrip=[];
    for(var i=0;i<=iMax; i++){
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
setMyRiverOnMap:function (map, RiverData){
    var arr=RiverData;
    var myTrip=[];
    for(var i=0;i<arr.length; i+=2){
        var x=arr[i];
        var y=arr[i+1];
        var marker=new google.maps.LatLng(x,y);
        myTrip.push(marker);          
    }
    var flightPath=new google.maps.Polyline({
     path:myTrip,
     strokeColor:"#0000FF",
     strokeOpacity:0.5,
     strokeWeight:1
     });
     
     flightPath.setMap(map);

},
setJerusalemLatLineOnMap:function (map){
    var myTrip=[];
    //31.886977, 34.554191
    //west wall: 31.77670746841661, 35.234522223472595
    var latWW=31.77670746841661, LngWW=35.234522223472595;
    for(var i=-90;i<90; i+=2){
        var marker=new google.maps.LatLng(latWW,LngWW+i);
        myTrip.push(marker);          
    }
    var marker=new google.maps.LatLng(latWW,LngWW);
    myTrip.push(marker); 
    for(var i=-90;i<90; i+=2){
        var marker=new google.maps.LatLng(latWW+i, LngWW);
        myTrip.push(marker);          
    }    
    
    
    var flightPath=new google.maps.Polyline({
     path:myTrip,
     strokeColor:"#0000FF",
     strokeOpacity:0.5,
     strokeWeight:1
     });
     
     flightPath.setMap(map);

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


