
 function allowDrop(ev) {
     ev.preventDefault();
 }

 function drag(ev) {
     ev.dataTransfer.setData("text/html", ev.target.id);
     //console.log("drag");
 }

 function drop(ev) {
     ev.preventDefault();
     //console.log("drop");
     var data = ev.dataTransfer.getData("text/html");
     ev.target.appendChild(document.getElementById(data));
 }

 
 
function ZoomImg(){
    var h=$("#zoomedpicture").css("height");
    h= parseInt(h) ;
    switch(h){
    case 50:
        h=100;
        break;
    case 100:
        h=400;
        break;
    case 400:
        h=600;
        break;
    default:
        h=50;
        break;
    }
    
    $("#zoomedpicture")
        .css("height",h+"px")
        .css("width", h+"px");
    return;
}

//add zoomed pictured into td clicked.
function add_img_into_td(elm){
    if(g_db_td_state_addimg2td){
        var src=$("#zoomedpicture").attr("src");
        var tit=$("#zoomedpicture").attr("title");
        var tarr = tit.split("\n");
        var tid = tarr[0];
        var htm=$("#zoomedpicture").parent().html();
        var subdiv = "<div><a class='m'>"+tid+"</a><br/><img class='m' src='"+src+"'></img></div>";
        $(elm).find("div:eq(0)").append(subdiv);
        $("#sql_data").text(subdiv);
        $(elm).css("background-color",g_Edited_Color);  
        return;
    }
    else{
        return;
    }
    
    var indx = $(elm).index();
    var txt = $(elm).text();
    var htx = $(elm).html();
    var str="";
    $(elm).find("a").each(function(){
        str += $(this).text() + ",";
    });
    $("#opText").text(str+"||"+txt);
    $("#sql_data").text(htx);
    if(0===indx){
        var idx = $(elm).text();
    }//alert(htx);
}


function get_database_select_table_name(){
        var tabarr=["Jiaguwen", "Hieroglyphics", "bronze0000shang"];
        var colIdx=7;  //Jiaguwen   
        var sqlstr = $("#sqlstr").text();
        
        for(var i=0;i<tabarr.length;i+=1){
            var tn=tabarr[i];
            if( sqlstr.search(" "+tn+" ")>0){
                return tn;
            }
        }
        alert("current table name not find.");
        return "";
}
function get_database_sql_update_text(_THIS){//td
                            $(_THIS).css("background-color",g_Edited_Color);  
                            var tdidx = $(_THIS).index();
                            var itm = $(_THIS).closest("table").find("tr:eq(0) td:eq("+tdidx+")").text();
                            var pkey = $(_THIS).closest("table").find("tr:eq(0) td:eq("+0+")").text();
                            var txt="";
                            var ImgSeper="";
                            $(_THIS).closest("td").find("img").each(function(){
                                ImgSeper=",";
                            });
                            $(_THIS).closest("td").find("a").each(function(){
                                $(this).attr("contenteditable","true");
                                var imgId = $(this).text();
                                if(imgId.length>0){
                                    txt += imgId+ImgSeper;
                                }
                            });
                            var idx = $(_THIS).closest("tr").find("td:eq(0)").text();
                            var idx = $(_THIS).closest("tr").find("td:eq(0)").text();
                            
                            //SELECT * FROM Hieroglyphics LIMIT 0,10 ;;;
                            //var sqlstr = $("#sqlstr").text();
                            var sdb=get_database_select_table_name();//"Hieroglyphics";
                            //var ipos=sqlstr.search(" " + sdb);
                            //if(ipos<0){
                            //    sdb="Jiaguwen";
                            //}
                            var sqlupdate="UPDATE "+sdb+" SET "+itm+"='"+txt+"' WHERE "+pkey+"="+idx+";";
                            //var sqlup = prompt("sqlupdate",sqlupdate);
                            //var txt = sqlupdate + "; " + $("#sql").val();
                            //$("#sql").val(txt);
                            
                            $(_THIS).attr("title",sqlupdate);
                            //alert(sqlup);
                            return sqlupdate;
}
function get_database_sql_update_execute(_THIS){//td
    var usedClr="rgb(255, 155, 100)";
    var clr = $(_THIS).css("background-color");
    if( (g_Edited_Color !=  clr) && (usedClr != clr)   ){
        return;
    }
    var sql=get_database_sql_update_text(_THIS);

    if(confirm("Execute:\n"+ sql)){
        window.open("db_view.php?sql="+sql,"","width=800,height=300");
        $(_THIS).css("background-color",usedClr);
    }
}

