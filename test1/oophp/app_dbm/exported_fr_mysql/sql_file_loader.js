
//C:\wamp\www\trellis\public\wd\ttt\wroot\oophp\app_dbm\exported_fr_mysql\Jiaguwen.sql
function sql_exported_file_loader(){
    this.url
    this.treeTxt = $.ajax({
        type: "GET",
        url: "../../../../oophp/app_dbm/exported_fr_mysql/Jiaguwen.sql",
        async: false,
        dataType:"text"
    }).responseText; 
    
    this.sqlLinesArr=this.treeTxt.split("\n");
    
    
    this.appendTo(id){
        $(id).append(this.treeTxt);
    }
    return;
}

var sqlloader=sql_exported_file_loader();
sqlloader.appendTo("#sout");