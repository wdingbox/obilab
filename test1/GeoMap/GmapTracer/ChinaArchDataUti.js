var ChinaArchDataUti=function(ArchInfo){
    this.ChronicleInfoArr=ArchInfo; //will be time ordered.
    
    this.LatLngArr=[];//time ordered
    this.NameArr=[];//time ordered
    
    this.DateMin=99999;
    this.DateMax=-99999;
    
    this.sortByDate();
    this.gen_data_for_gmap();
};


ChinaArchDataUti.prototype.AddMore=function(ChronicleInfoArr){
    for(var k=0; k<ChronicleInfoArr.length; k++){
        this.ChronicleInfoArr.push(ChronicleInfoArr[k]);
    }

    this.sortByDate();
    this.gen_data_for_gmap();
};
ChinaArchDataUti.prototype.sortByDate=function(sortType){
    this.ChronicleInfoArr.sort(function(a,b){
        var ai=parseInt(a.Date);
        var bi=parseInt(b.Date);
        return ai-bi ;
    });
};
ChinaArchDataUti.prototype.GetTable=function(){
    var str="<table border='1'>";
    str+=this.getTableTH();
    for(var i=0; i<this.ChronicleInfoArr.length; i++){
        var obj=this.ChronicleInfoArr[i];
        console.log(i);
        str+="<tr><td>"+i+"</td>";
        for(key in obj){
            console.log(key);
            var onclk="onclick='clk_"+key+"(this);' ";
            str+="<td "+onclk+">"+obj[key]+"</td>";
        }
        str+="</tr>";            
    }
    str+="</table>";
    return str;
};
ChinaArchDataUti.prototype.getTableTH=function(){
        var str ="<tr><th>#</th>";
        for(key in this.ChronicleInfoArr[0]){
            console.log(key);
            str+="<th>"+key+"</th>";
        }
        str+="</tr>";            
    return str;
};
ChinaArchDataUti.prototype.gen_data_for_gmap=function(){
    this.LatLngArr=[];
    this.NameArr=[];
    for(var i=0; i<this.ChronicleInfoArr.length; i++){
        var obj=this.ChronicleInfoArr[i];
        this.LatLngArr.push(obj["LatLng"]);        
        this.NameArr.push(obj["Name"]);  
        
        var date = parseInt(obj["Date"]);
        if( date > this.DateMax ) {
            this.DateMax = date;
        }
        if( date < this.DateMin ) {
            this.DateMin = date;
        }
        
    }
    return this.LatLngArr;
};

ChinaArchDataUti.prototype.FindCloset=function(latlng){
    var idx=-1;
    var distMin=9999999.0;
    var objRet=null;
    for(var i=0; i<this.ChronicleInfoArr.length; i++){
        var obj=this.ChronicleInfoArr[i];
        var ll=obj["LatLng"];  
        var dist = this.distance(ll.toString(), latlng.toString());
        
        if( dist < distMin ){
            distMin=dist;
            idx=i;
            objRet=obj;
        }
        console.log(i+" : dist="+dist+",min="+distMin);
    }
    return {idx:idx,distMin:distMin,obj:objRet};
};
ChinaArchDataUti.prototype.distance=function(latlng1,latlng2){
    var arr1=latlng1.split(/,/);
    latlng2=latlng2.replace(/\(/,'');
    var arr2=latlng2.split(/,/);
    
    var x1=parseFloat(arr1[0]);
    var y1=parseFloat(arr1[1]);
    var x2=parseFloat(arr2[0]);
    var y2=parseFloat(arr2[1]);
    var dltx=x2-x1;
    var dlty=y2-y1;
    var dist=dltx*dltx+dlty*dlty;

    dist=Math.sqrt(dist);    
    return dist;
};
ChinaArchDataUti.prototype.gen_TimeFreq=function(nScale){
    //var nScale=200;
    var nRange=parseInt(this.DateMax) - parseInt(this.DateMin);
    this.Freq_Delta = nRange / nScale;
    this.Freq=[];
    for(var i=0;i<=nScale; i++){
        this.Freq[i]=0;
    }
    
    for(i=0;i<this.ChronicleInfoArr.length; i++){
        var dat=this.ChronicleInfoArr[i]["Date"];
        var yr = parseInt(dat)-parseInt(this.DateMin);
        var idx = Math.ceil( yr / this.Freq_Delta);
        if(idx>nScale) alert("Err iscale="+iscale);
        
        this.Freq[idx] ++;
    }
      
    return ;
};
ChinaArchDataUti.prototype.genFreqTable=function(){
    var tt="<table border='1'>";
    tt+="<caption>Year Delta:"+parseInt(this.Freq_Delta) +"</caption>";
    for(var i=0;i<this.Freq.length; i++){
        var yr=  parseInt(this.DateMin + this.Freq_Delta * i);
        tt+="<tr><td>"+i+"</td><td>"+ yr+"</td><td>"+this.Freq[i] +"</td></tr>";
    }
    tt+="</table>";
    return tt;
};
ChinaArchDataUti.prototype.GetFreqTable=function(jsparm){
    if(!jsparm.scale) jsparm.scale=200;
    this.gen_TimeFreq(jsparm.scale);
    return this.genFreqTable();
};

ChinaArchDataUti.prototype.GenTimeDistanceArrForLatLng=function(slatlng){
    var TimeDistanceArr=[];
    for( var i=0;i<this.ChronicleInfoArr.length; i++){
        var obj=this.ChronicleInfoArr[i];
        var latlng=obj['LatLng'];
        var dist=this.distance(slatlng, latlng);
        var time=parseInt(obj.Date);
        var obj2 = {Date:time, distance:dist};
        TimeDistanceArr.push(obj2);        
    }
    return TimeDistanceArr;
};