function get_table_td_eq_idx(){
        var tab = get_database_select_table_name();
        switch(tab){
            case "Jiaguwen":
             return "td:eq(7)";
            case "Hieroglyphics":
             return "td:eq(4)";
            case "bronze0000shang":
                var td3="tdeq3";
                var sqlstr=""+$("#sql").val();
                var pos = sqlstr.search(td3);
                alert(sqlstr + td3+ pos );
                if(pos>0){
                    return "td:eq(3)";
                }     
                var td2="tdeq2";
                if(sqlstr.search(td2)>0){
                    return "td:eq(2)";
                }    
                alert("bronze0000shang must have ;"+td2 +" or " + td3);
        }
        alert("current table name not find.");
        return "";
}
function get_root_group_array(){

    var MergeArr = [];
        MergeArr[58515]=[62613,62612,58560];//cross-nailed-hand
        MergeArr[58525]=[58650, 58663];//father 58525
        MergeArr[57344]=[60918, 57345];//man ////60918; ////
        MergeArr[60163]=[60120, 60162, 60158]; //[Hao] = Gao 
        MergeArr[60104]=[60103, 60068];//Ru, Jing,
        MergeArr[58760]=[58759,59983,59984,62234,58762,58764,63050];//T
        MergeArr[57869]=[57870];//mother
        MergeArr[62367]=[62359];//Zhu3
        MergeArr[60442]=[62559];//Ding
        MergeArr[62633]=[62162, 62155,62160,62152,62153];//rope children
        
        MergeArr[59478]=[57696,57697];//ox
        MergeArr[60387]=[60388];//ox manger
        MergeArr[58283]=[58284];//Gan mouth. [-]
        MergeArr[62539]=[58880];//rain
        MergeArr[62629]=[62229, 63362,60956, 62869, 60987, 60958, 59925, 62630, 60957, 62584, 63330,62632,58078,59912, 63429, 62585, 58096,58079];//son 62630
        MergeArr[58692]=[60513,60549,61788,60111,62582,58723,62580,61787,61536,58721,61805];//son wrapper
        MergeArr[61793]=[62163];//son Isa
        MergeArr[59243]=[59190,61993, 61978, 59198, 59340, 59196, 57634,63092,63095,61996,59194,59459,59319,59318,59192,62636,59248,62112,62637,59320];//wood tree 61993
        MergeArr[58848]=[58850];//moon
        MergeArr[58369]=[58376,58426];////foot arrived
        MergeArr[59496]=[59498, 63361, 61930, 59497,63352,63125,58170,63351,58169];//goat. sheep 
        MergeArr[62859]=[62860, 62418];//8-flood
        
        MergeArr[59117]=[59065, 59066,59064,59060,59059,];//water-flood
        MergeArr[59411]=[59468, 59413, 59412,59367,59460];//grain come
        
        MergeArr[62548]=[63535,62593, 61662,61689,62254,62255,62336,61660,58733,62379,59445,59804,59461,61817,62232,62615,62378,61702,61674,63055,63340,62381,61664,61666,62375,61675,61663,62870,62592,61598,58810,61711,62377,61699,62028,61100,61672,62317,62293];//+ cross 61689
        MergeArr[62465]=[62635,62351,62347,62534,62591,58862,62349,62466];//nailed-on-cross. 
        MergeArr[61839]=[61841, 61149, 61840, 61153, 59987,];//zhui zi. backhome 
        MergeArr[60022]=[60052,60053];//heart bei
        MergeArr[59958]=[59953,59227];//turtle 
        MergeArr[61190]=[61191,61193];//holy gran,
        MergeArr[62652]=[62649,62648,62650,61297,];//bottle wine 
        MergeArr[61815]=[63463];//zhou3 astronomy ametor 
        
        MergeArr[57571]=[57600,62287,62285,62286];////king 
        MergeArr[62619]=[61032];//Up arrow
        MergeArr[62549]=[61185,61009,57348,59872,59904,59902,57374,58868,59903,58875,62861,62340,59897,58867,59894,59900,62343,59893,59975,62279,63149,59896,59895,58876,62864,63247];//snakes, 62549
        MergeArr[60789]=[60885,60907,62567,60791,60799,62662,61728,62571,62569,60905,60854,63225,61603,60902,63234,60801,62564,62657,62655,61637,62570,60792];//weapons,              
        MergeArr[62880]=[62594,61713,61588,61543,62298,61595,61589,62407,61592,60494,61903,61604];//Zheng
        MergeArr[61507]=[62956];//qi
        MergeArr[62589]=[61678, 58311];//work 
        MergeArr[61910]=[61912,61921,61656,61911,60097];//good-bad fruit tree
        MergeArr[59019]=[59021];//cliff 
        
        MergeArr[61415]=[58716, 61420, 61414];//bai2 bronze
        MergeArr[58839]=[58838,62517,61717];//lian2 ren2
        MergeArr[60995]=[59240,60996];//bu4 not
        MergeArr[59652]=[59643,59642,59644,59636,57490];//animal tiger
        MergeArr[59548]=[63131,59552,59550, 59633,59527,59558,59606,59551,59549,59553,59625,59641,];//animal cow  
        MergeArr[59707]=[59698,59708,59692];// deer
        //MergeArr[59723]=[59723,,];// horse
        MergeArr[59938]=[59928,59823,];// xie4 
        MergeArr[57361]=[57364];//man body
        MergeArr[62507]=[59662,59609,59697];//animal body  59723
        MergeArr[58930]=[58928];//tu3 qiu1 
        MergeArr[58118]=[58119,62977];//eye
        //57361
        //57364  man body
        
        
        return MergeArr;
}
function roots_merge_list(){
    var mergArr = get_root_group_array();
    
    var imgurl=$("#zoomedpicture").attr("src");
    if(imgurl.length==1){
       alert("Please set a zoomed picture");
       return;
    }
    imgurl=imgurl.substring(0,imgurl.length-9);
    alert(imgurl);
    var stable="<table border='1'>";
    var icount=0;
    var uniqueChecker=[];
    $.each(mergArr, function(idx,arr){
        if(arr){
            if(idx>0 && uniqueChecker.indexOf(idx)>=0){
                alert("duplicated:"+idx);
            }
            uniqueChecker.push(idx);

            var simg=imgurl+idx+".gif";
            icount+=1;
            stable+="<tr><td>"+icount+"</td><td><a class='m'>"+idx+"</a><br><img src='"+simg+"' title='"+idx+"'></img></td><td>";
            $.each(arr,function(ii,val){
                if(val){
                    if(val>0 && uniqueChecker.indexOf(val)>=0){
                        alert("duplicated:"+val);
                    }
                    uniqueChecker.push(val);

                    
                    simg=imgurl+val+".gif";
                    stable+="<img src='"+simg+"' title='"+val+"'></img>";
                }
            });
            stable+="</td></tr>";
        }
    });
    stable +="</table>"; 
    //alert(stable);
    //$("#jq_data_analysis").text("");
    $("#jq_data_analysis").append(stable);
}
function root_freq_analysis(mode){
        var targetTD=get_table_td_eq_idx();//"td:eq("+colIdx+")"; 
        alert(targetTD);

        var tx="<br><table border='1'>";
        var RF=[];
        var RFIdxOf=[];
        $("table tr").each(function(){
            $(this).find(targetTD).find("div div").each(function(){
                var td1htm = $(this).closest("tr").find("td:eq(1)").html();
                var dv2id=$(this).html();
                var imgId = $(this).text();//+",";
                imgId = $.trim(imgId);
                var idx = RFIdxOf.indexOf(imgId);
                //alert(idx+":imgId="+imgId+",\ndv2id="+dv2id);
                if(imgId.length>=0){
                    if(idx<0){
                        idx=RFIdxOf.length;//get last index for the size of array.
                        RFIdxOf[idx]=imgId;
                        RF[idx]={key:imgId, RFval:0, htm:dv2id, td1htm:""};
                    }
                    RF[idx].RFval += 1;
                    RF[idx].td1htm += td1htm;
                }               
            });
        });

        tx+="</table>";
        //$("#jq_data_analysis").append(tx);
        //alert(RF.length);
        
        ////merge similar roots
        var sTextMerged="(merge to:)";
        var table2merged="<br/><br/><table border='1' id='merged'><caption>Merged List</caption>";
        var MergeArr = [];
        if(mode) {
            MergeArr =  get_root_group_array();
        };
        
        $.each(RF,function(idx,obj){
            var val = obj.RFval;
            var htm = obj.htm;
            var id = obj.key;
                
            var toBeMergedIdArr= MergeArr[id]; 
            if( !! toBeMergedIdArr ){
                $.each(toBeMergedIdArr, function(k, toBeMergedId){
                         var arridx = RFIdxOf.indexOf(""+toBeMergedId);
                         if(arridx>=0) {
                             var toBeMerged = RF[arridx];
                             if( !! toBeMerged ){
                                //alert(toBeMerged.RFval);
                                obj.RFval += toBeMerged.RFval;
                                
                                obj.htm += "<br/><a id='" + id + "' href='#"+toBeMerged.key + "'>+"+toBeMerged.RFval+"</a><br>"+toBeMerged.htm;
                                
                                toBeMerged.htm += "<br/><a id='"+ toBeMerged.key +"' href='#"+id +"'>"+sTextMerged+"</a><br/>"+htm;
                                
                             }
                         }
                });
            }
        });
        
        
        ////sort in decr
        RF.sort(function(a,b){
            return parseInt(a.RFval) < parseInt(b.RFval);
        }); //sort by value;
        
        
        tx="<br><table border='1' id='RootsFreqList'><caption>RootsFreqList</caption>";
        tx+="<tr><td>idx</td><td>Roots</td><td>Freq</td><td>Tot</td></tr>"; 
        
        var idx=0, totalMerged=0;
        var total_RFval=0;
        var LastTR="";
        $.each(RF,function(i,obj){
            if(!!obj){
                var td1htm = obj.td1htm;
                var val = obj.RFval;
                var htm = obj.htm;
                var id = obj.key;
                total_RFval+=val;
                //tx+="<tr><td>"+idx+"</td><td>"+htm+"</td><td>"+val+"</td><td>"+total_RFval+"</td></tr>"; 
                var s="<tr><td>"+idx+"</td><td>"+htm+"</td><td>"+val+"</td><td>"+total_RFval+"</td><td>"+td1htm+"</td></tr>"; 
                //alert(id);
                if(63536==id){
                    LastTR=s;
                }else{
                    var bmerged = s.indexOf(sTextMerged);
                    if( bmerged<0 ){
                        tx+=s;
                        idx+=1;       
                    }
                    else{
                        table2merged +=s;
                        totalMerged+=1;
                    }
                    
                }
                                
            }            
        });
        tx+=LastTR+"</table>";
        tx+="total_RFval="+total_RFval+","+targetTD;
        $("#jq_data_analysis").text("");
        $("#jq_data_analysis").append(tx);
        
        table2merged+="</table><br/>totalMerged="+totalMerged;
        $("#jq_data_analysis").append(table2merged);
}




