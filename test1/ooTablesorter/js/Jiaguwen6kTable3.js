
///init
//JiaguwenTable.init();
//JiaguwenTable.Init();

function init_tablesorter(){
    $('table').tablesorter({
    //  theme: 'blue',
        usNumberFormat : false,
        sortReset      : true,
        sortRestart    : true,  

        widgets: ['columns','output', ],//'zebra', 'editable'
        widgetOptions: { 
        	///////// ----output------      
            output_separator: 'array',// set to "json", "array" or any separator between rows.            
            output_dataAttrib: 'data-name',// header attrib containing modified header name            
            output_headerRows: true,// if true, include multiple header rows (JSON only)            
            output_delivery: 'p',// p:popup, d:download            
            output_saveRows: 'filtered',// all, visible or filtered            
            output_replaceQuote: '\u201c;',// left double quote            
            output_includeHTML: false,// if true, include any HTML within the table cell            
            output_trimSpaces: true,// remove extra whitespace before & after the cell content            
            output_wrapQuotes: true,// if true, wrap all output in quotes. 
            output_popupStyle: 'width=800,height=300',//for popup dimensions here            
            output_saveFileName: 'mytable.csv',// if saving a file, set the file name here
            output_includeHeader:false, //
            output_headerRows:false,
            // callback executed when processing completes
            // return true to continue download/output
            // return false to stop delivery & do something else with the data
            output_callback: function (data) {
                return true;
            },
            // JSON callback executed when a colspan is encountered in the header
            output_callbackJSON: function ($cell, txt, cellIndex) {
                return txt + '(' + (cellIndex + col) + ')';
            },            
            ////////////////////---editable---//////////////////////////
            editable_columns       : [2,3,5,6,7,8,9,10,11,12,13,14,15], // or "0-2" (v2.14.2); point to the columns to make editable (zero-based index)
			editable_enterToAccept : true,          // press enter to accept content, or click outside if false
			editable_autoAccept    : true,          // accepts any changes made to the table cell automatically (v2.17.6)
			editable_autoResort    : false,         // auto resort after the content has changed.
			editable_validate      : null,          // return a valid string: function(text, original, columnIndex){ return text; }
			editable_focused       : function(txt, columnIndex, $element) {
				// $element is the div, not the td
				// to get the td, use $element.closest('td')
				$element.addClass('focused');
			},
			editable_blur          : function(txt, columnIndex, $element) {
				// $element is the div, not the td
				// to get the td, use $element.closest('td')
				$element.removeClass('focused');
			},
			editable_selectAll     : function(txt, columnIndex, $element){
				// note $element is the div inside of the table cell, so use $element.closest('td') to get the cell
				// only select everthing within the element when the content starts with the letter "B"
				return /^b/i.test(txt) && columnIndex === 0;
			},
			editable_wrapContent   : '<div>',       // wrap all editable cell content... makes this widget work in IE, and with autocomplete
			editable_trimContent   : true,          // trim content ( removes outer tabs & carriage returns )
			editable_noEdit        : 'no-edit',     // class name of cell that is not editable
			editable_editComplete  : 'editComplete', // event fired after the table content has been edited




        }

    });
};



