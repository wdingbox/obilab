console.log("OpMenuUti");
var OpMenuUti={
selop:function (){
  $("*").css("cursor","default");
  var val=$("#selop").val();
  val=$.trim(val);
  console.log(val);
  $("#selop").val("");
  D3Uti.popupWindow(val);
  //OpMenuUti.OpMode_Set(val);
  switch(val){
   case "UpdateGraphic":
      fixedNodes(root,false);
      update_graphic();
      
   break;
   case "panZoomToggle":
        panZoom();
   break;
   case "Save2File":
       OpMenuUti.SaveD3Tree();
   break;    
   
   case "fixedNodeToggle":
       fixedNodes(root,true);
   break;  


   case "ViewD3Links":
        var d3t=new D3Tree();
        d3t.p2pArr=links;
        d3t.showP2pArr();
        OpMenuUti.dout(d3t.sout);
   break;
   case "ViewD3Nodes":
       var sss="";
       $.each(nodes,function(i,obj){
           sss+="#"+i+" : "+D3Uti.strKeyValPairs(obj)+"<br/>";           
       });
       OpMenuUti.dout(sss);
   break;
   case "ViewP2pArr":
       var sss="";
       $.each(links_p2p,function(i,obj){
           sss+="#"+i+" : "+JSON.stringify(obj)+"<br/>";
       });
       OpMenuUti.dout(sss);
   break;
   case "ViewTreeNodeList":
       var sss=d3tree.GetWalkShowTxt();
       OpMenuUti.dout(sss);
   break;
   case "View_sout_jid_jnm":
       var sss=d3tree.sout_jid_jnm();
       OpMenuUti.dout(sss);
   break;
   case "ViewTreeJson":
       OpMenuUti.dout(JSON.stringify(ood3tree));
   break;
   case "origLoadData":
       OpMenuUti.dout(origLoadData);
   break;

   default:
     $("*").css("cursor","default");
     $("#dout").html("").css("width","").css("height","");
   break;
  }
},
dout:function (str){
        //$("#dout").width(window.innerWidth-20);
        $("#dout").height(window.innerHeight-40);
        $("#dout").html(str);    
},
appendout:function (str){
        $("#dout").append("<br/>"+str);    
},

SaveD3Tree:function(){
    
    if(!confirm("\n\nSave?")) return;
    //update data.
    $.ajax({
        url:"../svr/svcFilePutContents.php",
        data:"fname=../dat/ood3tree.json&Data="+JSON.stringify(ood3tree),
        type: "POST",
        success:function(data){
            OpMenuUti.dout(d3tree.sout+"<hr/>"+data); 
        },
        error:function(){
            alert("failed");
        }
    });
},
};//OpMenuUti










$(document).ready(function(){
 $("#selop").change(function(){
  OpMenuUti.selop();
 });

});


$(document).ready(function(){
    console.log("p2");
    //$("#OpMenu").html("<a>--</a>");
    $.ajax({
        url:"../xml/OpMenu.htm",
        success:function(data){
            //console.log(data);
            //$("#OpMenu").html(data);
        }
    });
});//ready




































////////////////////////////////////
//for Context Menu of Image  
$(function() {
          //InitImgMenu();
});

