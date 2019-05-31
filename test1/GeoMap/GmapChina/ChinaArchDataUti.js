var ChinaArchDataUti=function(ArchInfo, UniqName){
    this.ChronicleInfoClosestArr=[];
    this.ChronicleInfoArr=[];//ArchInfo; //will be time ordered.
    this.UniqName="";
    
    this.KeysArr=["Date","LatLng","Name","Locate","Descrp"];
    
    this.LatLngArr=[];//time ordered, used for map
    this.NameArr=[];//time ordered
    this.DateArr=[];//time ordered
    
    this.DateMin=99999;
    this.DateMax=-99999;
    
    
    this.AddMore(ArchInfo,UniqName);
    
    //this.sortByDate();
    //this.gen_data_for_gmap();
};


ChinaArchDataUti.prototype.AddMore=function(ChronicleInfoArr, name){
    if(!this.UniqName) {
        this.UniqName=name;
    }
    else{
        this.UniqName += ","+name;
    }
    for(var k=0; k<ChronicleInfoArr.length; k++){
        var addonObj=ChronicleInfoArr[k];
        var retObj=this.FindCloestObjOf(addonObj);
        if(retObj.dMinDist<0.1){
            this.ChronicleInfoClosestArr.push(addonObj);
            this.ChronicleInfoClosestArr.push(retObj.ClosestObj);
        }
        this.ChronicleInfoArr.push(addonObj);
    }

    this.sortByDate();
    this.gen_data_for_gmap();
};
ChinaArchDataUti.prototype.FindCloestObjOf=function (oChr){
    var dMin=999999.0,latlng="";
    var arr=oChr.LatLng.split(",");
    var x=parseFloat(arr[0]);
    var y=parseFloat(arr[1]);  
    var objClosest=null;
    for(var i=0;i<this.ChronicleInfoArr.length; i++){
        var obji=this.ChronicleInfoArr[i];
        var arri=obji.LatLng.split(",");
        var dx=x-parseFloat(arri[0]);
        var dy=y-parseFloat(arri[1]);
        var dist=Math.sqrt(dx*dx+dy*dy);
        if(dist<dMin){
            dMin=dist;
            objClosest=obji;            
        }       
    }
    var retObj={};
    if(objClosest) {
        retObj.ClosestObj=objClosest;
        retObj.dMinDist=dMin;
    }
    console.log("FindCloestPoint:"+dMin);
    return retObj;
};
ChinaArchDataUti.prototype.sortByDate=function(sortType){
    this.ChronicleInfoArr.sort(function(a,b){
        var ai=parseInt(a.Date);
        var bi=parseInt(b.Date);
        return ai-bi ;
    });
};
ChinaArchDataUti.prototype.GenJsonStr=function(){
    var iMax=this.ChronicleInfoArr.length;
    var str="//iMax="+iMax+"\n[\n";
    for(var i=0; i<iMax; i++){
        var obj=this.ChronicleInfoArr[i];
        
        str+="{\n";
        for(k in this.KeysArr){
            var key=this.KeysArr[k];           
            var val=obj[key]; 
            str+=key+":\""+val+"\",\n";
        } 
        str+="},\n\n";
    }
    str+="];\n";
    return str;
};
ChinaArchDataUti.prototype.GetTableOfObjArr=function(ChronicleInfoArr){
    var captionName=this.UniqName;
    var str="<table border='1'><caption id='cap'>"+this.UniqName+"</caption>";
    str+=this.getTableTH();
    for(var i=0; i<ChronicleInfoArr.length; i++){
        var obj=ChronicleInfoArr[i];
        //console.log(i);
        var styl="";
        if(this.hasTxtInObj(obj,"文字") ) {
            styl=" bgcolor='#FF0000' title='文字' "; 
        }

        str+="<tr"+styl+">";
        str+="<td onclick='clk_idx(this);'>"+i+"</td>";
        for(k in this.KeysArr){
            var key=this.KeysArr[k];
            //console.log(key);            
            var val=obj[key]; 
            if("Descrp"===key) {       
                //console.log(i, captionName, key);
                refobj=obj['Refdic'];
                if (refobj){                    
                    //console.log(refobj);
                    var kidx=0;
                    val+=" ";
                    $.each(refobj,function(urls,descs){
                        urls=$.trim(urls);
                        if(urls.length>0){
                            kidx++;
                            val+="<a href='"+urls+"'>("+kidx+")</a>"+descs+" ";                           
                        }
                    });
                }
            }
            var onclk="onclick='clk_"+key+"(this);' ";
            str+="<td "+onclk+">"+val+"</td>";
        }
        str+="</tr>";            
    }
    str+="</table>";
    return str;
};
ChinaArchDataUti.prototype.GetTable=function(){
    return this.GetTableOfObjArr(this.ChronicleInfoArr);
};
ChinaArchDataUti.prototype.GetTableCloest=function(){
    return this.GetTableOfObjArr(this.ChronicleInfoClosestArr);
};
ChinaArchDataUti.prototype.getTableTH=function(){
        var str ="<tr><th>#</th>";
        for(i in this.KeysArr){
            //console.log(key);
            str+="<th>"+this.KeysArr[i]+"</th>";
        }
        str+="</tr>";            
    return str;
};
ChinaArchDataUti.prototype.gen_data_for_gmap=function(){
    this.LatLngArr=[];
    this.NameArr=[];
    this.DateArr=[];
    for(var i=0; i<this.ChronicleInfoArr.length; i++){
        var obj=this.ChronicleInfoArr[i];
        this.LatLngArr.push(obj["LatLng"]);        
        this.NameArr.push(obj["Name"]);  
        this.DateArr.push(obj["Date"]); 
        
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

ChinaArchDataUti.prototype.searchInDateRange=function(iMin,iMax,IsInRange){
    var arr=[];
    for( var i=0;i<this.ChronicleInfoArr.length; i++){
        var obj=this.ChronicleInfoArr[i];
        var date=obj['Date'];
        var idate=parseInt(date);
        //if(idate>iMin  && idate <= iMax){
        if(IsInRange(idate,iMin,iMax)){
            arr.push(obj);   
        }
    }
    var ret=new ChinaArchDataUti(arr,"");
    return ret;
};
ChinaArchDataUti.prototype.searchTxt=function(key){
    var arr=[];
    for( var i=0;i<this.ChronicleInfoArr.length; i++){
        var obj=this.ChronicleInfoArr[i];
        var Name=obj['Name'];
        var Descrp=obj['Descrp'];
       
        var find=this.hasTxtInObj(obj,key);
        if(find){
            arr.push(obj);        
        }
    }
    var ret=new ChinaArchDataUti(arr,key);
    return ret;
};
ChinaArchDataUti.prototype.hasTxtInObj=function(obj, key){
    var Name=obj['Name'];
    var Descrp=obj['Descrp'];
    var Locate=obj['Locate'];
    
    var find=false;
    if( !!Name && Name.indexOf(key)>=0){
        find=true;
    }
    else if(!!Descrp && Descrp.indexOf(key)>=0){
        find=true;
    }
    else if( !!Locate && Locate.indexOf(key)>=0){
        find=true;
    }
    return find;
};