function gen_table_show(rowArr){
	var st=gen_table_str(rowArr);
	show2Table(rowArr.length, st);
};
function show2Table(stitle,st){
	$("#base").html("<a><hr>"+stitle+"</a><br>"+st).find("img").bind('click',Img_click);
	$("#base").find("td").bind("mouseover",mouseover_td);
	$("#base").find("td").bind("click",click_td);

	function click_td(){
		var uiidex=$(this).index();
		var idatcol=JiaguwenTable.m_CheckedColIdxArry[uiidex];
		if([2,3,5,6,7,8,9,10,11,].indexOf(idatcol)>=0){//
			$(this).attr("contenteditable", "true").removeClass("edichanged").addClass("editable");
		}
	}
	function mouseover_td(e){
		var tdix=$(this).index();
		var trix=$(this).parentsUntil("tbody").index();

		$(this).attr("title","idx(tr,td)=("+trix+","+tdix+")");
		//$("#out").val(s);
	}

	//init_tablesorter();
};
function show2grid(strhtm){
	$("#base").html(strhtm).find("img").bind('click',Img_click).removeClass("mi").addClass("bigimg");
}
function pre_out(str){
	var s=$("#out").val();
	s=str+"\n--------------\n"+s;
	$("#out").val(s);
}
function Img_click(e){
	$(this).toggleClass("hilimg");
	var s=$(this).attr("src");

	var imgid=JgwUti.GetImgIdFrSrc(s);
	JiaguwenTable.ClickImg2Replace_pickImg(7, imgid);

	s+="\n"+imgid;
	pre_out(s);

	function _getHolderUniqList(){
		var strlist=$("#imgSelHolder").text();
		var arr=JgwUti.Get_Ary_fr_ImgListStr_UniqSorted(strlist);
		return arr;
	}
	function _AddTableHilimg2Holder(_this){
		$(_this).parentsUntil("table").find(".hilimg").each(function(){
			var sr=$(this).attr("src");
			var id=JgwUti.GetImgIdFrSrc(sr);
			var imgHolderLst=_getHolderUniqList();
			if(imgHolderLst.indexOf(id)<0){
				$("#imgSelHolder").append($(JgwUti.GenJgwImg(id,",")))
				.find("img").addClass("bigimg")
				.unbind("click").bind("click",function(){
					$(this).toggleClass("hilimg");
				});

				$("#imgSelHolder").find("a").unbind("click").bind("click",function(e){
					var jids=$(this).text();
					var jid=jids.split(",")[0];	
					$(".tablesorter").find(".scroll2view").removeClass("scroll2view");
					var jiddivs=$(".tablesorter").find("a:contains("+jid+"):eq(0)");				
					if(jiddivs.length>0) {
						jiddivs[0].scrollIntoView();
						jiddivs.addClass("scroll2view");
					}
					$(this).toggleClass("ColrYellow");					
				});
			};
		});		
	};
	function _HilimgTable2Holders(_this){
		var tableHilimgSrcLst=[];
		$(_this).parentsUntil("table").find(".hilimg").each(function(){
			tableHilimgSrcLst.push($(this).attr("src"));
		});
		//
		$("#imgSelHolder").find("img").removeClass("hilimg");
		$("#imgSelHolder").find("img").each(function(){
			if(tableHilimgSrcLst.indexOf($(this).attr("src"))>=0){
				$(this).addClass("hilimg");
			};
		});
	};
	$("#imgSelHolder").find(".hilimg").removeClass("hilimg");
	_AddTableHilimg2Holder(this);
	_HilimgTable2Holders(this);
}



function UpdateData_by_contenteditable_td(){
	var editData=JiaguwenTable.m_EditData;
	$("#base").find("td[contenteditable='true']").each(function(){
		$(this).removeAttr("contenteditable").removeClass("editable");//.addClass("edichanged");
		var jid=$(this).parentsUntil("tbody").find("td:eq(1)").text();
		var curAr = editData.Get_RowAry_fr_Cur(jid);
		var bChanged=false;
		$(this).parentsUntil("tbody").find("td").each(function(i){
			var j=JiaguwenTable.m_CheckedColIdxArry[i];
			var s=$(this).text();
			s=$.trim(s);
			if(s!=curAr[j]){
				curAr[j]=s;
				bChanged=true;
				$(this).addClass("edichanged");
			}
			else{
				$(this).removeClass("edichanged");
			}
		});
		if(bChanged){
			editData.Update_CurDatArry_by_aRow(curAr);
		}
	});
	var ret=editData.GetChangedData();
	return ret;
}




