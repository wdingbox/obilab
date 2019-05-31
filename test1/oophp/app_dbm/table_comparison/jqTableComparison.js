
function get_table_col_arr(iTableIdx, iColIdx, iRowStartIdx){
        var RF=[];
        var RFIdxOf=[];
        $("table:eq("+iTableIdx+") tr").each(function(iRow){
            $(this).find("td:eq("+iColIdx+")").each(function(){
                if( iRow >= iRowStartIdx ){
                    var dv2id=$(this).html();
                    var imgId = $(this).text();//+",";
                    imgId=$.trim(imgId);
                    var idx = RFIdxOf.indexOf(imgId);
                    //alert(imgId);
                    //alert(idx+":imgId="+imgId+",\ndv2id="+dv2id);
                    if(imgId.length>0){
                        if(imgId.length>=5){
                            imgId=imgId.substr(0,5);
                        }
                        if(idx<0){
                            idx=RFIdxOf.length;//get last index for the size of array.
                            RFIdxOf[idx]=imgId;
                            //alert("idx="+idx +",imgId="+imgId);
                        }
                    }  
                } // if                
            });
        });
        return RFIdxOf;
}

function get_list_comm(lst0,lst1){
    var commArr=[];
    $.each(lst0,function(i,v){
        
        var idx=lst1.indexOf(v);
        //alert(idx+"--["+i+"]"+v);
        if(idx>=0){
           commArr.push(v);
           //alert("comm: ["+i+"]"+v);
        }
    });
    return commArr;
}
function htm_list2table(lst){
    var txtm="<table border='1'><tr><td>idx</td><td>val</td></tr>";
    var imgsrc="../../odb/tbi/img/jgif/57344.gif";
    imgsrc="http://24.96.232.130:7780/lamp/wroot/odb/tbi/img/jgif/";//57344.gif";
    $.each(lst,function(i,v){
        var img="<br><img src='"+imgsrc+v +".gif'/>";
        txtm+="<tr><td>"+i+"</td><td>"+v+img+"</td></tr>";
    });    
    txtm += "</table>";
    return txtm;
}
$(document).ready(function(){  
    ////sample////   
    $("#runComp").click(function(){
        var arr0=get_table_col_arr(0,1,2);//sample
        var arr1=get_table_col_arr(1,1,2);//man
        var arr2=get_table_col_arr(2,1,2);//servant
        var arr3=get_table_col_arr(3,1,2);//woman
        var arr4=get_table_col_arr(4,1,2);//father
        var arr5=get_table_col_arr(5,1,2);//son
        var arr6=get_table_col_arr(6,1,2);//king
        var sout="arr0="+arr0.length;
        sout+=",arr1="+arr1.length;
        sout+=",arr2="+arr2.length;
        sout+=",arr3="+arr3.length;
        sout+=",arr4="+arr4.length;
        sout+=",arr5="+arr5.length;
        sout+=",arr6="+arr6.length;
        
        
        var comm = get_list_comm(arr1, arr2);
        sout+=",comm="+comm.length;
        
        var comm2 = get_list_comm(comm, arr3);
        sout+=",comm2="+comm2.length;
        
        var comm3 = get_list_comm(comm2, arr4);
        sout+=",comm3="+comm3.length;
        
        var comm4 = get_list_comm(comm3, arr5);
        sout+=",comm4="+comm4.length;
        
        var comm5 = get_list_comm(comm4, arr6);
        sout+=",comm5="+comm5.length;
        
        $("#cout").append(sout);
        
        var htm = htm_list2table(comm5);
        $("#cout").append(htm);
    });    
});//$(document).ready(function(){                                            



 
 