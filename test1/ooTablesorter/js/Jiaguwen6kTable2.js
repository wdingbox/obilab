////////////////////////////////////////////////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////



function convert_sorterOutput_2_Beauty(){
	var s=$("#out").val();
	if(s.substr(0,3)==="Jia"){
		return alert("it's alreay convtered.");
	}

	var s2="JiaguwenTable.DatArry=[\n";
	s=s.substr(1);
	s2+=s.replace(/\]\,\[/g, "],\n[");
	$("#out").val(s2+";////Beautified_fr_TablesorterOutput.\n");
};




function gen_tab_all_by_num_root_is(inod){
	var arr=JiaguwenTable.Get_Arry_by_Col_ImgNum({"iCol":7,"NumRangeAry":[inod]})[1];
	//var arr=JiaguwenTable.Get_Arry_by_Col_ImgNum(7,parseInt(inod));
	//var st=gen_table_str(arr);
	gen_table_show(arr);
}


function strGrid_items(sortedItems,scap){
	var stb="<table border='1'><caption>"+scap+"totnum:"+sortedItems.length+"</caption><tr>";
	var idx=0;
	$.each(sortedItems,function(i,ar){
		var img=JgwUti.GenJgwImg(ar[0],", ");
		if(0===i%10){
			stb+="</tr><tr><td>"+(idx++)+"</td>";//
		}
		stb+="<td>"+img+ar[1]+"</td>";
	});
	stb+="</tr></table>";
	return stb;
};
function strGrid_imgAry(imgAry,scap){
	var stb="<table border='1'><caption>"+scap+"totnum:"+imgAry.length+"</caption><tr>";
	var idx=0;
	$.each(imgAry,function(i,jid){
		var img=JgwUti.GenJgwImg(jid,", ");
		if(0===i%10){
			stb+="</tr><tr><td>"+(idx++)+"</td>";//
		}
		stb+="<td>"+img+"</td>";
	});
	stb+="</tr></table>";
	return stb;
};
function _RootFrq(imgId){
	var sortedItems=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq(imgId);
	var ss0=strGrid_items(sortedItems,"imgId:"+imgId+", ");
	return ss0;
};

function _UnreachableList(){
	var unreadList=JiaguwenTable.Get_Ary_Jid_Untouched();
	var stb="<table border='1'><caption>Unused List "+unreadList.length+"</caption><tr>";

	$.each(unreadList,function(i,jid){
		var img=JgwUti.GenJgwImg(jid,", ");
		if(0===i%10){
			stb+="</tr><tr><td>"+(i)+"</td>";//
		}
		stb+="<td>"+img+"</td>";
	});
	stb+="</tr></table>";
	return stb;		
};

function gen_tab_decodedZi(bEmpty){
	
	function getUniqZi(arr){
		var uniqArr=[];
		$.each(arr,function(i,ar){
			var zi=ar[3];
			if(uniqArr.indexOf(zi)>0){

			}else{
				uniqArr.push(zi);
			}
		});
		return uniqArr;
	}
	function genTableStr(arr){
		var idx=0, stb="<table border='1'>";
		$.each(arr,function(i,v){
			stb+="<tr><td>"+(idx++)+"</td><td>"+v+"</td></tr>";
		});
		stb+="</table>";
		return stb;
	}
	function get_outsideOfSrc(uniqZiArr, SrcArr){
		var outside7kziArr=[];
		$.each(uniqZiArr,function(i,zi){
			if(SrcArr.indexOf(zi)<0){
				outside7kziArr.push(zi);
			};
		});	
		return outside7kziArr;	
	}
	function genTableStr_NianFu(NianfuOutsideJgwTableArr){
		var stb="<table border='1'><tr><td>#</td><td>zi</td><td>pinyin</td><td>jid</td><td>flowID</td></tr>";
		var idx=0;
		$.each(NianfuOutsideJgwTableArr,function(i,zi){
			var arr=NianFuChen7kziListInJgw.JgwZiDic[zi];
			stb+="<tr><td>"+(idx++)+"</td>";
			$.each(arr,function(i,v){
				stb+="<td>"+v+"</td>";
			});
			stb+="</tr>";
		});	
		stb+="</table>";
		return stb;	
	}
	function genNianfu_for_6kJgw(NianfuOutsideJgwTableArr){
		var ret={};
		$.each(NianfuOutsideJgwTableArr,function(i,zi){
			var arr=NianFuChen7kziListInJgw.JgwZiDic[zi];
			ret[zi]=arr;
		});	
		return ret;	
	}


	var arr=JiaguwenTable.Get_Arry_by_Colval_cbFunc(3,function(v){if(v.length==0) return bEmpty;});
	var uniqZiArr=getUniqZi(arr);

	gen_table_show(arr);

	var s=genTableStr(uniqZiArr);
	$("#base").append(s);

	// compare to get zi outside of 7k.
	var outside7kziArr=get_outsideOfSrc(uniqZiArr, Pinyin7kziUti.GetUniqArr());
	s=genTableStr(outside7kziArr);
	$("#base").append("<hr><a>outside 7kzi</a>"+s);

	//compare to  chenfunian 7k to this table.
	var NianfuOutsideJgwTableArr=get_outsideOfSrc(NianFuChen7kziListInJgw.getCharArr(),uniqZiArr);
	s=genTableStr_NianFu(NianfuOutsideJgwTableArr);
	$("#base").append("<hr><a>list of chenfunian outside jgw-table</a>"+s);

	var nianfufor7kjgw=genNianfu_for_6kJgw(NianfuOutsideJgwTableArr);
	var jss=JSON.stringify(nianfufor7kjgw);
	$("#out").val(jss);
}