function gen_table_str(rowArr){
	if(rowArr.length==0){
		return "<p>empty</p><hr>";
	}

	function get_table_th(){
		var ss="";
		for(var j=0; j<JiaguwenTable.m_CheckedColIdxArry.length; j++){
			ss+="<th>"+JiaguwenTable.m_CheckedColIdxArry[j]+"</th>";
		}
		return ss;
	}
	
	JiaguwenTable.Get_Ui_Col_Checkbox_States();
	var st="<table class='tablesorter'><caption>size:"+rowArr.length+"</caption><thead><tr>";
	st+=get_table_th();
	st+="</tr></thead><tbody>";
	$.each(rowArr,function(i,arr){
		st+=gen_tab_tr(arr);
	});
	st+="</tbody></table>";	
	return st;
}
function gen_tab_tr(arr){
	if(!arr){
		return alert("fatl er");
	}

	function getsrow(arr){
		var srow=[];
		for(var i=0; i<arr.length; i++){
			srow[i]=arr[i];
		}
		srow[1]=JgwUti.GenJgwImg(arr[1],"");
		srow[7]=JgwUti.Get_Htm_jink(arr[7]);
		srow[8]=JgwUti.Get_Htm_jtoh(arr[8]);	
		return srow;	
	}
	var srow=getsrow(arr);
	var ret="<tr>";
	$.each(JiaguwenTable.m_CheckedColIdxArry,function(i,iCol){
		ret+="<td>"+srow[iCol]+"</td>";
	});
	ret+="</tr>";
	return ret;
};



function jsonarr2sorterOutput(arr){
	var st="[";
		st+="\""+arr[0] +"\",";
		st+="\""+arr[1] +"\",";
		st+="\""+arr[2] +"\",";
		st+="\""+arr[3] +"\",";
		st+="\""+arr[4] +"\",";
		st+="\""+arr[5] +"\",";
		st+="\""+arr[6] +"\",";
		st+="\""+arr[7] +"\",";
		st+="\""+arr[8] +"\",";
		st+="\""+arr[9] +"\",";
		st+="\""+arr[10]+"\",";
		st+="\""+arr[11]+"\",";
		st+="\""+arr[12]+"\",";
		st+="\""+arr[13]+"\",";
		st+="\""+arr[14]+"\",";
		st+="\""+arr[15]+"\"";
	st+="],\n";
	return st;
};


//function colorizeChangedCell(changeColArr){
//	$(".tablesorter tbody").find("tr").each(function(i){
//		var row=Math.floor(i/2);
//		var _this=this;
//		var colorClass= (i%2===0)?"ColrRed":"ColrYellow";
//		$.each(changeColArr[row],function(n, iCol){
//			var std="td:eq("+iCol+")";
//			$(_this).find(std).addClass(colorClass);
//		});
//	});
//}
function colorizeChangedCell(changeColArr){
	$(".tablesorter tbody").find("tr").each(function(i){
		var row=Math.floor(i/2);
		var _this=this;
		var colorClass= (i%2===0)?"ColrRed":"ColrYellow";
		$.each(changeColArr[row],function(n, iCol){
			var selectediCol=JiaguwenTable.m_CheckedColIdxArry.indexOf(iCol);
			var std="td:eq("+selectediCol+")";
			var elem=$(_this).find(std).addClass(colorClass);
		});
		if("ColrYellow"===colorClass){
			$(this).find("td").unbind("click");
		}
	});
}


