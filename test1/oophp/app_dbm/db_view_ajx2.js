
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
    case 30:
        h=50;
        break;
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
        h=30;
        break;
    }
    
    $("#zoomedpicture")
        .css("height",h+"px")
        .css("width", h+"px");
    return;
}
function img_holding(op){
    var src = $("#zoomedpicture").attr("src");
    if($(".tmpimg [src='"+src+"']").length>0){
        alert();
        return;
    }
    $(".tmpimg").attr("border","");
    
    g_Keypressed_img_holding += op;
    if( g_Keypressed_img_holding >= $(".tmpimg").length){
        g_Keypressed_img_holding = 0;
    }   
    
    if(0==op){  
        $(".tmpimg:eq("+g_Keypressed_img_holding+")").attr("src", src).attr("title", src).attr("border","1");                  
    }   
    else{
        $(".tmpimg:eq("+g_Keypressed_img_holding+")").attr("border","1"); 
    }
    return;
}
function add_img_toggle_state(){
    if(g_Keypressed_add2td){
        $("html").css("cursor","crosshair");
    }
    else{
        $("html").css("cursor","default");
    }  
}
function add_img_into_td(elm){
    if(g_Keypressed_add2td){
        var src=$("#zoomedpicture").attr("src");
        var tit=$("#zoomedpicture").attr("title");
        var tarr = tit.split("\n");
        var tid = tarr[0];
        var htm=$("#zoomedpicture").parent().html();
        var subdiv = "<div><a class='m'>"+tid+"</a><br/><img class='m' src='"+src+"'></img></div>";
        $(elm).find("div:eq(0)").append(subdiv);
        $("#sql_data").text(subdiv);
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
function update_item_database(){
}

var oid=57345;
var g_KeypressedVal=0;
var g_Keypressed_add2td=false;
var g_Keypressed_img_holding=0;//copy
var g_EnableBlockMarks=false;
var g_Keypressed_update_db=false;
var g_Keypressed_delete_fr_td=false;
$(document).ready(function(){     
    //$("img").draggable();
    $(".tmpimg").click(function(){
        var src = $("#zoomedpicture").attr("src");
        //$(this).attr("src",src);
    });
    img_holding(0);
    
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
                        if(g_Keypressed_update_db){   
                             
                            $(this).css("background-color","yellow");  
                            var tdidx = $(this).index();
                            var itm = $(this).closest("table").find("tr:eq(0) td:eq("+tdidx+")").text();
                            var pkey = $(this).closest("table").find("tr:eq(0) td:eq("+0+")").text();
                            var txt="";
                            var ImgSeper="";
                            $(this).closest("td").find("img").each(function(){
                                ImgSeper=",";
                            });
                            $(this).closest("td").find("a").each(function(){
                                var imgId = $(this).text();
                                if(imgId.length>0){
                                    txt += imgId+ImgSeper;
                                }
                            });
                            var idx = $(this).closest("tr").find("td:eq(0)").text();
                            var idx = $(this).closest("tr").find("td:eq(0)").text();
                            
                            //SELECT * FROM Hieroglyphics LIMIT 0,10 ;;;
                            var sqlstr = $("#sqlstr").text();
                            var sdb="Hieroglyphics";
                            var ipos=sqlstr.search(" " + sdb);
                            if(ipos<0){
                                sdb="Jiaguwen";
                            }
                            var sqlupdate="UPDATE "+sdb+" SET "+itm+"='"+txt+"' WHERE "+pkey+"="+idx+";";
                            //var sqlup = prompt("sqlupdate",sqlupdate);
                            var txt = sqlupdate + "; " + $("#sql").val();
                            $("#sql").val(txt);
                            //alert(sqlup);
                            
                        };

                        
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
                $("td div a").click(function(event){
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
                                if(g_Keypressed_delete_fr_td){
                                    var txt = $(this).text();
                                    $(this).text("").attr("title",txt);//css("width","1")
                                    $(this).closest("div").find("img").css("height","5").attr("title",txt);
                                }
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
                            if(!g_Keypressed_add2td){
                                    var src = $(this).attr("src");
                                    var arr = src.split("/");
                                    var end = arr[arr.length-1];
                                    arr=end.split(".");
                                    end=arr[0];
                                    $("#zoomedpicture").attr("src",src).attr("title", end+"\n"+src);
                                    $("#opText").text(src);
                            }
                            if(g_Keypressed_delete_fr_td){
                                var h = $(this).css("height");
                                //alert(h);
                                if("5px"==h){
                                    $(this).css("height","");
                                    var txt = $(this).attr("title");
                                    $(this).closest("div").find("a").text(txt);
                                    
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
                                    switch(k){
                                        case 109:// 'm' : mark
                                            g_EnableBlockMarks=!g_EnableBlockMarks;
                                        break;
                                        case 122://'z' zoom
                                            ZoomImg();
                                        break;
                                        case 108://'l' lock img copy
                                            img_holding(0);
                                        break;
                                        case 46://'>' next holder
                                            img_holding(1);
                                        break;
                                        case 44://'<' previous holder
                                            img_holding(-1);
                                        break;
                                        case 97://'a' add
                                            g_Keypressed_add2td=!g_Keypressed_add2td;
                                            g_Keypressed_update_db=false;
                                            g_Keypressed_delete_fr_td=false;
                                            $("body").css("background-color","#eeaabb");
                                            //add_img_toggle_state(); 
                                            if(g_Keypressed_add2td){
                                                $("html").css("cursor","crosshair");
                                            }
                                            else{
                                                $("html").css("cursor","default");
                                            }  
                                            
                                        break;
                                        case 100://delete
                                            //$("html").css("cursor", "grab");
                                            g_Keypressed_delete_fr_td =! g_Keypressed_delete_fr_td;
                                            g_Keypressed_update_db=false;
                                            g_Keypressed_add2td=false;
                                            $("html").css("cursor","default");
                                            if(g_Keypressed_delete_fr_td){
                                                $("body").css("background-color","#808080");
                                            }else{
                                                $("body").css("background-color","#eeaabb");
                                            }
                                        break;
                                        case 117://'u':update db
                                            g_Keypressed_update_db=!g_Keypressed_update_db;
                                            g_Keypressed_add2td=false;
                                            g_Keypressed_delete_fr_td=false;
                                            $("html").css("cursor","default");
                                            if(g_Keypressed_update_db){
                                                $("body").css("background-color","#D0DCE0");
                                            }else{
                                                $("body").css("background-color","#eeaabb");
                                            }
                                            
                                        break;
                                    }//switch//
                                    

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
                                        if(g_Keypressed_add2td){
                                            var pos=" "+(0+e.pageX-$("body").width())+","+e.pageY;
                                            $("#opText").text(pos);
                                            $("#zoomedpicturezzzz").css( {  
                                                         position: 'absolute', 
                                                         zIndex: 5000, 
                                                         left: (e.pageX - $("body").width()+130)+"px",
                                                         top: (e.pageY-100)+"px" 
                                                         });
                                        };
                                        
                                        $("div.sql_editorzzzzz").show().css( {  
                                                         position: 'absolute', 
                                                         zIndex: 5000, 
                                                         left: e.pageX/10000,
                                                         top: e.pageY-80 
                                                         });                                                                  
                              });
                 

    //////////////////////////
    //table data anaylsis for 
    $("#jink_roots_freq_list").click(function(){
        var colIdx=7;    
        var sqlstr = $("#sqlstr").text();
        var sdb="Hieroglyphics";
        var ipos=sqlstr.search(" " + sdb);
        if(ipos>0){
            colIdx=4;
        }
                            
        
        
        var targetTD="td:eq("+colIdx+")"; 
        alert(targetTD);

        var tx="<br><table border='1'>";
        var RF=[];
        var RFIdxOf=[];
        $("table tr").each(function(){
            $(this).find(targetTD).find("div div").each(function(){
                var dv2id=$(this).html();
                var jinkx = $(this).text();//+",";
                var idx = RFIdxOf.indexOf(jinkx);
                //alert(idx+":jinkx="+jinkx+",\ndv2id="+dv2id);
                if(jinkx.length>0){
                    if(idx<0){
                        idx=RFIdxOf.length;
                        RFIdxOf[idx]=jinkx;
                        RF[idx]={key:jinkx, RFval:0, htm:dv2id};
                    }
                    RF[idx].RFval += 1;
                }
                
                //if( undefined == RF[jinkx] || null == RF[jinkx]){
                //    RF[jinkx]={key:jinkx, RFval:0, htm:dv2id};
                //};
                //RF[jinkx].RFval += 1;
                
            });
            
            //var ht=$(this).find("td:eq(7)").html();
            //tx+="<tr><td>"+n+"</td><td>"+jinkx+"</td><td>"+ht+"</td></tr>";
            //n+=1;
        });

        tx+="</table>";
        //$("#jq_data_analysis").append(tx);
        //alert(RF.length);
        
        tx="<br><table border='1'><caption>RootsFreqList</caption>";
        tx+="<tr><td>idx</td><td>Roots</td><td>Freq</td><td>Tot</td></tr>"; 
        var idx=0;
        RF.sort(function(a,b){
            return a.RFval < b.RFval;
        }); //sort by value;
        var total_RFval=0;
        var LastTR="";
        $.each(RF,function(idx,obj){
            if(!!obj){
                var val = obj.RFval;
                var htm = obj.htm;
                var id = obj.key;
                total_RFval+=val;
                //tx+="<tr><td>"+idx+"</td><td>"+htm+"</td><td>"+val+"</td><td>"+total_RFval+"</td></tr>"; 
                var s="<tr><td>"+idx+"</td><td>"+htm+"</td><td>"+val+"</td><td>"+total_RFval+"</td></tr>"; 
                //alert(id);
                if(63536==id){
                    LastTR=s;
                }else{
                    tx+=s;   
                }
                                
            }            
        });
        tx+=LastTR+"</table>";
        tx+="total_RFval="+total_RFval;
        $("#jq_data_analysis").text("");
        $("#jq_data_analysis").append(tx);
    });
    
    //////////////////////////
    //table data anaylsis for 
    $("#zzjink_roots_freq_list").click(function(){
        var n=0;
        var tx="<br><table border='1'>";
        var RF=[];
        $("table tr").each(function(){
            $(this).find("td:eq(7)").find("div a").each(function(){
                var dv2id=$(this).closest("div").html();
                var jinkx = $(this).text();//+",";
                alert(n+":jinkx="+jinkx+",\ndv2id="+dv2id);
                if( undefined == RF[jinkx] || null == RF[jinkx]){
                    RF[jinkx]={key:jinkx, RFval:0, htm:dv2id};
                    alert("jinkx="+jinkx+",\ndv2id="+dv2id);
                };
                RF[jinkx].RFval += 1;
                
            });
            
            //var ht=$(this).find("td:eq(7)").html();
            //tx+="<tr><td>"+n+"</td><td>"+jinkx+"</td><td>"+ht+"</td></tr>";
            n+=1;
        });
        if(!!RF[63536]){
            RF[63536].RFval *= -1; // blank white img
        }
        tx+="</table>";
        //$("#jq_data_analysis").append(tx);
        //alert(RF.length);
        
        tx="<br><table border='1'><caption>RootsFreqList</caption>";
        tx+="<tr><td>idx</td><td>Roots</td><td>Freq</td><td>Tot</td></tr>"; 
        var idx=0;
        RF.sort(function(a,b){
            return a.RFval < b.RFval;
        }); //sort by value;
        var total_RFval=0;
        var LastTR="";
        $.each(RF,function(idx,obj){
            if(!!obj){
                var val = obj.RFval;
                var htm = obj.htm;
                var id = obj.key;
                total_RFval+=val;
                var s="<tr><td>"+idx+"</td><td>"+htm+"</td><td>"+val+"</td><td>"+total_RFval+"</td></tr>"; 
                alert(id);
                if(63536==id){
                    LastTR=s;
                }else{
                    tx+=s;   
                }
            }            
        });
        tx+=LastTR+"</table>";
        tx+="total_RFval="+total_RFval;
        $("#jq_data_analysis").text("");
        $("#jq_data_analysis").append(tx);
    });
    
});//$(document).ready(function(){                                            



