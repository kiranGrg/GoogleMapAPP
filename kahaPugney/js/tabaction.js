/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    
    $('#nearCheck').click(function(){
        //if($('input[type="text"]').attr('disabled')){
        if($('#destination').attr('disabled')){
            $('#destination').removeAttr('disabled');
        }
        else{
            $('#destination').attr('disabled',true);
        }
    });
                
                 
    //tab pan selection 
//    $('a').click(function(){
//        if($(this).hasClass('tabclass1')){
//            $('#tabpan1').css('display', 'block');
//            $('#tabpan2').css('display', 'none');
//            //setMapAction = false;
//        }
//        else if($(this).hasClass('tabclass2')){
//            $('#tabpan2').css('display', 'block');
//            $('#tabpan1').css('display', 'none');
//            setCenter();
//            setMapAction = true;
//        }
//    });
});

            