/////////////////////
	function d3_get_jslink_source_target(imglstrn, strImgNumRange){
		var myImgNumRangeStrAr=JgwUti.Get_Ary_fr_ImgListStr(strImgNumRange);
		var imgAr=JgwUti.Get_Ary_fr_ImgListStr(imglstrn);

		var ret={"jstr":"","iTot":0};

		if(myImgNumRangeStrAr.length===0){
			alert("no strImgNumRange: '1,2,3'");
			return ret;
		}
		if(imgAr.length===0){
			alert("gen all links for d3");
			imgAr.push("");
		}

		function __get_jstr_img_1(imgid,myImgNumRangeStrAr){
			var ret={"jstr":"","iTot":0};
			for(var i=0;i<JiaguwenTable.DatArry.length;i++){
				var ar=JiaguwenTable.DatArry[i];
				var jid=ar[1];
				var jinkstr=ar[7];
				var imglst=JgwUti.Get_Ary_fr_ImgListStr(jinkstr);
				if(myImgNumRangeStrAr.indexOf(""+imglst.length)<0)continue;
				var typ="licensing";
				if(imgid.length===0 || imglst.indexOf(imgid)>=0){
					for(var j=0;j<imglst.length;j++){
						ret.jstr+="{source:\""+imglst[j]+"\",target:\""+jid+"\",type:\""+typ+"\"},\n";
						//target:\""+jid+"\",type:\"+typ+"\"},\n";
						ret.iTot++;
					};
				}
			};//for
			return ret;
		};//////////////////////


		$.each(imgAr,function(i,imgid){
			var ret1=__get_jstr_img_1(imgid,myImgNumRangeStrAr);
			ret.jstr+=ret1.jstr;
			ret.iTot+=ret1.iTot;
		});
		return ret;
	}////////////////////////
	function d3_get_jslink_source_target_for_radial_root(imglstrn){
		var imgAr=JgwUti.Get_Ary_fr_ImgListStr(imglstrn);
		var RootDict=JiaguwenTable.Get_Dict_Imgid_Frq_by_Col(7,"");
		if(imgAr.length===0){
			$.each(RootDict,function(jid,frq){
				imgAr.push(jid);
			});
		}



		function __get_jstr_children_of_root_1(jidin7, RootDict, iIdxStart,ret){
			if( ret.rootDict[jidin7] ){
				return;
			}
			ret.rootDict[jidin7]=1;
			//var ret={"jstr":"","iTot":0};
			var rootChildren=[], ifirst=-1;
			for(var i=iIdxStart;i<JiaguwenTable.DatArry.length;i++){
				var ar=JiaguwenTable.DatArry[i];
				var jidin1=ar[1];
				var jinkstr=ar[7];
				var model=ar[6];
				var imglst=JgwUti.Get_Ary_fr_ImgListStr(jinkstr);
				if(imglst.length===0)continue;//none empty
				if(imglst.indexOf(jidin7)<0)continue;//contains root.
				
				if(ifirst<0) ifirst=i+1;
				var typ="licensing";//
				if( RootDict[jidin1]){
					typ="suit";//
				}else if(imglst.length===1 ){
					typ="suit";//
				}else if(imglst.length>1 && model==="1"){
					typ="resolved";//
				}else{
					continue;
				};
				
				ret.jstr+="{\"source\":\""+jidin7+"\",\"target\":\""+jidin1+"\",\"type\":\""+typ+"\"},\n";
				
				ret.iTot++;
				ret.jsource[jidin1]=1;
				ret.jsource[jidin7]=1;
				rootChildren.push(jidin1);
				
			};//for
			for(var k=0;k<rootChildren.length;k++){
				var jid=rootChildren[k];
				__get_jstr_children_of_root_1(jid,RootDict,0,ret)
			}
		};//
		///////////////////////////////////////////////////////



		var ret={"jstr":"","iTot":0,"rootDict":{}, "jsource":{}, jstrNodes:function(){
			var ret="";
			$.each(this["jsource"],function(jid,v){
				ret+="{\"id\": \""+jid+"\", \"group\": 1},\n";
			});
			ret=ret.substr(0,ret.length-2)+"\n";
			return ret;
		}};
		for(var i=0;i<imgAr.length;i++){
			__get_jstr_children_of_root_1(imgAr[i], RootDict, 0, ret);
		}

		ret

		ret.jstr=ret.jstr.substr(0,ret.jstr.length-2)+"\n";
		return ret;
	};/////////////////////////////////////////////////////////

function GetImgLstStrFrHilimg(){
	var imglstr="";
	$("#imgSelHolder").find(".hilimg").each(function(){
		var src=$(this).attr("src");
		var imgId=JgwUti.GetImgIdFrSrc(src);
		imglstr+=imgId+",";
	});
	if(imglstr.length===0){
		if(!confirm("no hilimg. Do you want to gen all root radial?")){
			alert("noop");
			return null;
		};
	}
	return imglstr;	
}