function InitImgMenu(){
         $('image').contextPopup({
          title: 'My Popup Menu',
          items: [
            {label:'SwapWith...',           action:ImgPopupMenu.action_ExhangeNodes  },
            {label:'MoveToNewParent...',    action:ImgPopupMenu.action_SetNewParent  },
            null, // divider        
            {label:'AddNewChildImg',        action:ImgPopupMenu.action_AddNewChildImg },
            {label:'Delete',                action:ImgPopupMenu.action_Delete },
            {label:'ChangeImg',             action:ImgPopupMenu.action_ChangeImg },
            null, // divider        
            {label:'Onwards',               action:function() { alert('clicked 7') } },
            {label:'Flutters',              action:function() { alert('clicked 8') } }
          ]
        });   
}

 
var ImgPopupMenu={
 Init:function(elements){
         $(elements).contextPopup({
          title: 'My Popup Menu',
          items: [
            {label:'SwapWith...',           action:ImgPopupMenu.action_ExhangeNodes  },
            {label:'MoveToNewParent...',    action:ImgPopupMenu.action_SetNewParent  },
            null, // divider        
            {label:'AddNewChildImg',        action:ImgPopupMenu.action_AddNewChildImg },
            {label:'Delete',                action:ImgPopupMenu.action_Delete },
            {label:'ChangeImg',             action:ImgPopupMenu.action_ChangeImg },
            null, // divider        
            {label:'Onwards',               action:function() { alert('clicked 7') } },
            {label:'Flutters',              action:function() { alert('clicked 8') } }
          ],
          cancelMenuOps:ImgPopupMenu.cancelOps
        });   
},
oncontextMenu:function(d,i){
  ImgPopupMenu.m_startOps=1;

  console.log("right click: contextmenu");

  d.circle_color="#cc0000";
  ImgPopupMenu.m_d3_contextmenu_node=d;
  ImgPopupMenu.m_d3_contextmenu_circle=d3.select(this.parentNode).select("circle");
  ImgPopupMenu.m_d3_contextmenu_circle.style("stroke", d.circle_color);
},
onclickTargetImg:function (nod){
  //d3.select(this).attr("xlink:href", D3Uti.ImgFile(nod));
  if (d3.event.defaultPrevented) return; // ignore drag

  if(!ImgPopupMenu.m_startOps){
    return;
  }

  nod.circle_color="#00cc00";
  ImgPopupMenu.m_d3_target_node=nod;
  ImgPopupMenu.m_d3_target_circle=d3.select(this.parentNode).select("circle"); 
  ImgPopupMenu.m_d3_target_circle.style("stroke", nod.circle_color);

  var ss=D3Uti.strKeyValPairs(nod);
  console.log(ss);//JSON.stringify(nod));
  var ret=ImgPopupMenu.clickD3Node(nod);
  //if(true===ret) return;
  for(k in nod){
      //console.log(k+"="+nod[k]);
  }
  
  ImgPopupMenu.m_startOps=null;    

  return;
} ,
cancelOps:function(){
  console.log("cancelOps");
  if( ImgPopupMenu.m_d3_contextmenu_node){
      ImgPopupMenu.m_d3_contextmenu_node.circle_color=null;
      ImgPopupMenu.m_d3_contextmenu_node=null;    
      ImgPopupMenu.m_d3_contextmenu_circle.style("stroke", "#111111");
  };
  if( ImgPopupMenu.m_d3_target_node){
      ImgPopupMenu.m_d3_target_node.circle_color=null;
      ImgPopupMenu.m_d3_target_node=null;    
      ImgPopupMenu.m_d3_target_circle.style("stroke", "#111111");
  };

  ImgPopupMenu.m_startOps=null;    
},

action_ChangeImg:function (){
    var addr=$.targetElement.addr;
    var clikedTreeNode=d3tree.FindTreeChildNodeByKeyValPair("addr",addr);
    if(!clikedTreeNode) {        
        alert("not find: "+addr);
        return false;
    }
    var oldImg=$.targetElement.img;
    var NewImg=prompt("Change Img ID:",oldImg);
    if(!NewImg) return false;
    if(NewImg.length!=5){
        if(!confirm(NewImg+" is not jid img, force to change?")) return false;
    }
    var clikedTreeNode2=d3tree.FindTreeChildNodeByKeyValPair("img",NewImg);
    if(!clikedTreeNode2) {        
        if(!confirm("not find: "+NewImg+"\n\nForce to change?")) return;
    }
    clikedTreeNode.img=NewImg;
    
    OpMenuUti.dout(oldImg+"<=>"+NewImg);    
    $.targetOpMode="";
    $.targetElement=null;  
    return false;//must return false, otherwise bosy will reset position.
},  
action_Delete:function (){
    var addr=$.targetElement.addr;
    var clikedTreeNode=d3tree.FindTreeChildNodeByKeyValPair("addr",addr);
    if(!clikedTreeNode) {        
        alert("not find: "+addr);
        return false;
    }
    if(clikedTreeNode.children == undefined || clikedTreeNode.children.length==0){
        if(!confirm(JSON.stringify(clikedTreeNode)+"\n\nDelete this node?")) return false;
        clikedTreeNode.addr="";      
    }
    else{
        if(!confirm(JSON.stringify(clikedTreeNode)+"\n\nDelete this node and its children?")) return false;
        
        
    }
    
    
    
    
    $.targetOpMode="";
    $.targetElement=null;   
    return false;//must return false, otherwise bosy will reset position.
},  
action_AddNewChildImg:function (){
    var img=prompt("Add New Child Img ID (eg.12345):","");
    if(!img) return false;
    if(img.length!=5){
        if(!confirm("none jid, force to add?")) return false;
    }
    console.log(img);   
    return false;//must return false, otherwise bosy will reset position.
},       
action_ExhangeNodes:function (){
    $('*').css('cursor','move');
    console.log(JSON.stringify($.targetElement));
    
    //d3 graphic changes
    //var d=ImgPopupMenu.m_d3_contextmenu_node;
    //d.circle_color="#ff0000";
    //d3.select(this.parentNode).select("circle").style("stroke", d.circle_color);

    $.targetOpMode="exchange2Nodes"; 
    ImgPopupMenu.targetOpMode="exchange2Nodes";    
    return false;//must return false, otherwise bosy will reset position.
},    
action_SetNewParent:function (){
    $("*").css("cursor","hand");
    console.log(JSON.stringify($.targetElement));
    $.targetOpMode="changeParentNode";
    ImgPopupMenu.targetOpMode="changeParentNode";  
    return false;//must return false, otherwise bosy will reset position.
},


clickD3Node:function (d3nod){
    var name=d3nod.addr;
    console.log("clickD3Node addr="+name);

    //var d3t=new D3Tree(ood3tree);
    var clikedTreeNode=d3tree.FindTreeChildNodeByKeyValPair("addr",name);
    console.log("clikedTreeNode="+JSON.stringify(D3Uti.shallowCopy(clikedTreeNode)));
    //var d3p2p=new D3P2p();
    //d3p2p.(links_p2p,name);
    var ret=false;
    switch( $.targetOpMode ){
        case "exchange2Nodes":
            ret=ImgPopupMenu.OpProcess_NodesExchange_Run(d3nod);
        break;
        case "changeParentNode":
            ret=ImgPopupMenu.OpProcess_SetNewParent_Run(d3nod);
        break;
    }        
    $('*').css('cursor','default');
    $.targetOpMode="";
    $.targetElement=null;  
   
    return ret;
},
OpProcess_NodesExchange_Run:function(d3nod){
    if($.targetOpMode !="exchange2Nodes") return ImgPopupMenu.cancelOps();
    if($.targetElement==null) return ImgPopupMenu.cancelOps();
    var name1=$.targetElement.img;   
    var clikedTreeNode1=d3tree.FindTreeChildNodeByKeyValPair("img",name1); 
    var img1=clikedTreeNode1.img;
    if(img1!=name1) {alert("fatal error");ImgPopupMenu.cancelOps();return;};
    
    var name2=d3nod.img;
    var clikedTreeNode2=d3tree.FindTreeChildNodeByKeyValPair("img",name2); 
    var img2=clikedTreeNode2.img;  
    if(img2!=name2) {return alert("fatal error");ImgPopupMenu.cancelOps();};    
    
    var msg="exchange "+img1+"<img src='"+ D3Uti.ImgFile(img1)+"'></img>";
    msg +="to :"+img2+" <img src='"+ D3Uti.ImgFile(img2)+"'></img>";
    OpMenuUti.appendout(msg);
    
    if(img1==img2) {return alert("can't do same node");ImgPopupMenu.cancelOps();};
    
    var msg="Node1="+name1+"\nNode2="+name2;
    if(!confirm(msg+"\n\n- Sure to switch these 2 nodes?")) {
      ImgPopupMenu.cancelOps();
      return;
    }
    
    //exchange img
    clikedTreeNode1.img=img2;
    clikedTreeNode2.img=img1;
    
    $('*').css('cursor','default');
    $.targetOpMode="";
    $.targetElement=null;  
    update_graphic();
    return true;
},
OpProcess_SetNewParent_Run:function(d3nod){
    if($.targetOpMode !="changeParentNode") return ImgPopupMenu.cancelOps();
    if($.targetElement==null) return ImgPopupMenu.cancelOps();
    var name1=$.targetElement.img;   
    var clikedTreeNode1=d3tree.FindTreeChildNodeByKeyValPair("img",name1); 
    var img1=clikedTreeNode1.img;
    var addr1=clikedTreeNode1.addr;
    
    var name2=d3nod.img;
    var clikedTreeNode2=d3tree.FindTreeChildNodeByKeyValPair("img",name2); 
    var img2=clikedTreeNode2.img;
    var addr2=clikedTreeNode2.addr;
    
    if(addr1==addr2) {return alert("can not be the same addr:"+addr1);ImgPopupMenu.cancelOps();}
    if(img1==img2)   {return alert("can't do same node");ImgPopupMenu.cancelOps();}
    if(name1==name2) {return alert("can not be the same name:"+name1);ImgPopupMenu.cancelOps();}
    
    
    var msg="append "+img1+"<img src='"+ D3Uti.ImgFile(img1)+"'></img>";
    msg +="to new parent:"+img2+ "<img src='"+ D3Uti.ImgFile(img2)+"'></img>";
    OpMenuUti.appendout(msg);

    msg="child: name="+name1+",addr="+addr1;
    msg+="\nNew parent: name="+name2+",addr="+addr2;
    if(!confirm(msg+"\n\n- Sure to change Parent?")) {
      ImgPopupMenu.cancelOps();
      return;
    }
    
    //set addr2 as new parent of addr1.
    d3tree.SetNewParentOfChild(clikedTreeNode2, clikedTreeNode1);
    console.log(d3tree.sout);
    
    $('*').css('cursor','default');
    $.targetOpMode="";
    $.targetElement=null;      
    update_graphic();
    return true;
},

}//PopupMenu        
      