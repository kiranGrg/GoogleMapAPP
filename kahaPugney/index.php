<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php
require_once 'php/type_of_place.php';
//$types = getData("type");
$areas = getData("area");
$services = getOnlineServices();
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

        <script type="text/javascript" src="auto/autocomplete.js"></script>
        <link type="text/css" href="auto/autocomplete.css" rel="stylesheet"/>
        <title>GoogoApp</title>
        <script type="text/javascript">
            //$(document).ready(function(){});
            //jaula 27.672865, 85.313580
            //patan hos 27.668304, 85.320704
            //
            //
//dummy values
           var my = new google.maps.LatLng(27.670703,85.303704299);
            var patan = new google.maps.LatLng(27.668304, 85.320704);
            
            var map;
            var center = new google.maps.LatLng(27.668304,85.348449);
            var geocoder = new google.maps.Geocoder();
            var infowindow = new google.maps.InfoWindow();
            var directionDisplay;
            var directionsService = new google.maps.DirectionsService();
            var marker;
            var mapOptions;
            var usercoord;
            var content;
            var pointArray = new Array();
            var point;
            var markerArray = new Array();
            //var canvas = document.getElementById("map_canvas");
            
            
             //open it for full functioning page
            
            var user = {
                'lat': '',
                'lon': ''
            }
            
            var shortest = {
                'id':'',
                'name':'',
                'lat':'',
                'lon':'',
                'type':'',
                'area':''
            }
            
            var location_disp = {
                'name': '',
                'localArea': '',
                'zone': '',
                'country': ''
            }
            
            var mylocation={
                'geolocation' : '',
                'address' : '',
                'content' : ''
            }
            
            var search = {
                'id': '',
                'name': '',
                'lat': '',
                'lon':'',
                'type':'',
                'area':'',
                'service_id':'',
                'notice':''
                
            }
            //variable used to select travelmode
            var stravelmode;
            
            
            var search_list = '';//store latest search 
            //used in ajax field area
            var result;
            var s_data;
            var max = 10000000;
            
            
            //to add marker set boolean
            var locateMe = true;
            var help = false;
            var surf = false;
            var surf_firts = false;
            var locateMeFirst = true;
            var marker_count = 0;
            
            var titlel = "my curret location";
           
            
            $(function(){
                
                
                var rendererOptions = { draggable: true };
                directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
                
                window.onload = init;
                
                
                $('#nearCheck').click(function(){
                //if($('input[type="text"]').attr('disabled')){
                    if($('#destination').attr('disabled')){
                        $('#destination').removeAttr('disabled');
                    }
                    else{
                        $('#destination').attr('disabled',true);
                    }
                });
                
                $('#a1_type').change(function(){
                    
                    //alert("dami");
                    var area = $(this).val();
                    if(area != "  "){
                        //loadPlaceType(area);
                        loadDropDownValues("area="+area+"&id=1","ajax/getPlaceItem.php","#p1_type",0);
                    }
                    else{
                        clearDropdownValues("#p1_type");
                    }
                    
                });
                
                $('#p1_type').change(function(){
                    var area = $('#a1_type').val();
                    var type = $(this).val(); 
                    if(type != ""){
                        loadDropDownValues("area="+area+"&type="+type+"&id=2","ajax/getPlaceItem.php","#destination",0);
                    }
                    else{
                        clearDropdownValues("#destination");
                    }
                    
                });
                
                
                //jquery for loading data to calculate shortest distance place
                $('#search').click(function(){
                    
                    
                    if($('#nearCheck').is(":checked")){
                        var type = $('#p1_type').val().trim();
                        var area = $('#a1_type').val().trim();
                        searchNearest(type, area);
                    }
                    else{
                        if($('#destination').val() != ""){
                            searchRequest("name="+$('#destination').val(),"ajax/getDestiCoord.php",1);
                        }
                        else{
                            
                            alert("Please Provide the Info for search Engine...");
                        }
                        
                    }
                });
                
                
                
                
                //action tabpans
                $('a').click(function(e){
                    e.preventDefault();
                    if($(this).hasClass('tabclass1')){
                        $('#tabpan1').css('display', 'block');
                        $('#tabpan2').css('display', 'none');
                        $('#tabpan3').css('display', 'none');
                        locateMe = true;
                        help = false;
                        surf = false;
                        locateMeFirst = false;
                        clearMapData();
                        resetDataForSearchSection();
                        setCenter("usercoord");
                    }
                    else if($(this).hasClass('tabclass2')){
                        $('#tabpan2').css('display', 'block');
                        $('#tabpan1').css('display', 'none');
                        $('#tabpan3').css('display', 'none');
                        locateMe = false;
                        help = true;
                        surf = false;
                        locateMeFirst = false;
                        clearMapData();
                        reFreshField();
                        setCenter("");
                        
                    }
                                        
                    else if($(this).hasClass('tabclass3')){
                        $('#tabpan1').css('display', 'none');
                        $('#tabpan2').css('display', 'none');
                        $('#tabpan3').css('display', 'block');
                        locateMe = false;
                        surf = true;
                        help = false;
                        locateMeFirst = false;
                        //$('#location').empty();
                        //clearDirectionPanel();
                        clearMapData();
                        setCenter("");
                        
                        
                    }
                });
                
                
             /*   ///autocomlete for destination place
                
                $('#destination').keydown(function(){
                    var type = $('#p1_type').val().trim();
                    var area = $('#a1_type').val().trim();
                    setAutoComplete("destination", "resultAppend", "auto/autocomplete_1.php?part=",type,area);
                    
                });
    
    */
                
                //insert data to database
                $('#insert').click(function(){
                    var place = $('#place').val();
                    var lat = $('#lat').val();
                    var lon = $('#lon').val();
                    var type = $('#p2_type').val();
                    var area = $('#area').val();
                    
                    if(place.trim().length > 0 && area.trim().length > 0 && type.trim().length > 0){
                        insertData(place, lat, lon, type, area);
                    }
                    else{
                        alert("Please Fill Up the Field..");
                    }
                    
                });
                
                
                $('#place').blur(function(){
                    getNameOnly($('#place').val().trim());
                });
                
                $('#clear').click(function(){
                  
                    clearMapData();
                });
                
            
                
                $('#stravelmode').change(function(){
                    stravelmode = $(this).val();
                });
                
                
                
                //service search section jquery functions
                //function arguments url request, file url, id
                $('#service_type_id').change(function(){
                    var service_type = $(this).val();
                    
                    if(service_type != ""){
                        //alert(service_type);
                        $('#service_pro_id').removeAttr('disabled');
                        loadDropDownValues("type="+service_type+"&id=3","ajax/getPlaceItem.php","#service_pro_id",0);
                    }
                    else{
                        //alert("delete");
                        clearDropdownValues("#service_pro_id");
                    }
                });
                
                
                $('#service_pro_id').change(function(){
                    //alert("dami");
                    var service_pro_name = $(this).val();
                    if(service_pro_name != ""){
                        $('#service_title_id').removeAttr('disabled');
                        loadDropDownValues("name="+service_pro_name,"ajax/getTitleForProName.php",'#service_title_id',1);
                        //searchRequest("name="+service_pro_name,"ajax/getDestiCoord.php",2);//function to get service details
                    }
                    else{
                        clearDropdownValues("#service_title_id");
                        clearDropdownValues("#service_title_no_id");
                    }
                });
                
                $('#service_title_id').change(function(){
                    var service_title = $(this).val();
                    
                    if(service_title != ""){
                        var service_title_id = $("#service_title_no_id option[value='"+$(this).val()+"']").text();
                        //alert(service_title_id);
                        searchRequest("title="+service_title+"&stable_id="+service_title_id,"ajax/getDestiCoord.php",2);
                    }
                    else{
                        alert("Please choose among the given services. thank you","NOtice");
                    }
                });
               
            });
            
            
            
            //function to clear all the details of map:
            
            function clearMapData(){
                
                clearMarker(); 
                markerArray.length = 0;
                search_list = '';
                pointArray.length = 0;
                $('#directionsPanel').empty();
                $('#location').empty();
                directionsDisplay.setMap(null);
            }
            
            
            //function to load the option vlaues for service provider names
            
            function loadDropDownValues(url, file_url, tag_id, opt){
                var data;
                $.ajax({
                    url: file_url,
                    async: false,
                    type: "POST",
                    data: url,
                    success: function(response){
                        //alert(response);
                        clearDropdownValues(tag_id);
                        if(opt == 1){
                            clearDropdownValues("#service_title_no_id");
                        }
                        data = $.parseJSON(response);
                    },
                    complete: function(){
                    //toAddDropDownValuesExtended(data, tag_id, opt);
                
                        if(opt == 1){
                            toAddDropDownValuesExtended(data[1], tag_id);
                            toAddDropDownValuesForHiddenTitle(data[0], data[1], "#service_title_no_id");
                        }
                        else if(opt == 0){
                            toAddDropDownValuesExtended(data, tag_id);
                        }
                    }
                });
            }
            
            function toAddDropDownValuesExtended(data, tag_id){
                for(var i = 0; i < data.length; i++){
                                $('<option value="'+data[i]+'">'+data[i]+'</option>').appendTo(tag_id);
                            }
            }
            
            function toAddDropDownValuesForHiddenTitle(text, value, tag_id){
                for(var i = 0; i < text.length; i++){
                                $('<option value="'+value[i]+'">'+text[i]+'</option>').appendTo(tag_id);
                            }
            }
            
            
            //function to clear the dropdown option values for places listed
            function clearDropdownValues(tag_id){
                
                //removing any previous data for destination list dropdown
                $(tag_id+' option')
                .filter(function() {
                    return this.value || $.trim(this.value).length != 0;
                })
                .remove();
                
            
            }
            
            function resetDataForSearchSection(){
                $('#nearCheck').removeAttr('checked');
                clearDropdownValues('#p1_type');
                clearDropdownValues('#destination');
                clearDropdownValues('#service_pro_id');
                clearDropdownValues('#service_title_id');
                $('#service_pro_id').removeAttr('disabled');
                $('#service_title_id').removeAttr('disabled');
            }
        
            /* 
             * To change this template, choose Tools | Templates
             * and open the template in the editor.
             */
         
        </script>
    </head>
    <body>
        <div id="main">
            <div id="leftmain">
                <div id="tab">
                    <ul id="tabid">
                        <li><a href="javascript: void(0);" class="tabclass1">Find Place</a></li>
                        <li><a href="javascript: void(0);" class="tabclass2">Discover</a></li>
                        <li><a href="javascript: void(0);" class="tabclass3">Surf Map</a></li>
                    </ul>
                </div>



                <div id="tabpan1">
                    <?php require_once 'php/findWithPlaces.php'; ?>
                    <?php require_once 'php/findWithServices.php'; ?>
                    <div id="divNotice"">
                        
                        <!-- details goes here extracted from database -->
                    </div>
                </div>



                <div id="tabpan2">
                    <?php require_once 'php/discoverNewPlace.php'; ?>
                </div>

                <div id="tabpan3">
                    
                    <?php require_once 'php/exploreSection.php'; ?>
                </div>

            </div>
            <div id="map_canvas">

            </div>
            <div id="directions">
                <div id="directlebel">
                    <strong>Direction Information:</strong> 
                </div>
                <div id ="directionsPanel">
                </div>
            </div>
        </div>
    </body>
</html>
