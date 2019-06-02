
var JgwUti={
  GetImgIdFrSrc:function(imgsrc){
    var n = imgsrc.match(/([^\.\/]+)[\.]/i);
    var imgid=n?n[1]:"0";
    return imgid;
  },//////////////////////////////////////////////////////
  GenJgwImg:function(id, sComma){
    //  src="../../../../___bigdata/___compact/___solid/odb/tbi/img/jgif/62880.gif"
    var src="../../../../___bigdata/___compact/___solid/odb/tbi/img/jgif/"+id+".gif";
    var src=`../../../../../bitbucket/wdingsoft/obidat/imgtbi/tbi/img/jgif/${id}.gif`;
    return `<div class='mi'><a>${id}${sComma}</a><br><img src='${src}'/></div>`;
  },/////////////////////////////////////////////
  GenHieroImg:function(id, sComma){
     //src=../../../../___bigdata/___compact/___solid/odb/hiero/ccer-h/J26.gif
    var src="../../../../___bigdata/___compact/___solid/odb/hiero/ccer-h/"+id+".gif";
    var src=`../../../../../bitbucket/wdingsoft/obidat/imghiero/hiero/jpegHiero/${id}.jpg`;
    return `<div class='mi'><a>${id}${sComma}</a><br><img src='${src}'/></div>`;
  },////////////////////////////////////////////
  Get_Ary_fr_ImgListStr : function (strList){
    var compoundArr=strList.split(",");
    var retArr=[];
    $.each(compoundArr,function(i,v){
      var v2=$.trim(v);
      if(v2.length>0){
        retArr.push(v2);
      }
    });
    return retArr;
  },////////////////////////////////////////////////////////
  Get_Ary_fr_ImgListStr_UniqSorted : function (strList){
    var retArr=JgwUti.Get_Ary_fr_ImgListStr(strList);
    var uniqArr = [];
    $.each(retArr, function(i,str){
      if(uniqArr.indexOf(str)<0){
        uniqArr.push(str);
      };
    });
    uniqArr.sort();
    return uniqArr;
  },///////////////////////////////////////////////////
  Get_Htm_jink:function(str){
    var arr=JgwUti.Get_Ary_fr_ImgListStr(str);
    var ss="";
    $.each(arr,function(i,v){
      v=$.trim(v);
      if(v.length>0){
        ss+=JgwUti.GenJgwImg(v, ",");
      };
    });
    return ss;
  },////////////////////////////////////////////
  Get_Htm_jtoh:function(str){
    arr=JgwUti.Get_Ary_fr_ImgListStr(str);
    var ss="";
    $.each(arr,function(i,v){
      v=$.trim(v);
      if(v.length>0){
        ss+=JgwUti.GenHieroImg(v, ",");
      };
    });
    return ss;
  },////////////////////////////////////////////





  paddingStr:function(str,len){
    if(str.length>=len){
      return str.substr(0,len);
    }
    while(str.length<len) str=" "+str;
    return str;
  },



  ARowDiffArr: function(arr1,arr2){
      if( !arr1 || !arr2){
        console.assert("err");
        return [];
      }
      var diffArr=[];
      for(var i=1;i<arr1.length;i++){
        if(arr1[i] != arr2[i]){
          diffArr.push(i);
        };
      };
      return diffArr;
  },  









  Get_Ary_fr_Arry_by_Colval:function(iColidx, sColval, Arr){
      for(var i=0;i<Arr.length;i++){
        if(sColval===Arr[i][iColidx]){
          return Arr[i];
        }
      }
      return [];
  }, 

  Get_Idx_Ary_fr_Arry_by_Colval:function(iColidx, sColval, Arr){
      for(var i=0;i<Arr.length;i++){
        if(sColval===Arr[i][iColidx]){
          return i;
        }
      }
      return -1;
  }, 
  GetUniqDatArr:function(arry){
    var retArr=[];
    var uniq=[];
    $.each(arry,function(i, ar){
      var key=ar.join();
      if( uniq.indexOf(key)<0){
        uniq.push(key);
        retArr.push(ar);
      };
    });
    return retArr;
  },





  Copy_Ary:function(arrSrc, arrDes){
    if(!arrDes){
      return alert("arr Dest fatal error.");
    }
    for(var i=0;i<arrSrc.length;i++){
      arrDes[i]=""+arrSrc[i];
    };
  },
  clone_ary:function(arrSrc){
    var ary=new Array();
    this.Copy_Ary(arrSrc, ary);
    return ary;
  },


  UpdateAnyDiffDatArr:function(datArrSrc, datArrDest ){
    var diffOrigArr=[];
    for(var m=0; m<datArrSrc.length; m++){
      var jid=datArrSrc[m][1];
      var idx=JgwUti.Get_Idx_Ary_fr_Arry_by_Colval(1,jid,datArrDest);
      if(idx>=0){
        var OrigArr=JgwUti.clone_ary(datArrDest[idx]);
        diffOrigArr.push(OrigArr);
        JgwUti.Copy_Ary(datArrSrc[m], datArrDest[idx]);
      };
    };
    return diffOrigArr;
  },/////////////////////////////////////////////////////////////////////////

AnyArry_CompareTo_Stdrry:function (datArr, StdArr){
  if(!StdArr){
    return alert("Std JidaArry is null.");
  }

  var changedDatArr=[];
  var changedColArr=[];
  for(var k=0;k<datArr.length;k++){
    var Jidrow=JgwUti.Get_Ary_fr_Arry_by_Colval(1, datArr[k][1], StdArr);
    if( null===Jidrow || Jidrow.length==0){
        Jidrow=this.m_defaultEmptyRow;
    }
    var diffArr=JgwUti.ARowDiffArr(datArr[k], Jidrow);
    if(diffArr.length>0){
      changedDatArr.push(datArr[k]);
      changedDatArr.push(Jidrow);
      changedColArr.push(diffArr);
    }
  }
  return {"changedRowArry":changedDatArr, "changedColArry":changedColArr};
},



  varify_two_data_in_general:function(aarry1, aarry2){
    var n1=aarry1.length,n2=aarry2.length;
    var ret="";
    if( n1 != n2){
      ret+="data_size_different="+n1+":"+n2;
    }
    var n=n1<n2?n1:n2;
    RowDiffCount=0;
    FrqDiffCount=0;
    IdxDiffCount=0;
    JidDiffCount=0;
    for(var i=0;i<n;i++){
      var diffarr=JgwUti.ARowDiffArr(aarry1[i], aarry2[i]);
      if(diffarr.length>0){
        RowDiffCount++;
      }
      if(aarry1[i][4] != aarry2[i][4]){
        FrqDiffCount++;
      }
      if(aarry1[i][0] != aarry2[i][0]){
        IdxDiffCount++;
      }
      if(aarry1[i][1] != aarry2[i][1]){
        JidDiffCount++;
      }
    }
    ret+="\nRowDiffCount="+RowDiffCount;
    ret+="\nFrqDiffCount="+FrqDiffCount;
    ret+="\nIdxDiffCount="+IdxDiffCount;
    ret+="\nJidDiffCount="+JidDiffCount;
    console.log(ret);
    alert(ret);

  },

  Get_Ary_SortedItem_Jid_Frq:function(JidFrqDict){
    // Create items array
    var items = Object.keys(JidFrqDict).map(function(key) {
        return [key, JidFrqDict[key]];
    });
    
    // Sort the array based on the second element
    items.sort(function(first, second) {
        return second[1] - first[1];
    });
    return items;
  },
};
/////////////////////////////////////////////////////////////


































