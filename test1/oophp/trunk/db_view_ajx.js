


var oid=57345;
$(document).ready(function(){     

				 
				 
				 $("img").click(function(event){
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
								   $(this).css("height", "200px");
								   $(this).css("width", "200px");
                           $(this).css("position", "absolute");
								   }).mouseout(function(event){
											   $(this).css("height", "");
											  $(this).css("width", "");
                                   $(this).css("position", "");
											  });


				 
				 $("body").keypress(function(e){
									var k = e.which;
								   //alert(e.ctrlKey);
								   }).keyup(function(e){
											$("body").attr("shiftKey",e.shiftKey);
										   $("body").attr("ctrlKey",e.ctrlKey);
										   //alert(e.ctrlKey);
										   }).keydown(function(e){
													  $("body").attr("shiftKey",e.shiftKey);
													 $("body").attr("ctrlKey",e.ctrlKey);
													 //alert(e.ctrlKey);
													 }).mousemove(function(e){
																  if($("body").attr("shiftKey")!=true) return;
																 $("div.sql_editor").show().css( {  
																								 position: 'absolute', 
																								 zIndex: 5000, 
																								 left: e.pageX/10000,  
																								 top: e.pageY-80 
																								 }); 
																 });
				 


				 });//$(document).ready(function(){                                            



