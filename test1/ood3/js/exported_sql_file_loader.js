
//C:\wamp\www\trellis\public\wd\ttt\wroot\oophp\app_dbm\exported_fr_mysql\Jiaguwen.sql
function exported_sql_file_loader(){
    
    this.loadFile=function(surl){
        return $.ajax({
            type: "GET",
            url: surl,
            async: false,
            dataType:"text"
        }).responseText; 
    };
    this.sqlTxt=this.loadFile("../../../../oophp/app_dbm/exported_fr_mysql/Jiaguwen.sql");
    this.sqlLinesArr=this.sqlTxt.split("\n");
    this.sqlTxt="";
    
    this.sout="";
    this.soutSqlTxtFile=function(){        
        this.sout=this.sqlLinesArr.join("<br/>");
    };
    
    this.jidImgPath="../../../../odb/tbi/img/jgif/";
    
    this.jidImgPath="../../../../../___bigdata/___compact/___solid/odb/tbi/img/jgif/";
    
    
    this.getImg=function(imgName){
        imgName=$.trim(imgName);
        imgName=imgName.replace(",",'');
        if(imgName.length==0) return "";
        var img="<img src='"+this.jidImgPath+imgName+".gif'></img>";
        return img;
    };
    
    this.parseTableInfo=function(){
        for(var i=0;i<this.sqlLinesArr.length;i++){
            var sln=this.sqlLinesArr[i];
            
            //INSERT INTO `Jiaguwen` (`idx`, `jid`, `zid`, `zid1`, `freq`, `jnm`, `rid`, `jink`, `jtoh`, `pyn`, `eng`, `descr`, `L`, `xa`, `xb`, `xc`) VALUES           
            if(undefined==this.colInfoArr){
                var ret=sln.match(/^CREATE TABLE IF NOT EXISTS `Jiaguwen`/);               
                if( ret ){
                    this.colInfoArr=[];
                    while(1){
                        i++;
                        sln=this.sqlLinesArr[i];
                        var re=sln.match(/^[\s]*[`][\w]+[`]\s*/);
                        if(re){
                            var obj={name:re[0]};
                            if( sln.match(/[\s]+int[\(]/)){
                                obj.datype="int";
                            }
                            else if( sln.match(/char[\(]/) ){
                                obj.datype="chars";
                            }
                            else{
                                console.log("Fatal Error!!!!!!!!!!!!!!");
                                break;
                            };
                            this.colInfoArr.push(obj);
                        }//if
                        else{                           
                            this.colNamesArr=[];
                            for( k in this.colInfoArr){
                                this.colNamesArr.push(this.colInfoArr[k]['name']);
                            }
                            console.log(JSON.stringify(this.colNamesArr));
                            console.log(JSON.stringify(this.colInfoArr));
                            console.log("end");
                            break;
                        }
                    }//while
                    break;                    
                }
                continue;
            }
        }        
    };
    this.parse2RowsCols=function(){
        //var ss="";
        this.rowsArr=[];
        var totLines=0;
        for(var i=0;i<this.sqlLinesArr.length;i++){
            var sln=this.sqlLinesArr[i];
            //(1, 62880, 35998, 36126, 46914, '5.2.2.5.z.0', 0, '', '', 'zhen1', 'eng', 'descssss', '5', 'r', '', '-'),
            
            var ret=sln.match(/^[\(].*[\)][,|;]$/g);
            if(ret==null) continue;
            
            //var res = sln.match(/([\d]{1,5}[,])|(['][^']*['][,]*)/g);
            var cols = sln.match(/([\d]{1,6}[,])|(['][^']*['][,]*)|(NULL[,])/g);
            if(cols){
                //ss+=this.getImg(cols[1]);
                //ss+=sln+"<br/>";
                //ss+=cols.join(" | ")+"====>"+cols.length+"<hr/>";
                totLines++;
                var iIdx=parseInt(cols[0]);
                if(iIdx!=totLines){
                    console.log(totLines+"!="+iIdx+" "+sln);
                    alert("row number err");
                }
                if(cols.length != 16){
                    alert("col number err");
                }
                this.rowsArr.push(cols);
            }
        }
    };
    this.parseTableInfo();
    this.parse2RowsCols();
    this.trimRowsCols=function(){
        for(var i=0;i<this.colNamesArr.length;i++){
            this.colNamesArr[i]=$.trim(this.colNamesArr[i].replace(/[`]/g,""));
        }

        for(var i=0;i<this.rowsArr.length;i++){
            var cols=this.rowsArr[i];
            for(var k=0;k<cols.length;k++){
                cols[k] = cols[k].replace(/[,]$/, "");//remove last [,]
                cols[k] = cols[k].replace(/[']/g, "");//remove all [']
            }
        }
    };
    
    this.soutRowsCols2Table=function(){
        this.soutRowsCols2TableForRowsArr(this.rowsArr);
    };
    this.soutRowsCols2TableForRowsArr=function(rowsArr){
        var totLines=rowsArr.length;
        var ss=totLines+"<table border='1'><tr><th>"+this.colNamesArr.join("</th><th>") + "</th></tr>";
        for(var i=0;i<rowsArr.length;i++){
            ss+="<tr>";//<td>"+(1+i)+"</td>";
            for(var j=0;j<rowsArr[i].length; j++){
                var txt=rowsArr[i][j];
                var cls=" class=\""+this.colNamesArr[j]+"\"";
                //if(j==1)txt+=this.getImg(txt);
                ss+="<td"+cls+">"+txt+"</td>";
            }
            ss+="</tr>";
        }
        ss+="</table>";
        ss+="<script>";
        ss+="$('td').bind('click',clk_td);";
        ss+="$('th').bind('click',clk_th);";
        ss+="</script>";
        this.sout=ss;
        //$(id).html("totLines="+totLines+"<br/>"+ss);
    };
    
    this.soutRowsCols2SqlTxt=function(){
        var totLines=this.rowsArr.length;
        var ss="";
        for(var i=0;i<this.rowsArr.length;i++){
            ss+=this.Rows2SqlLine(this.rowsArr[i]);
            ss+="<br/>";
        }
        this.sout=ss;
            
    };
    this.Rows2SqlLine=function(colsArr){
        var ss="(";
        for(var i=0;i<colsArr.length; i++){
            var txt =""+colsArr[i];
            var inf=this.colInfoArr[i];            
            switch(inf.datype){
                case "int":
                    ss+=txt+", ";
                break;
                case "chars":
                    if("NULL"==txt){
                        ss+=txt+", ";
                    }
                    else{
                        ss+="'"+txt+"', ";
                    }
                break;
                default:
                    console.log("Fatal Errors");
                break;                
            }            
        }
        ss=$.trim(ss);
        ss=ss.replace(/[,]$/,'');//revmode last [,]
        return ss+"),";
    };
    
    this.soutFilterRowsCols=function(colname,regstr){
        var reg=new RegExp(regstr, 'g');
        var colidx=this.colNamesArr.indexOf(colname);
        if(colidx<0) return alert("colname not found:"+colname);
        var arr=[];
        for(var i=0;i<this.rowsArr.length;i++){
            var str=this.rowsArr[i][colidx];
            if(str.match(reg)){
                arr.push(this.rowsArr[i]);
            }
        }
        arr.sort(function(a,b){
            var a1=""+a[colidx];
            var b1=""+b[colidx];
            return a1.localeCompare(b1);            
        });
        this.soutRowsCols2TableForRowsArr(arr);
    };
    return;
}/////////////////////////////





var sqlloader=new exported_sql_file_loader();
$(function() {
    
    $("#selop").change(function(){
        var val=$(this).val();
        switch(val){
            case "showSqlFileTxt":
            sqlloader.soutSqlTxtFile();
            break;
        case "showRowsCols2Table":
            sqlloader.soutRowsCols2Table();
            break;
        case "trimRowsCols":
            sqlloader.trimRowsCols();
            sqlloader.soutRowsCols2Table();
            break;
        case "showRowsCols2SqlTxt":
            sqlloader.soutRowsCols2SqlTxt();
            break;  
        case "convert_odb_table_to_d3_ooTree_show_on":
            D3Uti.convert_odb_table_to_d3_ooTree_show_on("#sout");
            sqlloader.sout=D3Uti.sout;
            break;
        case "jidRegExLogo":
            $("#sinp").val("^[1|2|3|4][\w]*");
            $(this).val("");
            return;
        case "jidRegExPicto":
            $("#sinp").val("^[5][\w]*");
            $(this).val("");
            return;
        default:
            sqlloader.sout="";
        break;
        }
        $("#sout").html(sqlloader.sout);
    });
    
    
});

function clk_th(){    
    var idx=$(this).index();
    var obj=sqlloader.colInfoArr[idx];
    console.log("clk_th:"+JSON.stringify(obj));
    var colname=$(this).text();
    $("#info").text(colname);
    var regstrn=$("#sinp").val();
    sqlloader.soutFilterRowsCols(colname,regstrn);
    
    //sqlloader.soutRowsCols2Table();
    $("#sout").html(sqlloader.sout);
}
function clk_td(){
    var cls=$(this).attr("class");
    var txt=$(this).text();
    $(this).attr("title",cls);
    console.log("clk_td:"+cls);
    switch(cls){
        case "jid":
            $(this).html("<a>"+txt+"</a>"+sqlloader.getImg(txt));
            break;
        case "jink":
            var arr=txt.split(",");
            var ss="";
            for(var i=0;i<arr.length;i++){
                var txt=arr[i];
                if(txt.length>0){
                    ss+="<a>"+txt+"</a>"+sqlloader.getImg(txt)+",";
                }
            }
            $(this).html(ss);
            break;
        default:
            break;
    }
    
}

















