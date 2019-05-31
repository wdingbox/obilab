var D3Tree=function(d3tree){
    this.d3tree=d3tree;
    this.sout="";
    this.idx=0;
    this.addrTmp="";
    this.p2pArr=[];//p2p obj={source:ss,target:tt,type:tt,,,}
    this.foundTreeNode=null;
};
D3Tree.prototype.sout_jid_jnm_=function(d3root){
    this.idx++;
    this.sout+="<br/>'id_"+this.idx+"':'', '"+ d3root.img+"':'"+d3root.addr+"',";
    var _this=this;
    $.each(d3root,function(key,obj){
        if(key==="children"){
            if(obj && obj.length>0){                
                for(var i=0;i<obj.length;i++){
                    _this.sout_jid_jnm_(obj[i]);
                }
            }
        }
    });
};
D3Tree.prototype.sout_jid_jnm=function(){
    this.idx=0;
    this.sout="<hr>{";
    this.sout_jid_jnm_(this.d3tree);
    return this.sout+"<br/>};";
};
D3Tree.prototype.walkshow=function(d3root){
    this.idx++;
    this.sout+="<br/>"+this.idx+" img="+d3root.img+", addr="+d3root.addr+" ,name="+d3root.name;
    var _this=this;
    $.each(d3root,function(key,obj){
        if(key==="children"){
            if(obj && obj.length>0){                
                for(var i=0;i<obj.length;i++){
                    _this.walkshow(obj[i]);
                }
            }
        }
    });
};
D3Tree.prototype.GetWalkShowTxt=function(){
    this.idx=0;
    this.sout="";
    this.walkshow(this.d3tree);
    return this.sout;
};
D3Tree.prototype.findTreeChildNodeByKeyVal=function(ParentObj,key,val){
    if( ParentObj.children == undefined || ParentObj.children.length ==0) {
        return;
    }
    for(var i=0;i<ParentObj.children.length;i++){
        var obj=ParentObj.children[i];
        if(obj[key]==val){
            this.foundTreeNode=obj;
            return;
        }
        this.findTreeChildNodeByKeyVal(obj,key,val);
    }    
    return;
};
D3Tree.prototype.FindTreeChildNodeByKeyValPair=function(key,val){
    this.findTreeChildNodeByKeyVal(this.d3tree,key,val);
    return this.foundTreeNode;
};
D3Tree.prototype.convertTreeToP2pObjArr=function(d3tree){
    if( undefined===d3tree.children || d3tree.children.length==0){
        return;
    }
    var _this=this;
    $.each(d3tree.children,function(i,child){
        var addr=child.addr;
        if(addr.length>0){
            var p2pObj={source:d3tree.addr};//img is not uniq,use uniq addr
            p2pObj["target"]=addr;
            p2pObj["type"]="licensing";
            $.each(child,function(k,v){
                if(k != "children"){
                    p2pObj[k]=v;
                }
            });
            _this.p2pArr.push(p2pObj);
            _this.convertTreeToP2pObjArr(child);
        }
    });
};
D3Tree.prototype.GenP2pObjArr=function(){
    this.convertTreeToP2pObjArr(this.d3tree);
    return this.p2pArr;
};
D3Tree.prototype.showP2pArr=function(){
    var _this=this;
    this.sout="[<br/>";
    $.each(this.p2pArr,function(i,p2p){
        p2p["idx"]=i;
        _this.sout+="source:"+D3Uti.strKeyValPairs(p2p.source)+",<br/>";
        _this.sout+="target:"+D3Uti.strKeyValPairs(p2p.target)+",<br/><br/>";
    });
    this.sout+="];<br/>";
    return this.sout;
};
D3Tree.prototype.GenNewChildAddrOf=function(d3parent){
    if(undefined == d3parent.children || d3parent.children.length==0){
        return d3parent.addr+".01";
    }
    var childrenAddrArr=[];
    var nIdMaxLen = -1;
    for(var i=0; i<d3parent.children.length; i++){
        var name = d3parent.children[i].name;
        childrenAddrArr.push(name);
        if( nIdMaxLen <= name.length ){
            nIdMaxLen = name.length;
        }
    }
    if(nIdMaxLen===1){
        var addr1=["1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];
        for(var i=0; i<addr1.length; i++){
            var newAddr=addr1[i];
            if( childrenAddrArr.indexOf(newAddr)<0 ) {
                return d3parent.addr+"."+newAddr;
            }
        }        
    }
    if(nIdMaxLen===2){
        for(var i=1;i<100;i++){
            var si=(i<10)?("0"+i):(""+i);
            if(childrenAddrArr.indexOf(si)<0) {
                return d3parent.addr+"."+si;            
            }
        }
    }
    return alert("errNoAvailableAddrForThisNode");
};
D3Tree.prototype.SetNewParentOfChild=function(d3parent,d3child){
    var NewAvailableChildAddrForParent = this.GenNewChildAddrOf(d3parent);
    //var arrNewAddr=NewAvailableChildAddrForParent.split(".");
    //var arrOldAddr=d3child.addr.split(".");
    var sToBeReplacedOld=d3child.addr+".";
    var sNewString=NewAvailableChildAddrForParent+".";
    //var regOld=new RegExp('^'+sToBeReplacedOld, '');
    
    var d3tree=new D3Tree(d3child);
    var findNode=d3tree.FindTreeChildNodeByKeyValPair("addr",d3parent.addr);
    if(findNode != null){
        alert("Parent node is a child of the node you are going to move to.");
        return;
    }
    
    //var child=this.FindTreeChildNodeByKeyValPair("addr",d3child.addr);
    this.removeTreeChildNodeByKeyVal(this.d3tree, {addr:d3child.addr});
    
    //return;
    
    d3child.addr=NewAvailableChildAddrForParent;
    this.sout="Replace:"+sToBeReplacedOld+"=>"+sNewString+"<hr/>";
    if(d3child.children && d3child.children.length>0){               
        for(var i=0;i<d3child.children.length;i++){
            this.updateNodeAddr(d3child.children[i],sToBeReplacedOld,sNewString);
        }
    } 
    if(undefined == d3parent.children ){
        d3parent.children=[];        
    }
    d3parent.children.push(d3child);
};
D3Tree.prototype.updateNodeAddr=function(node,sToBeReplacedOld,sNewString){
    this.idx++;
    this.sout+="<br/>"+this.idx+" img="+node.img+", addr="+node.addr+" ,name="+node.name;

    var oldAddr=node.addr;
    var idx=oldAddr.indexOf(sToBeReplacedOld);
    if( idx!=0 ) alert("address is not correct. oldAddr=" + oldAddr);
    var newAddr=oldAddr.replace(sToBeReplacedOld,sNewString);
    node.addr=newAddr;
    this.sout+=",newAddr="+newAddr;
    if(undefined == node.children){
        return;
    }
    for(var i=0;i<node.children.length;i++){
        this.updateNodeAddr(node.children[i], sToBeReplacedOld, sNewString);     
    };
};
D3Tree.prototype.removeTreeChildNodeByKeyVal=function(ParentObj,pairObj){
    if( ParentObj.children == undefined || ParentObj.children.length ==0) {
        return;
    }
    for(var i=0;i<ParentObj.children.length;i++){
        var obj=ParentObj.children[i];
        for(key in pairObj){
            if(obj[key]==pairObj[key]){
               this.foundTreeNode=obj;
               ParentObj.children.splice(i,1);
               return;
            }
        }
        this.removeTreeChildNodeByKeyVal(obj,pairObj);
    }    
    return;
};

D3Tree.prototype.toggleChildren=function(addr){
    var findNode=this.FindTreeChildNodeByKeyValPair("addr",addr);
    if(findNode != null){
        alert("Parent node is a child of the node you are going to move to.");
        return;
    }
        
}



var D3P2p=function(){
    this.sout="";
    this.idx=0;
    this.addrTmp="";
    this.p2pArr=[];//p2p obj={source:ss,target:tt,type:tt,,,}
};
D3P2p.prototype.getBranchNodesOf=function(p2pArr,branchNodeName){
    this.idx++;
    this.sout+="<br/>"+this.idx+" img="+d3root.img+", addr="+d3root.addr+" ,name="+d3root.name;
    var _this=this;
    for(var i=0;i<p2pArr.length;i++){
        if(p2pArr[i].source==branchNodeName){
            this.p2pArr.push(p2pArr[i]);
            this.getBranchNodesOf(p2pArr[i]);
        }
    }
       
};





var D3Uti={
shallowCopy:function(obj){
    var ret={};
    for(key in obj){
        var val=typeof (obj[key] );
        if( val != typeof {} ){
            val=obj[key];
        }
        ret[key]=val;
    };
    return ret;
}, 
strKeyValPairs:function(obj){
    var shallo=D3Uti.shallowCopy(obj);
    return JSON.stringify(shallo);
    
    var ss="{";
    for(key in obj){
        ss+=key+":\"";
        var val=typeof (obj[key] );
        if( val != typeof {} ){
            val=obj[key];
        }
        ss+=""+val+"\",";        
    };
    ss=ss.replace(/[,]$/,'');
    ss+="}";
    return ss;
}, 
undupAddrObjArr:function(addrData){
    var tmpAddr="", idx=0;
    for(var j=0;j<addrData.length;j++){
        if(addrData[j].addr == tmpAddr ){
            idx++;
            var paddingIdx="0"+idx;
            while(paddingIdx.length<3) paddingIdx="0"+paddingIdx;
            addrData[j].addr+="."+paddingIdx;
        }
        else{//reset
            tmpAddr=addrData[j].addr;
            idx=0;
        }
    };
},

//get D3 Obj from addr Obj.
getTreeNodeFromAddrObj:function(addrData){
    var addr=addrData.addr;
    var arry=addr.split(".");
    
    var d3obj={};
    for(key in addrData){
        if(key != "name" && key != "children"){
            d3obj[key]=addrData[key];
        }
    }
    d3obj.addr=arry[0];
    d3obj.name=arry[0];
    d3obj.children=[];
    if(arry.length==1){
        $.each(addrData,function(key,val){
           if(key != "name" && key != "children"){
               d3obj[key]=val;
           }
        });   
        return d3obj;         
    }
    
    var pchildren=d3obj.children;
    var baseAddr=arry[0];
    for(var i=1;i<arry.length;i++){
        var obj={};
        for(key in addrData){//for copy.
            obj[key]=addrData[key];
        }
        baseAddr+="."+arry[i];
        obj.addr=baseAddr;
        obj.name=arry[i];
        obj.children=[];
        obj.img+="";//do not duplicate img.
        
        pchildren.push(obj);        
        pchildren=obj.children;
    }
    return d3obj;    
},



getNewChildAddrOf:function(d3parent){
    if(undefined == d3parent.children || d3parent.children.length==0){
        return "01";
    }
    var childrenAddrArr=[];
    var nIdMaxLen = -1;
    for(var i=0; i<d3parent.children.length; i++){
        var addr = d3parent.children[i].addr;
        childrenAddrArr.push(addr);
        if( nIdMaxLen <= addr.length ){
            nIdMaxLen = addr.length;
        }
    }
    if(nIdMaxLen===1){
        var addr1=["1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];
        for(var i=0; i<addr1.length; i++){
            var newAddr=addr1[i];
            if(childrenAddrArr.indexOf(newAddr)<0) return newAddr;
        }        
    }
    if(nIdMaxLen===2){
        for(var i=1;i<100;i++){
            var si=(i<10)?("0"+i):(""+i);
            if(childrenAddrArr.indexOf(si)<0) return si;            
        }
    }
    return "err";
},

ConvertAddrObjArrToTreeRoot:function (addrData){
        var root={name:0,addr:"0",img:"00000"};

        for(var i=0;i<addrData.length;i++){
           var addr=addrData[i];

           var appObj=D3Uti.getTreeNodeFromAddrObj(addr);
           D3Uti.mergeChildTree(root, appObj);
        }
        //$("#out").append("<hr>"+JSON.stringify(root)+"<hr>");
        return root;
},

mergeChildTree:function(srcParentObj, childtree){
    if(undefined == srcParentObj.children){
        srcParentObj.children=[];
    }
    if(undefined == childtree.children ){
        childtree.children=[];
    }

    var find=0;
    for(var j=0;j<srcParentObj.children.length;j++){
        if( srcParentObj.children[j].name == childtree.name ) {
            for(var i=0;i<childtree.children.length;i++){
                D3Uti.mergeChildTree(srcParentObj.children[j], childtree.children[i]);
                find+=1;
            };            
            break;
        };
    };
    if(0==find){//dup nod.
        srcParentObj.children.push(childtree);
    }
},


convert_odb_table_to_d3_ooTree_show_on:function(eid){
    if(eid.indexOf("#")<0) eid="#"+eid;
    
    var jid_jnm_list={};
    var addrData=[];    
    var sss="<hr/>addrData(jid,jnm) from table :<br>";
    
    var idx_jid=$("table tr:eq(0)").find("th:contains('jid')").index();
    var idx_jnm=$("table tr:eq(0)").find("th:contains('jnm')").index();
    
    if(idx_jid<0 || idx_jnm<0) return alert("no col: jid, jnm");
    
    $("table tr").each(function(i){
        if(i>0){
            var img =$(this).find("td:eq("+idx_jid+")").text();
            var addr=$(this).find("td:eq("+idx_jnm+")").text();
            
            jid_jnm_list[img]=addr;
            
            console.log(img+","+addr);
            sss+="<br><br/>"+i+".img:"+img+",addr:"+addr;
            
            var addrObj={img:img,addr:addr};
            var d3o=D3Uti.getTreeNodeFromAddrObj(addrObj);
            sss+="<br/> obj="+JSON.stringify(d3o);
            
            addrData.push(addrObj);
        }
    });
    sss="jid_jnm_list<br><br>"+JSON.stringify(jid_jnm_list) + sss;
    sss+="<hr/>undupAddrObjArr:<br>";
    
    D3Uti.undupAddrObjArr(addrData);
    for(var i=0;i<addrData.length;i++){
        sss+="<br/>"+i+".img:"+addrData[i].img+",addr:"+addrData[i].addr;
    }
    
    this.sout=sss;   
    //$(eid).html(sss);
    var root=D3Uti.ConvertAddrObjArrToTreeRoot(addrData);
    
    this.sout+="<hr/>ConvertAddrObjArrToTreeRoot for file: D3Tree.json<br/><br/>"+JSON.stringify(root)+"<hr/>";
    //$(eid).append();
    
    var d3tree=new D3Tree(root);
    this.sout+="<hr/>D3Tree walkshow:<br>"+d3tree.GetWalkShowTxt()+"<hr/>";
    //$(eid).append();
    
  
    d3tree.GenP2pObjArr();
    sss="<hr/>convertTreeToP2pObjArr:<br/><br/>";
    sss+=d3tree.showP2pArr();
    sss+="<hr/>";
    this.sout+=sss;
    //$(eid).append(sss);  
},
LoadTree:function(remote_urlTree){
    var jsonfile=D3Uti.getTreeJsonFileFromUrl();
    if(jsonfile.length>0)remote_urlTree=jsonfile;
    var treeTxt = $.ajax({
        type: "GET",
        url: remote_urlTree,
        async: false,
        dataType:"text"
    }).responseText; 
    
    var tree=JSON.parse(treeTxt);
    return tree;
},
getTreeJsonFileFromUrl:function(){
    var arr=window.location.search.toString().split("=");
    if(arr.length==2){
        return arr[1];
    }
    return "";
},
popupWindow:function(surl){
    console.log("file:"+surl);
    if(surl.indexOf("../dat/") !=0 )
    return;
    var arr=window.location.href.split("?");
    var url=arr[0]+"?f="+surl;
    window.open(url);    
},


ImgFile:function(nod){
    var jid="";
    if( typeof (nod) == typeof {} ){
        //console.log("nod:"+nod.img+nod.addr);
        if(nod.img==="yy.jpg"){
            return "yy.jpg";
        }
        if(undefined == nod.addr) {
            nod.img="00000";
        }
        jid=nod.img;
    }
    else {
        jid=nod;
    }
    if( jid.indexOf(".gif")<0 ) {
        jid+=".gif";
    }   
     
    var fname="../../../../odb/tbi/img/jgif/"+jid;
    fname="../../../../../___bigdata/___compact/___solid/odb/tbi/img/jgif/"+jid;
    return fname;  
},


};


