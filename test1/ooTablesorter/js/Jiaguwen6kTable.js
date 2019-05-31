
var sel_option_function={
"optgroup------------all":function(){},
"all_default":function(){
	var st=gen_table_str(JiaguwenTable.DatArry);
	show2Table("",st);
},
"all_OBI_frq":function(){
	show2Table("sort 4",gen_table_str(JiaguwenTable.Get_Arry_Sorted_by_Col_ascend(4,false)));
},
"all_by_sorted_col_1":function(){
	show2Table("sort 1",gen_table_str(JiaguwenTable.Get_Arry_Sorted_by_Col_ascend(1)));
},
"col_7_root_num_0":function(){
	gen_tab_all_by_num_root_is(0);
},
"col_7_root_num_1":function(){
	gen_tab_all_by_num_root_is(1);
},
"col_7_root_num_2":function(){
	gen_tab_all_by_num_root_is(2);
},
"col_7_root_num_3":function(){
	gen_tab_all_by_num_root_is(3);
},
"col_7_root_num_4":function(){
	gen_tab_all_by_num_root_is(4);
},
"col_7_root_num_5":function(){
	gen_tab_all_by_num_root_is(5);
},
"col_7_root_num_6":function(){
	gen_tab_all_by_num_root_is(6);
},
"root_num_all_in_one_page":function (){
	var st="", itot=0;
	for(var i=10;i>=0;i--){
		var aarr=JiaguwenTable.Get_Arry_by_Col_ImgNum({"iCol":7,"NumRangeAry":[i]})[1];
		itot+=aarr.length;
		st+="<hr>root number="+i+", tot="+itot;
		st+=gen_table_str(aarr);
	}
	show2Table("all in one page",st);
},
"root_num_all_in_one_table":function(){
	var st="", itot=0;
	var aarr=JiaguwenTable.Get_Arry_by_Col_ImgNum({"iCol":7,"NumRangeAry":[1,2,3,4,5,6]})[1];
	itot+=aarr.length;
	st+="root tot="+itot;
	st+=gen_table_str(aarr);

	show2Table("all in one table",st);	
},
"catalog":function(){
	var s="";
	$.each(JiaguwenTable.Catalog,function(kname,dic){
		var ary=Object.keys(dic);
		s+=kname+strGrid_imgAry(ary,kname+",");
	});
	$("#base").html(s);
},
//////////////////////////
//////////////////////////
//////////////////////////
"optgroup------------Calculation":function(){},
"Untouched_grid":function (){
	var stb=_UnreachableList();
	$("#base").html(stb).find("img").bind('click',Img_click).removeClass("mi").addClass("bigimg");
},
"Untouched_table":function (){
	var arry=JiaguwenTable.Get_Arry_Untouched();
	gen_table_show(arry);	
},
"Table_Roots":function (){
	var sortedItems=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq();
	var arry=JiaguwenTable.Get_Arry_by_sortedRootsFrq(sortedItems);
	gen_table_show(arry);	
},
"Grid_Roots":function (){
	
	var stb=_RootFrq("");
	stb+="<hr/>";
	

	//show zipf curve line;
	var sortedItems=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq("");
	var sfrqtxt="\"JgwR\":[\n";
	for(var i=0;i<sortedItems.length;i++){
		var frq=sortedItems[i][1];
		var jid=sortedItems[i][0];
		var row=JiaguwenTable.Get_Row_by_Col_Val(1,jid);
		var words=row[10];
		function getword(words){
			var ar=words.split(";");
			var ar2=[];
			$.each(ar,function(i,v){
				if(v.length>0){
					ar2.push(v);
				}
			});
			var word="";
			if(ar2.length===1) word=ar2[0];
			else{
				$.each(ar2,function(i,v){
					if(v.indexOf("(")>=0){
						word=v;
					}
				});
			}
			if(word.length===0||"eng"===word) word=jid;
			if(word.indexOf("(")>=0){
				word=word.substr(1,word.length-2);
			}
			word=word.replace(/\s/g,"");
			return word;
		};//function
		var word=getword(words);
		sfrqtxt+=""+frq+ " "+word+"\n";
	}
	var totFrq=JiaguwenTable.Get_TotFrq(sortedItems);

	show2grid("totFrq="+totFrq+"<hr>"+stb);
	$("#out").val(sfrqtxt);

	//$("#base").html(stb).find("img").bind('click',Img_click).removeClass("mi").addClass("bigimg");
},
"Grid_Taproots":function(){
	//var sortedItems=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq("");
	var rootDict=JiaguwenTable.Get_Dict_Imgid_Frq_by_Col(7, "");//all roots.
	var sortedItems=JgwUti.Get_Ary_SortedItem_Jid_Frq(rootDict);

	var ss0=strGrid_items(sortedItems,"imgId:"+", ");

	JiaguwenTable.m_Taproot={"m_TaprootAry":{},"TaprootJidFrq":{"jid":0},"uniqTrack":0}; 	
	JiaguwenTable.m_parentsRoot={};
	JiaguwenTable.m_TaprootAry=[];
	var uniqTest=[];
	for(var i=0;i<sortedItems.length;i++){
		var jid=sortedItems[i][0];
		if(!uniqTest[jid]){
			uniqTest[jid]=0;
		}else{
			alert(jid);
		}
		JiaguwenTable.WalkParentsRootsRecursively(jid,rootDict);
	}

	var sortedItems1=JgwUti.Get_Ary_SortedItem_Jid_Frq(JiaguwenTable.m_Taproot["m_TaprootAry"]);
	var ss1=strGrid_items(sortedItems1,"after recursevely taproot sortedItems1:"+", ");


	var JidFrq2=JiaguwenTable.m_Taproot["m_TaprootAry"];
	$.each(JidFrq2,function(jid,frq){
		var firstJid=JiaguwenTable.GetFirstJidInCatalog(jid);
		if( firstJid.length>0){
			JidFrq2[firstJid]+=frq;
			JidFrq2[jid]=0;
		}
	});	
	var sortedItems2=JgwUti.Get_Ary_SortedItem_Jid_Frq(JidFrq2);
	var ss2=strGrid_items(sortedItems2,"after merge catalog sortedItems2:"+", ");
	//var ss2=strGrid_imgAry(Object.keys(JiaguwenTable.m_TaprootAry),"after merge classification,");


	var JidFrq3={};
	$.each(JidFrq2,function(jid,frq){
		if(JiaguwenTable.GetFirstJidInCatalog(jid)===""){
			JidFrq3[jid]=frq;
		}
	});
	var sortedItems3=JgwUti.Get_Ary_SortedItem_Jid_Frq(JidFrq3);
	var ss3=strGrid_items(sortedItems3,"After Remove Catalog,");

	show2grid(ss0+"<hr>"+ss1+"<hr>"+ss2+"<hr>"+ss3);
},
"Grid_Roots_friends":function (){
	var stb=_RootFrq("");
	stb+="<hr/>";
	var ar=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq();
	for(var i=0;i<ar.length;i++){
		var jid=ar[i][0];
		stb+="<hr/>Friend of "+jid;
		stb+=_RootFrq(jid);
	}
	show2grid(stb);
	//$("#base").html(stb).find("img").bind('click',Img_click).removeClass("mi").addClass("bigimg");
},
"Grid_Roots_products":function (){
	//get list of a root in colm7 mapping colm1.
	var stb=_RootFrq("");
	stb+="<hr/>";	
	var ar=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq();
	for(var i=0;i<ar.length;i++){
		var rootjid=ar[i][0];
		var rowArr=JiaguwenTable.Get_Arry_in_Col_Containing_imgid(7, rootjid);
		var jidVarItemAry=[];
		$.each(rowArr,function(i,row){
			var jidvariation=row[1];
			jidVarItemAry.push([jidvariation,1]);
		});
		stb+=strGrid_items(jidVarItemAry,"rootjid:"+rootjid+", ");
	}
	show2grid(stb)
	//$("#base").html(stb).find("img").bind('click',Img_click).removeClass("mi").addClass("bigimg");
},
"Grid_Roots_variations":function (){
	//get list of a root in colm7 mapping colm1.
	var stb=_RootFrq("");
	stb+="<hr/>";	
	var ar=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq();
	var arr1=JiaguwenTable.Get_Arry_by_Col_ImgNum({"iCol":7,"NumRangeAry":[1]})[1];
	for(var i=0;i<ar.length;i++){
		var rootjid=ar[i][0];
		var rootFrq=ar[i][1];
		//var rowArr=JiaguwenTable.Get_Arry_in_Col_Containing_imgid(7, rootjid);
		var jidVarItemAry=[];
		$.each(arr1,function(i,row){
			var jidvariation=row[1];
			var jinkstr=row[7];
			var jidary=JgwUti.Get_Ary_fr_ImgListStr(jinkstr);
			if(jinkstr.indexOf(rootjid)>=0){
				jidVarItemAry.push([jidvariation,1]);
			}
			
		});
		var imgrootjid=JgwUti.GenJgwImg(rootjid,"");
		stb+="<hr/>";
		stb+=strGrid_items(jidVarItemAry,"rootjid:"+imgrootjid+", "+rootjid+",");
	}
	show2grid(stb);
	//$("#base").html(stb).find("img").bind('click',Img_click).removeClass("mi").addClass("bigimg");
},


//////////////////////////
//////////////////////////
//////////////////////////
"optgroup------------Click":function(){},
"gen_tab_with_root_Hilighted":function (){
	var elems=$("#imgSelHolder").find(".hilimg");
	if(elems.length===0){
		return alert("Please hilight a img in img hodler to gen table.")
	}
	var src=elems.attr("src");
	var jid=JgwUti.GetImgIdFrSrc(src);

	var rowArr=JiaguwenTable.Get_Arry_in_Col_Containing_imgid(7, jid);
	gen_table_show(rowArr);
},
"ReplaceImgByPickup":function(){
	JiaguwenTable.ClickImg2Replace_init();
},

//////////////////////////
//////////////////////////
//////////////////////////
"optgroup------------Edit":function(){},
"edi__UpdateData":function(){
	var ret=UpdateData_by_contenteditable_td();
	var st="";
	$.each(ret.ChangedDatArr,function(i,arr){
		st+=jsonarr2sorterOutput(arr);
	});
	st+="\n";
	//st+="////CurrentlyUsedData\n";
	$("#out").val(st);
},
"edi_UndoLast":function(){
	//edi_UpdateData(true);
},
"edi_UpdateChangeCompariosn":function(){
	if(!confirm("to show diff will lost current change. Continue?")) return;

	var ret1=UpdateData_by_contenteditable_td();
	var ret=JgwUti.AnyArry_CompareTo_Stdrry(ret1.ChangedDatArr, ret1.OrigiDatArr);

	//alert();
	var str="\n";
	$.each(ret.changedRowArry,function(i,arr){
		str+=jsonarr2sorterOutput(arr);
	});
	str+="\n";
	$("#out").val(str);
	//return str;	

	var st=gen_table_str(ret.changedRowArry);
	show2Table("changedRowsArry", st);
	colorizeChangedCell(ret.changedColArry);

	
},

//////////////////////////
//////////////////////////
//////////////////////////
"optgroup------------Popup":function(){},

"goto_HeadCompare":function(){
	window.open("Jiaguwen6kTable_EdiArry_Compare2DatArry.htm");
	window.open("JiaguwenTableJid6186_JidaArry_Compare2DatArry.htm");
}, 
"d3":function(){
	window.open("http://localhost/~weiding//weidroot/weidroot_2017-01-06/app/jit/test1/ood3/MobilePatentSuits/home.htm");
},
"d3_tester":function(){
	window.open("http://localhost/~weiding//weidroot/weidroot_2017-01-06/app/jit/test1/ood3/MobilePatentSuits/home_tester.htm");
},
"d3_tutorial":function(){
	window.open("http://localhost/~weiding//weidroot/weidroot_2017-01-06/app/jit/test1/ood3/MobilePatentSuits/home_tutorial.htm");
},

//////////////////////////
//////////////////////////
//////////////////////////
"optgroup------------Tablesorter":function(){},

"init_tablesorter":function(){
	init_tablesorter();
}, 
//////////////////////////
//////////////////////////
//////////////////////////
//////////////////////////
//////////////////////////
//////////////////////////
"optgroup------------Text":function(){},

"output_CurrentlyUsed_DatArry":function() {
	var st="JiaguwenTable.DatArry=[\n";
	$.each(JiaguwenTable.DatArry,function(i,arr){
		st+=jsonarr2sorterOutput(arr);
	});
	st+="];\n";
	st+="////CurrentlyUsedData\n";
	$("#out").val(st);
},
"output_imgHolder":function(){
	var s="";
	$("#imgSelHolder").find("img").each(function(){
		var src=$(this).attr("src");
		var jid=JgwUti.GetImgIdFrSrc(src);
		s+="\""+jid+"\",";
	});
	$("#out").val(s);
},
"output_d3_for_all":function(){
	var ss="var links = [\n";
	var ret=d3_get_jslink_source_target("","1,2,3,4,5,6,7");
	ss+=ret.jstr;
	ss+="];\n//gen fr whole Jiaguwen6kTable. iTotLinks:"+ret.iTot;
	ss+="\n";
	$("#out").val(ss);
},
"output_d3_fr_Input_Hilimg":function(){
	var strImgNumRange=$("#pinyinput").val();//1,2,3
	var iTot=0;
	var ss="var links = [\n";
	var imglstr="";
	$("#imgSelHolder").find(".hilimg").each(function(){
		var src=$(this).attr("src");
		var imgId=JgwUti.GetImgIdFrSrc(src);
		imglstr+=imgId+",";
	});
	var ret=d3_get_jslink_source_target(imglstr,strImgNumRange);
	ss+=ret.jstr;
	iTot+=ret.iTot;
	ss+="];\n";
	ss+="//gen fr Jiaguwen6kTable. imglstr:"+imglstr+", strImgNumRange:"+strImgNumRange+", iTotLinks:"+iTot;
	ss+="\n";
	$("#out").val(ss);
},
"output_d3_by_Hilimg_Radial_Root.js":function(){
	var imglstr=GetImgLstStrFrHilimg();
	if(imglstr===null) return;
	var ret=d3_get_jslink_source_target_for_radial_root(imglstr);

	var ss="var links = [\n";
	ss+=ret.jstr;
	ss+="];\n";
	ss+="//gen fr Jiaguwen6kTable. imglstr:"+imglstr+",  iTotLinks:"+ret.iTot;
	ss+="\n\n";
	$("#out").val(ss);
},
"output_d3v4_by_Hilimg_Radial_Root.json.":function(){
	var imglstr=GetImgLstStrFrHilimg();
	if(imglstr===null) return;
	var ret=d3_get_jslink_source_target_for_radial_root(imglstr);

	var ss="{\n";
	ss+="  \"nodes\": [\n";
	ss+=ret.jstrNodes();
	ss+=" ],\n";
	ss+=" \"links\": [\n";
	ss+=ret.jstr;
	ss+=" ]\n";
	ss+="}\n";
	$("#out").val(ss);
	var url="http://localhost/~weiding/weidroot/weidroot_2017-01-06/app/jit/test1/ood3/d3v4ForceDirectdGraph/home_tester.htm";
	window.open(url);
},
"output_root_txt_frq.txt":function(){
	//var sortedItems=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq("");
	return alert("not used");
	var sortedItems=JiaguwenTable.Get_Ary_Items_Sorted_Root_Frq();
	var arry=JiaguwenTable.Get_Arry_by_sortedRootsFrq(sortedItems);
	var s="";
	$.each(arry,function(i,ar){
		var frq=ar[4],eng=ar[10];
		s+=frq+" "+eng+"\n";
	});
	$("#out").val(s);
	gen_table_show(arry);	
},
"search_by_string":function(){
		var v=$("#pinyinput").val();
		var arry=JiaguwenTable.Get_Arry_by_Anywhere_Str(v);
		gen_table_show(arry);
},
//////////////////////////
//////////////////////////
//////////////////////////
"optgroup------------Zi":function(){},

"gen_table_decoded_Zi":function (bEmpty){
	gen_tab_decodedZi(true);
},
"decodedZiNone":function(){
	gen_tab_decodedZi(false);
}, 
"test2":function(){
	confirm("test?");
},

};////sel_option_function
///////////////////////////
///////////////////////////
function Gen_Group_Options_funcs(optfun){
	var keys=Object.keys(optfun);
	var soptn="";
	for(var i=0;i<keys.length;i++){
		if(keys[i].substr(0,8)==="optgroup"){
			var label=keys[i].substr(20);
			if(soptn.length>0) soptn+="</optgroup>";
			soptn+="<optgroup label='"+label+"'>";
			continue;
		}
		soptn+="<option value='"+keys[i]+"'>"+keys[i]+"</option>";
	}

	soptn+="</optgroup>";
	return soptn;
};////////  




