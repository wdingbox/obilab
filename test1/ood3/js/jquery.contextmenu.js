/**
 * jQuery plugin for Pretty looking right click context menu.
 *
 * Requires popup.js and popup.css to be included in your page. And jQuery, obviously.
 *
 * Usage:
 *
 *   $('.something').contextPopup({
 *     title: 'Some title',
 *     items: [
 *       {label:'My Item', icon:'/some/icon1.png', action:function() { alert('hi'); }},
 *       {label:'Item #2', icon:'/some/icon2.png', action:function() { alert('yo'); }},
 *       null, // divider
 *       {label:'Blahhhh', icon:'/some/icon3.png', action:function() { alert('bye'); }},
 *     ]
 *   });
 *
 * Icon needs to be 16x16. I recommend the Fugue icon set from: http://p.yusukekamiyamane.com/ 
 *
 * - Joe Walnes, 2011 http://joewalnes.com/
 *   https://github.com/joewalnes/jquery-simple-context-menu
 *
 * MIT License: https://github.com/joewalnes/jquery-simple-context-menu/blob/master/LICENSE.txt
 */
jQuery.fn.contextPopup = function(menuData) {


  //clear all previous bind before to build; 
  $(this).unbind();

  // Build popup menu HTML
  function createMenu(targetElement) {
    $(".contextMenuPlugin").remove();//remove old
    var img="<img src='"+D3Uti.ImgFile(targetElement)+"'></img>";
    var str="img :<input value='"+targetElement.img+"' size='3'></input><br>addr:<input size='3' value='"+targetElement.addr+"'></input>";
    var table="<table><tr><td>"+img+"</td><td>"+str+"</td></tr></table>";
    var title=menuData.title + "<hr/>"+table;
    var menu = $("<ul class='contextMenuPlugin'><div class='gutterLine'></div></ul>")
      .appendTo(document.body);
    if (menuData.title) {
      $("<li class='header'></li>").html(title).appendTo(menu);
    }
    menuData.items.forEach(function(item) {
      if (item) {
        var row = $('<li><a href="#"><img><span></span></a></li>').appendTo(menu);
        row.find('img').attr('src', item.icon);
        row.find('span').text(item.label);
        if (item.action) {
          row.find('a').on("click",item.action);
        }
      } else {
        $('<hr class="divider"></hr>').appendTo(menu);
      }
    });
    //menu.find('.header').text(menuData.title);
    return menu;
  }

  // On contextmenu event (right click)
  this.on('contextmenu', function(e) {
    //this.unbind();

    //$("*").css("cursor","default");
    var targetElement=D3Uti.shallowCopy(e.currentTarget.__data__);
    console.log("targetElement",targetElement);
    $.targetElement=targetElement;
    if(targetElement.addr==undefined){
        console.log("no menu for root");
        //return;
    }
    
    // Create and show menu
    var menu = createMenu(targetElement)
      .show()
      .css({zIndex:1000001, left:e.pageX + 5 /* nudge to the right, so the pointer is covering the title */, top:e.pageY+5})
      .on('contextmenu', function() { return false; });

    // Cover rest of page with invisible div that when clicked will cancel the popup.
    var bg = $('<div></div>')
      .css({top:'0px',left:'0px', width:'100%', height:'100%', position:'fixed', zIndex:1000000})
      .appendTo(document.body)
      .on('contextmenu click', function() {
        // If click or right click anywhere else on page: remove clean up.
        bg.unbind().remove();
        menu.unbind().remove();
        $(this).unbind();        
        menuData.cancelMenuOps();
        return false;
      });

    // When clicking on a link in menu: clean up (in addition to handlers on link already)
    menu.find('a').click(function() {      
      bg.unbind().remove();
      menu.unbind().remove();
      $(this).unbind();
    });
  


    // Cancel event, so real browser popup doesn't appear.
    return false;
  });
  return this;
};

