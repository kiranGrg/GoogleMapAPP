/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    windowResize();
});


function windowResize(){
    var windowHeight = $(window).height() - 5;
    var windowWidth = $(window).width();
    //lefmain sizing height
                
    //alert(windowWidth);
    var leftmain = $('#leftmain');
    leftmain.css({
        height :  windowHeight,
        marginLeft: 1
    });
                              
                 
    $('#directions').css('height',windowHeight);
       
       //alert(windowWidth * 0.20);
       
    $('#map_canvas').css('min-height',windowHeight)
    .css('min-width', (windowWidth - leftmain.width())-313);
                
    //tabpan sizing height
    var tab = $('#tab');
    $('#tabpan').css('min-height',windowHeight - tab.height());
    //alert(windowh);
                 
    //tab width sizing
    var lisize = tab.width();
    //alert(lisize);
    $('.tabclass1').css('width',(lisize * 0.3) -1);
    $('.tabclass2').css('width',(lisize * 0.3) -1);
    $('.tabclass3').css('width',(lisize * 0.3));
                      
}
            
$(window).resize(function(e) {
    windowResize();
});
  