/////////////////////////////////////////////////////////////////////////

var JiaguwenTable={


  Init:function(){
    this.init_ColsMaxLenArr();
    this.init_nOBIsize();
    //this.m_BakupForChangedAary=[];

    this.____onetime_work();
    //this._ChangeFrqIdxedTableToJidSortedIdxTable();
  },
  init_nOBIsize:function(){
    var iTot=0;
    $.each(this.DatArry,function(i,arr){
      var sfrq=$.trim(arr[4]);
      if(sfrq.length===0){
        sfrq="0";
      }
      iTot+=parseInt(sfrq);
    });
    this.m_nOBIsize=iTot;

    this.m_defaultEmptyRow=[];
    for(var i=0; i<this.DatArry[0].length;i++){
      this.m_defaultEmptyRow[i]="";
    }
  },

  getMaxLenOfCol:function(iCol){
    var iMax=-1;
    $.each(this.DatArry,function(i,arr){
      if(arr[iCol].length>iMax){
        iMax=arr[iCol].length;
      };
    });
    return iMax;
  },


  init_ColsMaxLenArr:function(){
    ////////////// col: 0,1,2,3,4,5, 6, 7,  8, 9, 10, 11, 12,13,14,15.
    this.ColsMaxLenArr=[4,5,1,1,5,30,1, 43, 0, 0, 0,  0,  1, 1, 1, 1];
    var _This=this;
    $.each([8,9,10,11],function(n,icol){
      _This.ColsMaxLenArr[icol]=_This.getMaxLenOfCol(icol);
    });
  },
  ____onetime_work:function(){
    function ____onetime_ChangeFrqIdxedTableToJidSortedIdxTable(){
      var jidxArr=this.Get_Arry_Sorted_by_Col_ascend(1);
      for(var i=0;i<jidxArr.length;i++){
          jidxArr[i][0]=""+i;
      };
      this.DatArry=jidxArr;
    };
    function ____onetime_Change_col6_to_empty(){
      for(var i=100;i<this.DatArry.length;i++){
          this.DatArry[i][6]="";
      };
    };
  },




//////////////////////////////////////////////////////////
m_EditData:{
    "m_EditRecords"  :{},
    "m_EditHistory"  :[],

    GetChangedData:function(){
          this.ChangedDatArr=[];
          this.OrigiDatArr=[];
          this.CompairedDatArr=[];
          var _this=this;
          $.each(this.m_EditRecords,function(jid,dict){
                var curRow=JiaguwenTable.DatArry[dict.idx];
                var diffArr1=JgwUti.ARowDiffArr(curRow, dict.LastUpdate);
                var diffArr2=JgwUti.ARowDiffArr(curRow, dict.OrigRow);
                if( diffArr1.length>0 || diffArr2.length>0 ){
                  _this.ChangedDatArr.push(curRow);
                  _this.OrigiDatArr.push(dict.OrigRow);
                  _this.CompairedDatArr.push(curRow);
                  _this.CompairedDatArr.push(dict.OrigRow);
                  
                };
          });
          return {"ChangedDatArr":this.ChangedDatArr,"OrigiDatArr":this.OrigiDatArr,"CompairedDatArr":this.CompairedDatArr};
      },
    Get_RowAry_fr_Cur:function(jid){
          var editData=JiaguwenTable.m_EditData;
          var idx=JgwUti.Get_Idx_Ary_fr_Arry_by_Colval(1, jid, JiaguwenTable.DatArry);
          if(idx<0) alert("fatal error");
          var currAr = JgwUti.clone_ary(JiaguwenTable.DatArry[idx]);
          if(!editData.m_EditRecords[jid]){//use backup original data.
              editData.m_EditRecords[jid]={"idx":idx, "OrigRow":new Array(),"LastUpdate":new Array()};
              JgwUti.Copy_Ary(currAr,editData.m_EditRecords[jid]["OrigRow"]);
              JgwUti.Copy_Ary(currAr,editData.m_EditRecords[jid]["LastUpdate"]);
          }
          return currAr;
      },
    Update_CurDatArry_by_aRow:function(chagnedARow){
          var jid=chagnedARow[1];
          var editData=JiaguwenTable.m_EditData;
          var lastAr=JgwUti.clone_ary(chagnedARow);
          var idx=JgwUti.Get_Idx_Ary_fr_Arry_by_Colval(1, jid, JiaguwenTable.DatArry);
          if(!editData.m_EditRecords[jid]){//must backup orig before update.
            var currAr = JgwUti.clone_ary(JiaguwenTable.DatArry[idx]);
            editData.m_EditRecords[jid]={"idx":idx, "OrigRow":new Array(),"LastUpdate":new Array()};
            JgwUti.Copy_Ary(currAr,editData.m_EditRecords[jid]["OrigRow"]);
            JgwUti.Copy_Ary(currAr,editData.m_EditRecords[jid]["LastUpdate"]);            
          }
          JgwUti.Copy_Ary(chagnedARow, JiaguwenTable.DatArry[idx]);
          editData.m_EditRecords[jid]["LastUpdate"]=chagnedARow;
          editData.m_EditHistory.push(jid);
      },
  },
//////////////////////////////////////////////////////////









  ///////////////////////////////////////////////////
  Get_Dict_Imgid_Frq_by_Col:function(iCol,sImgId=""){
    var retDic={};
    $.each(this.DatArry,function(i,ar){
      var imgAr=JgwUti.Get_Ary_fr_ImgListStr(ar[iCol]);//compounds
      var idx=imgAr.indexOf(sImgId);
      if(sImgId.length==0 || idx>=0) {
        $.each(imgAr,function(i,imgId){
          if( retDic[imgId] ){
            retDic[imgId]+=1;
          }
          else{
            retDic[imgId]=1;
          }
        });        
      }

    });   
    return retDic;
  },/////////////////////////////////
  Get_Ary_Items_Sorted_Root_Frq:function(imgid=""){
    var dict=this.Get_Dict_Imgid_Frq_by_Col(7, imgid);
    var sortedItems=JgwUti.Get_Ary_SortedItem_Jid_Frq(dict);
    return sortedItems;
  },////////////////////////////////////////////////////////
  Get_Ary_Jid_Untouched:function(){
    var UnreachableJidList=[];
    var dict=this.Get_Dict_Imgid_Frq_by_Col(7);
    var jids=Object.keys(dict);
    console.log("root size "+jids.length);
    $.each(this.DatArry, function(i, ar){
      var jid=$.trim(ar[1]);
      var co7=$.trim(ar[7]);
      if( co7.length>0) return ; 
      if( !dict[jid] ){
        UnreachableJidList.push(jid);
      }
    });
    return UnreachableJidList;
  },
  Get_Arry_Untouched:function(){
    var retArry=[];
    var dict=this.Get_Dict_Imgid_Frq_by_Col(7);
    var rootsAry=Object.keys(dict);
    var arry=this.Get_Arry_by_Col_ImgNum({"iCol":7, "NumRangeAry":[0]})[1];
    for(var i=0;i<arry.length;i++){
      var jid=arry[i][1];
      if(rootsAry.indexOf(jid)<0){
        retArry.push(arry[i]);
      }
    }
    return retArry;
  },
  Get_Arry_in_Col_Containing_imgid:function(icol, imgId){
    imgId=$.trim(imgId);
    var aarr=[];
    $.each(this.DatArry, function(i, ar){
      var mid=$.trim(ar[1]);
      var co7=$.trim(ar[icol]);
      var imglst=JgwUti.Get_Ary_fr_ImgListStr(co7);
      if( imglst.indexOf(imgId)>=0) {
        aarr.push(ar);
      }
    });
    return aarr;
  },









  /////////////////////////////////////////////////////////////
  paddingCol:function(arr,iCol){
    return JgwUti.paddingStr(arr[iCol], this.ColsMaxLenArr[iCol]);
  },
  Get_Ary_SortedIdx_By_Col:function(iCol, ascend=true){ 
    var sortColId=[];
    var _This=this;
    $.each(this.DatArry,function(i,arr){
      var sortkey=_This.paddingCol(arr,iCol)+"@"+_This.paddingCol(arr,0);
      sortColId.push(sortkey);
    });
    sortColId.sort();
    if(!ascend) sortColId.reverse();

    var iretArr=[];
    $.each(sortColId,function(i,str){
        var sp=str.split("@");
        iretArr.push(parseInt(sp[1]));//ForJidSortedIndexDatArr-1);
    });
    return iretArr;
  },
  Get_Arry_Sorted_by_Col_ascend:function (iCol, ascend=true){
    var sortedIdxArr=this.Get_Ary_SortedIdx_By_Col(iCol, ascend);
    var sortedDatArr=[];
    var _This=this;
    $.each(sortedIdxArr,function(i,idx){
      sortedDatArr.push(_This.DatArry[idx]);
    });
    return sortedDatArr;
  },


  Get_Arry_by_Colval_cbFunc:function(iCol, cbFunc){
    var RetArr=[];
    $.each(JiaguwenTable.DatArry,function(i,arr){
      var v=$.trim(arr[iCol]);
      if( cbFunc(v)===true ){
        RetArr.push(arr);
      };
    });
    return RetArr;
  },
  Get_TotFrq:function(sortedItems){
    var totFrq=0;
    //var sortedItems=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq();
    for(var i=0;i<sortedItems.length;i++){
      var jid=sortedItems[i][0], frq=sortedItems[i][1];
      totFrq+=frq;
    }
    return totFrq;
  },
  Get_Arry_by_sortedRootsFrq:function(sortedItems){
    var RetArr=[], totFrq=0;
    //var sortedItems=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq();
    for(var i=0;i<sortedItems.length;i++){
      var jid=sortedItems[i][0], frq=sortedItems[i][1];
      totFrq+=frq;
      var ar=JgwUti.Get_Ary_fr_Arry_by_Colval(1,jid, this.DatArry);
      RetArr.push(ar);
    }
    return RetArr;
  },
  Get_Arry_by_Col_ImgNum:function(parm){
    var RetArr1=[],RetArr0=[];
    for(var i=0; i<this.DatArry.length;i++){//,function(i,arr){
      var ary=this.DatArry[i];
      var v=ary[parm.iCol];
      var inods=JgwUti.Get_Ary_fr_ImgListStr(v);
      if( parm.NumRangeAry.indexOf(inods.length)>=0){
        RetArr1.push(ary);
      }else {
        RetArr0.push(ary);
      };
    };//for
    return [RetArr0,RetArr1];
  },




Get_Ui_Col_Checkbox_States:function(){
  var nColCnt=16;
  if(this.DatArry){
    nColCnt=this.DatArry[0].length;
  }
  this.m_CheckedColIdxArry=[];
  if(!this.m_chekbox_Id_BaseName){
    for(var i=0;i<nColCnt;i++){
      this.m_CheckedColIdxArry.push(i);
    }     
    return; 
  }


  for(var i=0;i<nColCnt;i++){
    var ischek = $("#"+this.m_chekbox_Id_BaseName+i).is(":checked");
    if(ischek){
      this.m_CheckedColIdxArry.push(i);
    };
  };
  return this.m_CheckedColIdxArry; 
},












//  push_into_BakupForChangedAary_by_an_original_row:function(//origirow){
//    //keep original data for comparison.
//        var jid=origirow[1];
//        var idx=JgwUti.Get_Idx_Ary_fr_Arry_by_Colval(1,jid, //JiaguwenTable.m_BakupForChangedAary);
//        if(idx<0){
//          var dup=JgwUti.clone_ary(origirow);
//          JiaguwenTable.m_BakupForChangedAary.push(dup);
//        }; 
//  },/////////////////////////////////////////////////////
//  push_into_BakupForChangedAary_tobeChanged_original_datarry://function(OrigAarr){
//    //keep original data for comparison.
//      $.each(OrigAarr,function(i, oarr){
//          JiaguwenTable.//push_into_BakupForChangedAary_by_an_original_row(oarr)//;
//      });   
//  },/////////////////////////////////////////////////////
//  updateDatArry:function(datArrSrc){
//    if(0===datArrSrc.length){
//      return alert("src is empty. no update.");
//    }
//    var OrigAarr=JgwUti.UpdateAnyDiffDatArr(datArrSrc, this.DatArry);
//    this.push_into_BakupForChangedAary_tobeChanged_original_datarry(OrigAarr);
//  },//////////////////////////////////////////////////////////
//  getChangeComparisonDatAary:function(){
//    var ret=JgwUti.AnyArry_CompareTo_Stdrry(this.DatArry, this.//m_BakupForChangedAary);
//    return ret;
//  },/////////////////////////////////////////////////////////////////////




  
  
  ///////////////////////////////////////////
  ClickImg2Replace_init:function(){
    this.m_bImgReplaceStart=true;
    this.m_ToBeReplacedIdxArry=[];
    this.m_ToBeReplacedImg="";
    alert("Please click first img to be replaced, then click second one to replace it.");
  },
  ClickImg2Replace_pickImg:function(iCol, ImgId){
    if( [7,8].indexOf(iCol)<0 ){
      return alert("erro iCol:"+iCol);
    }
    if( true != this.m_bImgReplaceStart){
      return;
    }
    if(0===this.m_ToBeReplacedIdxArry.length){///First clicked Img
      this.m_ToBeReplacedIdxArry=this.get_IdxArry_That_Contain_ImgId(iCol,ImgId);
      if(0===this.m_ToBeReplacedIdxArry.length){
        return alert(ImgId +" does not exist in col:"+iCol+".\nPlease try again.");
      }
  
      var msg=this.m_ToBeReplacedIdxArry.length  + "  rows with  "+ ImgId + " will be replaced.";
      if(confirm(msg)){
        this.m_ToBeReplacedImg=ImgId;
        return;
      }
      
      this.m_bImgReplaceStart=false;
      this.m_ToBeReplacedIdxArry=[];
      this.m_ToBeReplacedImg="";
    }
    else{//Second clicked img
      if(!confirm("to replace them by "+ImgId+" ?")) return;
      this.to_replace_datarry_with_imdid(iCol,ImgId);
  
      this.m_ToBeReplacedIdxArry=[];
      this.m_bImgReplaceStart=false;
    }
  },//////////////////////////////
  get_IdxArry_That_Contain_ImgId:function(iCol, imgId){ 
      var idxAr=[];
      for (var i=0; i<this.DatArry.length;i++){
        var imgstr=this.DatArry[i][iCol];
        var imglst=JgwUti.Get_Ary_fr_ImgListStr(imgstr);
        var idx=imglst.indexOf(imgId);
        if(idx>=0){
          idxAr.push(i);
        }
      };
      return idxAr;
  },//////////////////////////////////////////
  to_replace_datarry_with_imdid:function(iCol, imgId){ 
      for(var i=0;i<this.m_ToBeReplacedIdxArry.length;i++){
        var idx=this.m_ToBeReplacedIdxArry[i];
        var imgstr=this.DatArry[idx][iCol];
        var imglst=JgwUti.Get_Ary_fr_ImgListStr(imgstr);
        var imglid=imglst.indexOf(this.m_ToBeReplacedImg);
        imglst[imglid]=imgId;
        imgstr=imglst.join(",");
  
        this.push_into_BakupForChangedAary_by_an_original_row(this.DatArry[idx]);//bakup before change.
        this.DatArry[idx][iCol]=imgstr;
      }
  },/////////////////////////////////////////
  
  Get_Arry_by_Anywhere_Str:function(str){
    var arry=[];
    for(var i=0;i<this.DatArry.length;i++){
      var ar=this.DatArry[i];
      var ss=ar.join();
      if(ss.indexOf(str)>=0){
        arry.push(ar);
      }
    }
    return arry;
  },






  //////////////////////
  Get_Idx_by_Col_Val:function(iCol, val){
    return JgwUti.Get_Idx_Ary_fr_Arry_by_Colval(iCol, val, JiaguwenTable.DatArry);
  },
  Get_Row_by_Col_Val:function(iCol, val){
    var idx=JgwUti.Get_Idx_Ary_fr_Arry_by_Colval(iCol, val, JiaguwenTable.DatArry);
    return this.DatArry[idx];
  },

  GetFirstJidInCatalog:function(jid){
    var ret="";
    $.each(JiaguwenTable.Catalog,function(catname,dict){
      var jidsary=Object.keys(dict);
      var firstjid=jidsary[0];
      if(jidsary.indexOf(jid)>=0){
        ret=firstjid;
        return false;
      }
    });
    return ret;
  },

};









