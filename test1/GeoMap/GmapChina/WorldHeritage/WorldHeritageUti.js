var WorldHeritageUti=function(dat){
 this.RowArr=dat['query']['row'];
 this.catArr=[];
};
WorldHeritageUti.prototype.category=function(){
    var st="<table border='1'>";
    for(var k=0; k<this.RowArr.length; k++){
        var cat = this.RowArr[k]['category'];
        if( this.catArr.indexOf(cat)<0){
            this.catArr.push(cat);
            st+="<tr><td>"+cat+"</td></tr>";
        }
        else{
        }
    }
    
    st+="</table>";
    return st;
};
WorldHeritageUti.prototype.GetTable2=function(){
    var trs='',aiobj={};
    for(var k=0; k<this.RowArr.length; k++){
        var ro = this.RowArr[k];
        aiobj=this.genArchInfoObj(ro);
        trs+=this.getTR(k,aiobj);
    }
    var st="<table border='1'>"+this.getTH(aiobj);
    st+=trs+"</table>";
    return st;
};
WorldHeritageUti.prototype.GetTable=function(){
    var st="<table border='1'>"+this.getTH(this.RowArr[0]);
    for(var k=0; k<this.RowArr.length; k++){
        var ro = this.RowArr[k];
        st+=this.getTR(k,ro);
    }
    st+="</table>";

    return st;
};
WorldHeritageUti.prototype.getTR=function(idx,robj){
    var st="<tr><td>"+idx+"</td>";
    for( k in robj){
        var val=robj[k];
        if("http_url"===k){
            val="<a href='"+val+"'>link</a>";
        }
        else if("image_url"===k){
            val="<img src='"+val+"'></img>";
        }
        st += "<td>"+val +"</td>";
    }
    st+="</tr>";
    return st;
};
WorldHeritageUti.prototype.getTH=function(robj){
    var st='<tr><td>#</td>';
    for( k in robj){
        st += "<th>"+k +"</th>";
    }
    st+="</tr>";
    return st;
};

WorldHeritageUti.prototype.genArchInfoData=function(){
    this.ArchInfoDat=[];

    for(var k=0; k<this.RowArr.length; k++){
        var DatObj  = this.RowArr[k];
        var cat = DatObj['category'];
        
        var obj=this.genArchInfoObj(DatObj);
        
        this.ArchInfoDat.push(obj);
    }
};
WorldHeritageUti.prototype.genArchInfoObj=function(DatObj){
        var cat =                    DatObj['category'];
        var lat  =                   DatObj['latitude'];
        var lng =                    DatObj['longitude'];
        var site =                   DatObj['site'];
        var states =                 DatObj['states'];
        var region =                 DatObj['region'];
        var historical_description = DatObj['historical_description'];
        
        var obj={};
        obj.Date="-500";
        obj.LatLng=lat+","+lng;
        obj.Name="";
        obj.Locate=site+","+region+","+states;
        obj.Descrip=historical_description;
    return obj;
};


