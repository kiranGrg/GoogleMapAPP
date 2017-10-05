<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php
require_once 'php-include/type_of_place.php';
$types = getData("type");
//print_r($types);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="css/front.css">
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyC6DR_-OOqZMc0TOv8ALfaEfZnqfwAkfMw&sensor=false"></script>
        <script type="text/javascript" src="js/jquery v1.9.1.js"></script>
        <script type="text/javascript" src="js/jscoord-1.1.1.js"></script>
        <script type="text/javascript" src="js/windowsize.js"></script>
        <script type="text/javascript" src="js/map.js.js"></script>
        <title>Custom</title>
        <script type="text/javascript">
            
            var map;
            
            //var center = new google.maps.LatLng(27.668304,85.348449);
            var geocoder = new google.maps.Geocoder();
            
            var marker;
            var mapOptions;
            //var usercoord;
            var content;
           
            
             //open it for full functioning page
           
            
            var location_disp = {
                'name': '',
                'localArea': '',
                'zone': '',
                'country': ''
            }
            
 
            
            //boolean whether service or edit Section is activated:
            
            var serviceSection = true, editSection = false;
            
            
            //listeners
          //  var clickListener, dragListener;
            
            //lol above must be filtered
            
            var user = {
                'id': '',
                'name': '',
                'lat': '',
                'long':'',
                'type':'',
                'area':'',
                'service_id':'',
                'notice':''
            }
            
            var key; //to edit
            
            //var area, type_name, name, long,lat, notice, id;//may be not needed
                    
            var service, title;
            
            var existed_data_use = false;
            
            
            
           $(function(){
               

               
               window.onload = init;
               
               //switching between tabs
               $('a').click(function(e){
                    e.preventDefault();
                    if($(this).hasClass('newService')){
                        $('#detailsView1').css('display', 'block');
                        $('#detailsView2').css('display', 'none');
                        serviceSection = true;
                        
                        clearAllData();
                        resetDataNewService();
                        
                        currentLocation();
                        
                        
                    }
                    else{
                        $('#detailsView2').css('display', 'block');
                        $('#detailsView1').css('display', 'none');
                        
                        serviceSection = false;
                        editSection = false;
                        
                        clearAllData();
                        clearDropdownValues('#edit_title_id'); //to clear the service titles
                        
                        key = prompt("Enter the key you are given with");
                   
                           if(key.trim() != ""){
                               checkIfKeyExist("key="+key,"ajax/getDataToEdit.php","#edit_title_id");
                           }
                           else{ 
                               $('.edit_table_header').text("Failed to Verify");
                               toDisableEmptyEditFields();
                               toDisableEditElements();
                           }
                    }
               });
               
               
               //to load a name of places or corporates as type is selected 
               //service entry section
               
               $('#type_name_id').change(function(){//for new customer add section
                   $('#checked_id').removeAttr('checked');
               });
               
               $('#type_id').change(function(){
                    $('#checked_id').removeAttr('checked');
                    var type = $(this).val(); 
                    if(type != ""){
                        loadDropdownValues("type="+type,"ajax/getPlaceItem.php","#type_name_id");
                    }
                    else{
                        
                        clearDropdownValues("#type_name_id");
                    }
                    
                });
                
                
                $('#checked_id').change(function(){
                    if($(this).is(':checked')){
                        //alert("checked");
                        existed_data_use = true;
                        user.name = $('#type_name_id').val();
                        loadData(user.name);//to load the existing data with name specified
                        
                    }
                    else{
                        //alert("unchecked");
                        removeDetails();
                        existed_data_use = false;
                    }
                });
                
                
                //test
                $('#add_id').click(function(){
                    
                    if($('#type_id').val().trim() !=""
                            && $('#name_id').val().trim() !=""
                            && $('#area_id').val().trim() !=""
                            && $('#long_id').val().trim() !=""
                            && $('#lat_id').val().trim() !=""
                            && $('#service_id').is(':checked')
                            && $('#title_id').val().trim() !="")
                    {
                        if(!existed_data_use)
                        {
                            user.type = $('#type_id').val();
                            user.name = $('#name_id').val();
                            user.area = $('#area_id').val();
                            user.long = $('#long_id').val();
                            user.lat = $('#lat_id').val();



                        }

                        title = $('#title_id').val();
                        //alert(title);
                        user.notice = $('#notice_id').val();
                        if($('#service_id').is(':checked')){
                            service = "yes";
                        }
                        else{
                            service = "no";
                        }

                        insertData();
                      }
                      else
                      {
                          if($('#service_id').is(':checked'))
                              
                      {
                                alert("Please Provide the full Data Needed.","Warning Incomplete Info");
                      }
                      else{
                          alert("Service should be on at First","Warning Incomplete Info");
                      }
                            
                    }     
                    
                    //alert("dami");
                });
                
                //upadate section
               $('#edit_show_id').click(function(){
                   var title = $('#edit_title_id').val();
                   if(title != ""){
                       loadServiceDetails("title="+title+"&key="+key,"ajax/getServiceData.php");
                   }
               });
               
               
               //action selection type
               
               $('#update_type_id').change(function(){
                  var action_type = $(this).val();
                  if(action_type != ""){
                      disableElements(action_type);
                  }
               });
               
               
               //update the data
               
               $('#edit_id').click(function(){
                   var new_area, new_lat, new_lon, new_title, new_notice, new_service, title;
                   var action_type = $('#update_type_id').val();
                       if(action_type == '1'){
                           if($('#edit_area_id').val().trim() != ""){
                            new_area = $('#edit_area_id').val();
                            new_lat = $('#edit_lat_id').val();
                            new_lon = $('#edit_long_id').val();

                           //alert(new_area+ new_lat + new_lon + user.id);
                            user.lat = new_lat;
                            user.lon = new_lon;
                            user.area = new_area;

                            updateData("area="+new_area+"&lat="+new_lat+"&lon="+new_lon+"&id="+user.id+"&action=1");
                           }
                           else{
                               alert("Please Provide Area it belongs.","Warning Incomplete Info");
                           }

                       }
                       else if(action_type == '2'){
                           if($('#edit_notice_id').val().trim() != ""){
                                title = $('#edit_title_id').val();
                                new_notice = $('#edit_notice_id').val();
                                if($('#edit_service_id').is(':checked')){
                                    new_service = "yes";
                                }
                                else{
                                    new_service = "no";
                                }
                                updateData("title="+title+"&notice="+new_notice+"&service="+new_service+"&key="+key+"&action=2");
                           }
                           else{
                               alert("Please Provide Notice.","Warning Incomplete Info");
                           }
                           
                            }
                       else if(action_type == '3'){
                           if($('#enter_title_id').val().trim() != "" && $('#edit_notice_id').val().trim() != "")
                               {
                                if($('#edit_service_id').is(':checked')){
                                    new_service = "yes";
                                }
                                else{
                                    new_service = "no";
                                }
                                new_notice = $('#edit_notice_id').val();
                                new_title = $('#enter_title_id').val();

                                updateData("title="+new_title+"&notice="+new_notice+"&service="+new_service+"&key="+key+"&id="+user.id+"&action=3");
                                
                                //to add new title to title list
                                
                                
                                $('<option value="'+$('#enter_title_id').val()+'">'+$('#enter_title_id').val()+'</option>').appendTo('#edit_title_id');
                                
                               }
                               else{
                                   alert("Please Provide Both Data title & Notice.","Warning Incomplete Info");
                               }
                       }

                       reSetDataUpdateSection();
                       
                       
                       
                           //alert("Please Provide the Required Data.","Warning Incomplete Info");
                       
    
            });
            
            
            $('#edit_title_id').change(function(){
                toClearNoticeServiceEdit();
            });
               
                
                //end of jquery functions
           });
           
           
           
           
           function updateData(url){
               $.ajax({
                  type:"POST",
                  data: url,
                  url: "ajax/updateData.php",
                  success: function(result){
                      alert(result);
                  },
                  complete: function(){
                  }
               });
               
               return;
           }
           
           function disableElements(action_type){
           
           toClearNoticeServiceEdit();
           toDisableEditElements();
           
               if(action_type == '1'){
                        editSection = true;
                        
                        
                        $('#edit_area_id').removeAttr('disabled');
//                        $('#edit_lat_id').removeAttr('disabled');
//                        $('#edit_long_id').removeAttr('disabled');
                        $('#edit_id').removeAttr('disabled');
               }
               else if(action_type == '2'){
                        editSection = false;
                        
                        $('#edit_title_id').removeAttr('disabled');
                        $('#edit_show_id').removeAttr('disabled');
                        $('#edit_notice_id').removeAttr('disabled');
                        $('#edit_service_id').removeAttr('disabled');
                        $('#edit_id').removeAttr('disabled');
                    }
               else if(action_type == '3'){
                        editSection = false;
                        
                        $('#edit_notice_id').removeAttr('disabled');
                        $('#edit_service_id').removeAttr('disabled');
                        $('#enter_title_id').removeAttr('disabled');
                        $('#edit_id').removeAttr('disabled');
               }
               else if(action_type == '0'){
                   $('#edit_id').attr('disabled',true);
               }
                
               $('#update_type_id').removeAttr('disabled');//redundancy
               
               return;
           }
           
           
           function toClearNoticeServiceEdit(){
               $('#edit_notice_id').val('');
               $('#enter_title_id').val('');
               $('#edit_service_id').prop('checked',false);
           }
           
           function loadServiceDetails(url, file_url){
               var data;
               $.ajax({
                   type:"POST",
                   data:url,
                   url:file_url,
                   success: function(result){
                       $('#edit_notice_id').val('');
                       data = $.parseJSON(result);
                   },
                   complete: function(){
                       $('#edit_notice_id').val(data[0]);
                       if(data[1] == 'yes'){
                           $('#edit_service_id').prop('checked', true);
                       }
                       else{
                            $('#edit_service_id').prop('checked', false);
                       }
                   }        
               });
               
               return;
           }
           
           
           /* end of edit section function */
           
           
           function clearAllData(){
               user.name = '';
               user.type = '';
               user.area = '';
               user.lat = '';
               user.long = '';
               user.id = '';
               user.service_id = '';
               user.notice = '';
               //toRemoveDisablesFromElement();
               
               return;
           }
           
           
           function removeDetails(){
               $('#name_id').val('');
               $('#area_id').val('');
               $('#lat_id').val('');
               $('#long_id').val('');
               
               
               return;
           }
           
           //function associated to edit section
           
           function reSetDataUpdateSection(){
               
               
               $('#edit_area_id').val(user.area);
               $('#edit_lat_id').val(user.lat);
               $('#edit_long_id').val(user.long);
               
               $('#edit_notice_id').val('');
               $('#enter_title_id').val('');
               
               $('#update_type_id option[value=""]').prop('selected', true);
               $('#edit_title_id option[value=""]').prop('selected', true);
               
               
               
               $('#edit_service_id').removeAttr('checked');
               
               toDisableEditElements();
               
               $('#update_type_id').removeAttr('disabled');
           }
           
           function displayPreDetails(){
               $('#name_id').val(user.name);
               $('#area_id').val(user.area);
               $('#lat_id').val(user.lat);
               $('#long_id').val(user.long);
               
               return;
           }
           
           function resetDataNewService(){
               removeDetails(); //lol haha
               
               $('#title_id').val('');
               $('#notice_id').val('');
               $('#service_id').removeAttr('checked');
               $('#checked_id').removeAttr('checked');
               
               return;
           }
           
           
           
           function toDisableEmptyEditFields(){
               $('#edit_lat_id').val('');
               $('#edit_area_id').val('');
               $('#edit_long_id').val('');
               $('#edit_notice_id').val('');
               $('#enter_title_id').val('');
               $('#edit_service_id').removeAttr('checked');
               
               //$('#update_type_id option[value=""]').prop('selected', true);
           }
           function toDisableEditElements(){
               $('#edit_title_id option[value=""]').prop('selected', true);
               $('#edit_lat_id').attr('disabled',true);
               $('#edit_area_id').attr('disabled',true);
               $('#edit_long_id').attr('disabled',true);
               $('#edit_title_id').attr('disabled',true);
               $('#edit_notice_id').attr('disabled',true);
               $('#edit_service_id').attr('disabled',true);
               $('#edit_show_id').attr('disabled',true);
               $('#edit_id').attr('disabled',true);
               $('#update_type_id').attr('disabled',true);
               $('#enter_title_id').attr('disabled',true);
               
               return;
           }
           
           function toRemoveDisablesFromElement(){
               $('#edit_area_id').removeAttr('disabled');
               $('#edit_lat_id').removeAttr('disabled');
               $('#edit_long_id').removeAttr('disabled');
               $('#edit_title_id').removeAttr('disabled');
               $('#edit_notice_id').removeAttr('disabled');
               $('#edit_service_id').removeAttr('disabled');
               $('#edit_show_id').removeAttr('disabled');
               $('#edit_id').removeAttr('disabled');
               $('#update_type_id').removeAttr('disabled');
               $('#enter_title_id').removeAttr('disabled');
               
               
               return;
           }
           
           
           
           
           function loadtab(tab_class){ //function to swtich between tabs 
               $('#detailsView').remove();
               if(tab_class == "newService"){
                $('<div id="detailsView" />').load('php-include/tableContent.php', function(){
                   $(this).appendTo('#leftmain');
                   });
               }
               else{
                   $('<div id="detailsView" />').load('php-include/editTableContent.php', function(){
                   $(this).appendTo('#leftmain');
                   });
                   
                   key = prompt("Enter the key you are given with");
                   
                   if(key.trim() != ""){
                       checkIfKeyExist("key="+key,"ajax/getDataToEdit.php","#edit_title_id");
                   }
                   else{ 
                       $('.edit_table_header').text("Failed to Verify");
                       toDisableEditElements();
                   }
                   
               }
               
               return;
           }
           
           
           function checkIfKeyExist(url, file_url, tag_id){
                var data;
                $.ajax({
                    type: "POST",
                    url: file_url,
                    data: url,
                    success: function(result){
                        clearDropdownValues(tag_id);
                        data = $.parseJSON(result);
                        
                    },

                    complete: function(){
                        toDisableEditElements();
                        if(data.length == 7){
                            $('#update_type_id').removeAttr('disabled');
                            loadDropdownValuesForSelection(data[0], tag_id);
                            setDetailsOfProvider(data[1],data[2],data[3],data[4],data[5],data[6]);
                        }
                        else{
                            $('.edit_table_header').text("Failed to Verify");
                            alert("Wrong key or Corporate has not been registered yet. Thank you");
                        }
                    }
                });
                
                return;
           }
           
           function setDetailsOfProvider(id, name, lat, lon, type_name, area){
                user.id = id;
                user.name = name;
                user.lat = lat;
                user.long = lon;
                user.type = type_name;
                user.area = area;
                
                //setting details
                
                $('.edit_table_header').text(user.name);
                $('#edit_area_id').val(user.area);
                $('#edit_lat_id').val(user.lat);
                $('#edit_long_id').val(user.long);
                
                usercoord = new google.maps.LatLng(parseFloat(lat), parseFloat(lon));
                setCenter(usercoord);
                
                return;
           }
           
           //
           function loadData(place){
               var data;
                $.ajax({
                    type: "POST",
                    url: "ajax/getData.php",
                    data: "name="+place,
                    success: function(result){
                        
                            data = $.parseJSON(result);
                        
                        
                    },

                    complete: function(){
                        if(data.length != 0){
                            for(var i = 0; i < data.length; i++){
                                user.id = data[i].id;
                                user.name = data[i].name;
                                user.lat = data[i].lat;
                                user.long = data[i].lon;
                                user.type = data[i].type;
                                user.area = data[i].area;
                            }
                            //existed_data_use = false;
                            displayPreDetails();
                        //alert(name);
                        }
                        else{
                            alert("Please use Edit Section with your previous key. You are already registered.thank you","Alert");
                        }
                    }
                });
                
                return;
           }
           
           function insertData(){
           
                $.ajax({
                    type: "POST",
                    url: "ajax/insertData.php",
                    data: "place="+user.name+"&lat="+user.lat+"&lon="+user.long+"&type="+user.name+"&area="+user.area+"&notice="+user.notice+"&service="+service+"&id="+user.id+"&title="+title,
                    success: function(result){
                        alert(result);
                    },
                    complete: function(){
                        //loadNewDropDownData(type, area);
                        resetDataNewService();
                    }
                });
                
                return;
            }
           
           
           function loadDropdownValues(url,file_url,tag_id){
                var data;
                $.ajax({
                    url: file_url,
                    async: false,
                    type: "POST",
                    data: url,
                    success: function(response){
                        clearDropdownValues(tag_id);
                        data = $.parseJSON(response);
                    },
                    complete: function(){
                          //$('<option value="">Select One</option>').appendTo(tag_id);
                          loadDropdownValuesForSelection(data, tag_id);
                    }
                });
                
                return;
            }
            
            function loadDropdownValuesForSelection(data, tag_id){
            
            for(var i = 0; i < data.length; i++){
                            $('<option value="'+data[i]+'">'+data[i]+'</option>').appendTo(tag_id);
                        }
                        
             return;
            }
            
            
            function clearDropdownValues(tag_id){
                
                //removing any previous data for destination list dropdown
                $(tag_id+' option')
                .filter(function() {
                    return this.value || $.trim(this.value).length != 0;
                })
                .remove();
                
                //$('<option value="">Select One</option>').appendTo('#name_id');
            
            
            return;
            }
           
        </script>
    </head>
    <body>
        <div id="main" class="clearfix">
            <div id="leftmain" class="lfloat">
               <div id="tab">
                    <ul id="tabid">
                        <li><a href="javascript: void(0);" class="newService">Wanna Provide Service</a></li>
                        <li><a href="javascript: void(0);" class="editService">Edit Services</a></li>
                    </ul>
                </div>
               
               
                <div id="detailsView1">
                    <?php require_once 'php-include/tableContent.php';?>
                </div>
                <div id="detailsView2">
                    <?php require_once 'php-include/editTableContent.php';?>
                </div>



            </div>


                <div id="map_canvas" class="rfloat">

                </div>

            </div>
    </body>
</html>