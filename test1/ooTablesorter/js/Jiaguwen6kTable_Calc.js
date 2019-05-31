


function FindSourceOfRoot(imgId){
  var sortedItems=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq(imgId);
  $.each(sortedItems,function(i,ar){
    var jid=ar[0], frq=ar[1];
    JiaguwenTable.Get_Idx

  });
  return strGrid_items(sortedItems,"imgId:"+imgId+", ");
};


JiaguwenTable.WalkParentsRootsRecursively=function(imgIdRoot, rootDict){
    //var sortedItems=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq(imgId);
    //JiaguwenTable.m_Taproot={"m_TaprootAry":{},"TaprootJidFrq":{"jid":0},"uniqTrack",0}; 
      var taproot=JiaguwenTable.m_Taproot;
      if(!taproot.m_TaprootAry[imgIdRoot]){
          taproot.m_TaprootAry[imgIdRoot]=rootDict[imgIdRoot];
      }
      var idx=this.Get_Idx_by_Col_Val(1,imgIdRoot);
      if(idx<0){
        console.error(imgIdRoot+ " cann't find idx.");
        aert("fatal error");
        return;
      }
      
      var jink=JiaguwenTable.DatArry[idx][7];
      var type=JiaguwenTable.DatArry[idx][6];
      var imglst=JgwUti.Get_Ary_fr_ImgListStr(jink);
      switch(imglst.length){
        case 0:
          //console.log(imgIdRoot," has no parents");
          if(!taproot.m_TaprootAry[imgIdRoot]){
            taproot.m_TaprootAry[imgIdRoot]=rootDict[imgIdRoot];
            rootDict[imgIdRoot]=0;
          }
        return;
        case 1:
          var jidParent=imglst[0];//find parent of imgIdRoot as jidParent. 
          if(!taproot.m_TaprootAry[jidParent]){
            var frqParent=rootDict[jidParent];
            taproot.m_TaprootAry[jidParent]=frqParent;
          }
          var iImgIdRootFrq=rootDict[imgIdRoot];
          taproot.m_TaprootAry[jidParent]+=iImgIdRootFrq;

          //reset to 0 after mv up.
          rootDict[imgIdRoot]=0;
          taproot.m_TaprootAry[imgIdRoot]=0;
          
          //console.error(imgIdRoot, jidParent);
          this.WalkParentsRootsRecursively(jidParent, rootDict);          //
        break;
        default:
          //console.log(imgIdRoot," parents root uniq error:"+jink);          
        return;
      }



    //});
};



