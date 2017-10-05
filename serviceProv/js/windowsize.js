/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    windowResize();
});


function windowResize(){
    var windowHeight = $(window).height() - 5;
    var windowWidth = $(window).width() - 20;
    //lefmain sizing height
                
    //alert(windowWidth);
    
   
       
       //alert(windowWidth * 0.20);
    var map = $('#map_canvas');
       
    
    
    var leftmain = $('#leftmain');
    leftmain.css({
        height :  windowHeight - map.height(),
        width : windowWidth - 800
    });
           
    map.css('height',windowHeight)
    .css('width', windowWidth - leftmain.width() + 13);
    //tabpan sizing height
//    var tab = $('#tab');
//    $('#tabpan').css('min-height',windowHeight - tab.height());
    //alert(windowh);
                 
    //tab width sizing
//    var lisize = tab.width();
//    //alert(lisize);
//    $('.tabclass1').css('width',(lisize * 0.3) -1);
//    $('.tabclass2').css('width',(lisize * 0.3) -1);
//    $('.tabclass3').css('width',(lisize * 0.3));
                      
}
            
$(window).resize(function(e) {
    windowResize();
});
  