var oid=57345;
var g_KeypressedVal=0;
var g_db_td_state_addimg2td=false;

var g_EnableBlockMarks=false;
var g_db_td_state_edit=false;
var g_db_td_state_update=false;

var g_Edited_Color="rgb(255, 255, 0)";
$(document).ready(function(){     
    //$("img").draggable();
    $("#zoomedpicture").attr("src",".").attr("border","1");
    $(".tmpimg").attr("src",".").attr("border","1");
    $(".tmpimg").click(function(){
        var zoomedsrc = $("#zoomedpicture").attr("src");
        var ncc = $(".tmpimg[src='"+zoomedsrc+"']").length;
        $(".tmpimg").attr("border",""); 
        if(ncc<1){                       
            var holdsrc=$(this).attr("src");
            if( holdsrc.length >3) {
               var bchange = confirm("Replace\n"+holdsrc+"\nwith zoomed new\n"+zoomedsrc+"\n\nConfirm?");
               if(bchange){
                  $(this).attr("src",zoomedsrc).attr("border","1");
               }
               else{
                    $(".tmpimg[src='.']").each(function(k){
                       if(k===0){
                         $(this).attr("src",zoomedsrc).attr("border","1");;
                       }
                    });
               }
            }
            else{
                $(this).attr("src",zoomedsrc).attr("border","1");
            }            
        }
        else{
            $(".tmpimg[src='"+zoomedsrc+"']").attr("border","1");
        }
        return false;
    });
    //img_holding(0);
    
    $("table  tr  td:eq(1) div a").click(function(){
        var src = $(this).text();
        //$(this).attr("src",src);
        alert(src);
    });
    
    $("#zoomedpicture").click(function(){
        var s=$(this).attr("src");
        var n=prompt("change img src",s);
        if(n){
            $(this).attr("src",n);
        }
    });

    
    

                 
                 
                 $("imgzzzzzzz").click(function(event){
                               if($("body").attr("ctrlKey")!=true) return;
                               $("body").attr("ctrlKey",false);
                               event.stopPropagation();
                               var src = $(this).attr("src");    
                               //alert($(this).get(0).nodeName);
                               //alert($(this).prop("tagName"));
                               $.post("../uti/svc/_imgClick.php", {   
                                      src:src
                                      },
                                      function(data, status){
                                          alert(status + ":\n"+ data);
                                     },
                                     "datastring"
                                     );// post     
                               //alert("src="+src);
                               });
                        
                 $("td").click(function(event){//add copy(img) into this list.
                        if(g_EnableBlockMarks){
                            var clr = $(this).css("background-color");
                            //alert(clr);
                            if("transparent"===clr){
                                $(this).css("background-color","red");
                            }else{
                                $(this).css("background-color","");                            
                            }
                        };
                        if(g_db_td_state_edit){                                
                            get_database_sql_update_text(this);                            
                            return;
                        };
                        if(g_db_td_state_update){
                            get_database_sql_update_execute(this);   
                        }

                        
                        add_img_into_td($(this));
                        return;
                            var indx = $(this).index();
                            var txt = $(this).text();
                            var htx = $(this).html();
                            var str="";
                            $(this).find("a").each(function(){
                                str += $(this).text() + ",";
                            });
                            $("#opText").text(str+"||"+txt);
                            $("#sql_data").text(htx);
                            if(0===indx){
                                var idx = $(this).text();
                            }//alert(htx);
                
                            return;
                            
                               if($("body").attr("ctrlKey")!=true) return;
                              $("body").attr("ctrlKey",false);
                              event.stopPropagation();
                              //alert("www"+ $(this).get(0).nodeName);
                              var pars = $(this).attr("pars");
                              if(pars.length==0) return;
                              if (true != confirm("Add?\n" + pars) ) return;
                              $.post("../uti/svc/_imgAppend.php", {   
                                     pars:pars
                                     },
                                     function(data, status){
                                     alert(data);
                                    $("#ajx_containter").html(data);
                                    

                                    },
                                    "datastring"
                                    );// post 
                              });
                $("a").click(function(event){
                    //var tdidx = $(this).closest("td").index();
                    //var itm = $(this).closest("table").find("tr:eq(0) td:eq("+tdidx+")").text();
                    //var txt="";
                    //$(this).closest("td").find("a").each(function(){
                    //    txt += $(this).text()+",";
                    //});
                    //alert(tdidx+" SET "+itm+"='"+txt+"' ");
                    //var id=$(this).text();
                    //alert(id);
                });
                 $("a.m").click(function(event){
                                if($("body").attr("ctrlKey")!=true) return;
                               $("body").attr("ctrlKey",false);
                               event.stopPropagation();
                               var pars = $(this).attr("pars");
                               if(pars.length==0) return;
                               pars+=","+$(this).html();
                               //alert( "["+pars+"]" );
                               if (true != confirm("Delete?\n" + pars) ) return;
                               $.post("../uti/svc/_imgDelete.php", {   
                                      pars:pars
                                      },
                                      function(data, status){
                                      alert(data);
                                     $("#ajx_containter").html(data);
                                     

                                     },
                                     "datastring"
                                     );// post 
                               });
                 $("a.ed").click(function(event){
                            $(this).attr("onkeypress","keypress"),on("keypress","keypress");

                                 if($("body").attr("ctrlKey")!=true) return;
                                $("body").attr("ctrlKey",false);
                                event.stopPropagation();
                                
                                var pars = $(this).attr("pars");
                                if(pars.length==0) return;
                                var myval = $(this).html();
                                var newstr = prompt("[table,primKey,primVal,youKey,youVal]=["+pars + ","+myval + "], youNewVal:", myval);
                                if( null==newstr) return;
                                if(newstr== myval){
                                return alert(myval + " not changed.");
                                }
                                pars += "," + newstr;
                                //alert( "["+pars+"=" + newstr);
                                //if (true != confirm("Update?\n ["+pars+"]\n repplace '"+ myval + "' with " + newstr) ) return;
                                //$(this).html(newstr);
                                $(this).attr("id","TmpId");
                                $(this).attr("youVal",newstr);
                                $.post("../uti/svc/_itemUpdate.php", {   
                                       pars:pars
                                       },
                                       function(data, status){
                                       $("#TmpId").html( $("#TmpId").attr("youVal") ); 
                                      $("#TmpId").attr("id","");
                                      $("#TmpId").attr("youVal","");
                                      //alert(data);                            
                                      },
                                      "datastring"
                                      );// post 
                                });
                 
                 $("img").mouseover(function(event){
                                    if($("body").attr("shiftKey")!=true) return;
                                   //$("body").attr("shiftKey",false);
                                   //$(this).css("height", "200px");
                                   //$(this).css("width", "200px");
                                   //$(this).css("position", "absolute");
                        }).mouseout(function(event){
                            $("#opText").text("mouseout");
                                               //$(this).css("height", "");
                                               //$(this).css("width", "");
                                               //$(this).css("position", "");
                        }).click(function(e){
                            if(!g_db_td_state_addimg2td){
                                    var src = $(this).attr("src");
                                    if(src.length>2){
                                        var arr = src.split("/");
                                        var end = arr[arr.length-1];
                                        arr=end.split(".");
                                        end=arr[0];
                                        $("#zoomedpicture").attr("src",src).attr("title", end+"\n"+src);
                                        $("#opText").text(src);
                                    }
                            }

                                        //alert();
                        }).mousedown(function(){
                            //alert();//not work
                            $("#opText").text("mousedown");
                        });


                 
                 $("body").keypress(function(e){
                                    var k = e.which;
                                    //alert(k);
                                    $("#opText").html(k);                                   
                            }).keyup(function(e){
                                           $("body").attr("shiftKey",e.shiftKey);
                                           $("body").attr("ctrlKey",e.ctrlKey);
                                           //alert(e.ctrlKey);
                            }).keydown(function(e){
                                        $("body").attr("shiftKey",e.shiftKey);
                                        $("body").attr("ctrlKey",e.ctrlKey);
                                                     //alert(e.ctrlKey);
                            }).mousemove(function(e){
                                        //if($("body").attr("shiftKey")!=true) return;
                                        if(g_db_td_state_addimg2td){
                                            var pos=" "+(0+e.pageX-$("body").width())+","+e.pageY;
                                            $("#opText").text(pos);
                                            $("#zoomedpicturezzzz").css( {  
                                                         position: 'absolute', 
                                                         zIndex: 5000, 
                                                         left: (e.pageX - $("body").width()+130)+"px",
                                                         top: (e.pageY-100)+"px" 
                                                         });
                                        };                                                                  
                              });
                 

    //////////////////////////
    //table data RF anaylsis for 
    $("#jink_roots_freq_list").click(function(){
        root_freq_analysis(null);
    });
    $("#jink_roots_freq_list1").click(function(){
        root_freq_analysis(1);
    });
    $("#roots_merge_list").click(function(){
        roots_merge_list();
    });
    
    
    
    $("#opcmd").change(function(){
        var cmd=$(this).val();
        SetOperationCmd(cmd);
        $(this).val("");
        //alert( cmd );
        $("#opText").text(cmd);
    });
});//$(document).ready(function(){                                            



