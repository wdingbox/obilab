
$(document).ready(function(){


TableColRowMgr.InsertColBefore($("#tt"),0);
    
});



var TableColRowMgr={
InsertColBefore:function(otbl, col){
    $(otbl).find("tr").each(function(i){
        $(this).find("th:eq("+col+")").before($("<th>#</th>"));
    });
    $(otbl).find("tr").each(function(i){
        $(this).find("td:eq("+col+")").before($("<td>"+i+"</td>"));
    });
},
InsertColAfter:function(otbl, col){
    $(otbl).find("tr").each(function(i){
        $(this).find("td:eq("+col+")").after($("<td>"+i+"</td>"));
    });
},
SetTD:function(tab, objArr){
    for(var i=0;i<objArr.length;i++){
        var obj=objArr[i];
        var selectedTd=tab+" tr:eq("+obj.irow+") td:eq("+obj.icol+")";
        $(selectedTd).html(obj.txt).css("background-color",obj.bgc);     
    }
},
    
};