function SetOperationCmd(k){
                                    switch(k){
                                        //case 109:// 'm' : mark
                                        case "mark":
                                            g_EnableBlockMarks=!g_EnableBlockMarks;
                                        break;
                                        //case 122://'z' zoom
                                        case "zoom":
                                            ZoomImg();
                                        break;
                                        case 108://'l' lock img copy
                                            //img_holding(0);
                                            //img_holding(1);
                                        break;
                                        case 46://'>' next holder

                                        break;
                                        case 44://'<' previous holder                                        

                                        break;
                                        case 97://'a' add
                                        case "add":                                          
                                            g_db_td_state_edit=false;
                                            g_db_td_state_edit_func(g_db_td_state_edit);
                                            g_db_td_state_update=false;
                                            g_db_td_state_update_func(g_db_td_state_update);                                        
                                        
                                            g_db_td_state_addimg2td=!g_db_td_state_addimg2td;
                                            g_db_td_state_addimg2td_func(g_db_td_state_addimg2td);
                                           
                                            $("body").css("background-color","#eeaabb");
                                        break;
                                        case 100://delete
                                        case "del":
                                        break;
                                        //case 117: //'u':update db 
                                        case "update":
                                            g_db_td_state_edit=false;
                                            g_db_td_state_edit_func(false);
                                            g_db_td_state_update=!g_db_td_state_update;
                                            g_db_td_state_update_func(g_db_td_state_update);
                                            if(g_db_td_state_update){
                                                $("body").css("background-color","#ff0000");
                                            }else{
                                                $("body").css("background-color","#eeaabb");
                                            }                                            
                                        break;
                                        case "edit":
                                            g_db_td_state_update=false;
                                            g_db_td_state_update_func(false);                                        
                                            g_db_td_state_edit=!g_db_td_state_edit;
                                            g_db_td_state_edit_func(g_db_td_state_edit);
                                            if(g_db_td_state_edit){
                                                $("body").css("background-color","#D0DCE0");
                                            }else{
                                                $("body").css("background-color","#eeaabb");
                                            }                                            
                                        break;
                                        case "---":
                                            g_db_td_state_addimg2td=false;
                                            g_db_td_state_addimg2td_func(g_db_td_state_addimg2td);
                                            g_db_td_state_edit=false;
                                            g_db_td_state_edit_func(g_db_td_state_edit);
                                            g_db_td_state_update=false;
                                            g_db_td_state_update_func(g_db_td_state_update);
                                            $("body").css("background-color","#eeaabb");
                                        break;
                                        case "ooTree_json":
                                        case "ooLink_json":
                                            D3Uti.convert_odb_table_to_d3_ooTree_show_on("#jq_data_analysis");
                                        break;
                                    default:
                                    break;
                                    }//switch//
 }
 
 
 function g_db_td_state_edit_func(bEnable){
                                            g_db_td_state_addimg2td=false;
                                            $("html").css("cursor","default");
                                            if(bEnable){
                                                //$("a").attr("contenteditable","true");
                                            }else{
                                                $("a").attr("contenteditable","false");
                                            }
 }
function g_db_td_state_update_func(bEnable){
                                            g_db_td_state_addimg2td=false;
                                            $("html").css("cursor","default");
 }
 
 function g_db_td_state_addimg2td_func(bEnable){
                                            if(bEnable){
                                                $("html").css("cursor","crosshair");
                                            }
                                            else{
                                                $("html").css("cursor","default");
                                            }  
 }
 
 
function svrSelectOptiontsHistorySave(str){
 var sdata="sql=<option>"+str+"</option>";
 console.log(sdata);
 $.ajax({
            type: "POST",
            data: sdata,
            dataType: "text",
            url: "./svrSelectOptiontsHistorySave.php",
            success: function(data){
                console.log(data);                
            },
            error: function(){
                console.log("postError,");
            }
        });
}