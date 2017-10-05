            
function init(){ 
    
    /*mapOptions = { // map variables
        zoom: 15,
        center: center,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
     
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    */            
   currentLocation(); // to locate the current location of a user
    
}


function currentLocation(){
    //alert("curr");
    var options = {
        enableHighAccuracy: true,
        timeout: 10000,
        maximumAge: 0
    };
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            user.lat = position.coords.latitude;
            user.lon = position.coords.longitude;
            var userLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        
            usercoord = userLocation;
            //alert('first '+ usercoord);
            addMarker(userLocation);
        }, function(err) {
            handleNoGeolocation(true); // to handle the situation when map location loading takes longer time
        },options);
    }
    else{
        handleNoGeolocation(false);  // to handle the error when geolocation is not working
    }
}


function handleNoGeolocation(errorFlag) { // to handle maps error
    if (errorFlag) {
        content = 'Error: The Geolocation service failed.';
    } else {
        content = 'Error: Your browser doesn\t support geolocation.';
    }

    var options = {
        map: map,
        position: new google.maps.LatLng(60, 105),
        content: content
    };
    
    map.setCenter(options.position);
}


function addMarker(locationPoint){ // to add marker on a google map at a geopoint given as an aargument
    var drag = false;
    geocoder.geocode( {   //geocode function
        'latLng': locationPoint
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
               
            if(help || locateMe){ // to enable a function while find place or discover tab is on
                getLocationData(results); // to set the marker click action or contetnts
            }   
            else if(surf){  // to enable a function while surf tab is on
                setMarkerDiscription(results);
            }
            
            if(locateMe){ // map options to locate user position range
                mapOptions = {  // features of a map... to be shown
                    zoom: 15,
                    center: results[0].geometry.location,
                    mapTypeControl: false,
                    navigationControlOptions: {
                        style: google.maps.NavigationControlStyle.SMALL
                    },
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);//where to load a map
            }
            
            
            if(locateMeFirst){ // to enable a drag option on marker to relocate the place while starting the apps
                drag = true;
            }
            
            
            marker = new google.maps.Marker({ //positioning marker in a map
                map: map,
                position: locationPoint,
                title: results[0].formatted_address,
                draggable: drag
            });
            
            
            //if else condition deuta bho check it here
            if(surf){ // to add a function while surfing on a map
                
                markerArray.push(marker);
                        
                if(markerArray.length == 2){ //to triger a function to clean up the previous records of map after 2 markers are added on map
                    $('#next').attr('disabled',false);
                    stravelmode = $('#stravelmode').val();
                    setRequestFromTo(pointArray[0], pointArray[1]); // triggering a function to calculate the direction between two co-ordinate points
                    pointArray.length = 0;
                }
            }
            else if(locateMe || help){ // to allow to add a content for each marker added on map
                google.maps.event.addListener(marker, 'click', function() { // seting a content to be displayed on clicking on a marker
                    infowindow.setContent(content);
                    infowindow.open(map,marker);
                });
            }
            
            
            
            
            ////////////// map event to allow a darg of maker
            google.maps.event.addListener(marker, 'dragend', function(event) {
                //console.log('dragged');
                updateMarkerPosition(marker.getPosition());
                
            });
                        
        }
    });
       
                
}

            
function updateMarkerPosition(latLng){ // to upadate the user current location after dragging the marker
//    alert(latLng.lat()+" "+
//        latLng.lng());
    usercoord = new google.maps.LatLng(parseFloat(latLng.lat()), parseFloat(latLng.lng()));
    //alert('after dragged '+usercoord);
}



function getLocationData(jsonResult){ // to find the geo-address of a marker added on map
            
    //alert(jsonResult[0].address_components[1].long_name +", "+ jsonResult[0].address_components[2].long_name+", "+jsonResult[0].address_components[3].long_name);
    location_disp.name = jsonResult[0].address_components[1].long_name;
    location_disp.localArea = jsonResult[0].address_components[2].long_name;
    location_disp.zone = jsonResult[0].address_components[3].long_name;
    location_disp.country = jsonResult[0].address_components[6].long_name;
    content = '<div class="infoWindow"><strong>'  + location_disp.name + '</strong><br/>'     
    + location_disp.localArea+', '+ location_disp.zone
    + '<br/>'     + location_disp.country + '</div>';
    if(help){ // to set the data on help content fields as we add the marker
        $("#place").val();
        $("#lat").val(jsonResult[0].geometry.location.lat(), 6);
        $("#lon").val(jsonResult[0].geometry.location.lng(), 6);
        $("#area").val(location_disp.name);
    }
                
    return;
}
            
function setMarkerDiscription(jsonResult){
            
    var order;
    location_disp.name = jsonResult[0].address_components[1].long_name;
    location_disp.localArea = jsonResult[0].address_components[2].long_name;
    //    location_disp.zone = jsonResult[0].address_components[3].long_name;
    //location_disp.country = jsonResult[0].address_components[6].long_name;
                
    if(pointArray.length == 1){
        order = "From";
    }
    else{
        order = "To";
    }
    
    //to add the description on surf panel
    $('<div style="padding: 6px; ">'+order+' : '+location_disp.name+'<br>'+
        'Address : '+location_disp.localArea+
        '</div>').appendTo('#location');
                
}     

function clearMarker(){ // to delete markers
    for(var i = 0; i < markerArray.length; i++){
        markerArray[i].setMap(null);
    }
    markerArray.length = 0;
}
 
 
function setRequestFromTo(from , to){ // function to find direction description
    var start = from;
    var destination = to;
                
    var request = {
        origin: start,
        destination: destination,
        travelMode: google.maps.DirectionsTravelMode[stravelmode]
    };
    getDirectionDiscrip(request);
}
            
function setRequest(to){ // to set a direction request 
    //alert(usercoord);
    var travelmode = $("input[name=travelmode]:radio:checked").val();//"DRIVING";
    //alert(travelmode);
    var start = usercoord;
    var destination = to;
                
    var request = {
        origin: start,
        destination: destination,
        unitSystem: google.maps.UnitSystem.METRIC,
        travelMode: google.maps.DirectionsTravelMode[travelmode]
    };
                
    getDirectionDiscrip(request);//set directions info in  id = directionsPanel
}
            
function getDirectionDiscrip(request){ // function to show dircetion description
    if(locateMe){
        marker.setMap(null);
    }            
    else if(surf && surf_first){
        //clearMarker();
        //$('#location').empty();
        //surf_first = false;
    }
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            
            clearDirectionPanel();// clear the directions panel before adding new directions
            directionsDisplay.setDirections(response);
        } else {
            // alert an error message when the route could nog be calculated.
            if (status == 'ZERO_RESULTS') {
                alert('No route could be found between the origin and destination.');
            } else if (status == 'UNKNOWN_ERROR') {
                alert('A directions request could not be processed due to a server error. The request may succeed if you try again.');
            } else if (status == 'REQUEST_DENIED') {
                alert('This webpage is not allowed to use the directions service.');
            } else if (status == 'OVER_QUERY_LIMIT') {
                alert('The webpage has gone over the requests limit in too short a period of time.');
            } else if (status == 'NOT_FOUND') {
                alert('At least one of the origin, destination, or waypoints could not be geocoded.');
            } else if (status == 'INVALID_REQUEST') {
                alert('The DirectionsRequest provided was invalid.');        
            } else {
                alert("There was an unknown error in your request. Requeststatus: nn"+status);
            }
        }
    });
}
 
function clearDirectionPanel(){
    $('#directionsPanel').empty();
}
   
function getNameOnly(place){ // to get the places added on db
    var array = new Array();
    $.ajax({
        type : "GET",
        url : "ajax/nepal_locations.php",
        success: function(response){
            var data = $.parseJSON(response);
            for(var i = 0; i < data.length; i++){
                array[i] = data[i].name;
            }
        },
        complete: function(){
            if($.inArray(place, array) > -1){
                alert("Place with Same is already in database! Please Try with next one.")
                $('#place').val('');
            }
        }
    });
}
            
function searchNearest(type, area){ // to find the nearest location
    $.ajax({
        type: "POST",
        url: "ajax/nepal_locations.php",
        data: "type="+type+"&area="+area,
        success: function(data){
            var jdata  = $.parseJSON(data);
            if(jdata.length == 0){
                alert("no such place is recorded");
            }
            else{
                getShortest(jdata);
            }
        },
        complete: function(){
            max = 10000000;
            var to = new google.maps.LatLng(parseFloat(shortest.lat), parseFloat(shortest.lon));
            setRequest(to);
        }
    }); 
}
            
            
function searchRequest(url, file_url, id){
    $.ajax({
        type: "POST",
        url: file_url,
        data: url+"&id="+id,
        success: function(result){      
            var data = $.parseJSON(result);
            for(var i = 0; i < data.length; i++){
                search.id = data[i].id;
                search.name = data[i].name;
                search.lat = data[i].lat;
                search.lon = data[i].lon;
                search.type = data[i].type;
                search.area = data[i].area;
                if(id == 2){
                    search.service_id = data[i].service_id;
                    search.notice = data[i].notice;
                }
            }
        },
                        
        complete: function(){
   //alert(search.id+search.name+search.area+search.type+search.lat+search.lon+" and "+search.service_id+search.notice);
           
           if(id == 2){
                   $('#details_div').empty();
                   $('<div style="padding: 6px; ">Notice:\n'+search.notice+
                    '</div>').appendTo('#details_div');
                       }

            //alert(search.lat)
            var to = new google.maps.LatLng(parseFloat(search.lat), parseFloat(search.lon));
            setRequest(to);
            
        }
    });
}
            
            
function insertData(place, lat, lon, type, area){
    $.ajax({
        type: "POST",
        url: "ajax/insertData.php",
        data: "place="+place+"&lat="+lat+"&lon="+lon+"&type="+type+"&area="+area,
        success: function(result){
            alert(result);
        },
        complete: function(){
            loadNewDropDownData(type, area);
        }
    });
}
            
            
function loadNewDropDownData(type, area){
    var sel_type = $.map($('#p1_type option'), function(e) {
        return e.value;
    });
    var sel_area = $.map($('#a1_type option'), function(e) {
        return e.value;
    });
    if($.inArray(type, sel_type) == -1){
        $('<option value="'+type+'">'+type+'</option>').appendTo('#p1_type');
    }
    if($.inArray(area, sel_area) == -1){
        $('<option value="'+area+'">'+area+'</option>').appendTo('#a1_type');
    }
                
    marker.setMap(null);
    reFreshField();
}
            
function reFreshField(){
                
    $('#place').val('');
    $('#lat').val('');
    $('#lon').val('');
    $('#p2_type').val('');
    $('#area').val('');
                
}
            
function setCenter(geocenter){
    reFreshField();
    if(geocenter != ''){
        center = usercoord;
    }
    mapOptions = {
        zoom: 15,
        center: usercoord,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    if(help || surf){
                    
        google.maps.event.addListener(map, 'click', function(event) {
            if(surf){
                
                if(markerArray.length == 2){
                    directionsDisplay.setMap(null);
                    //clearDirectionPanel();
                }
                pointArray.push(event.latLng);
                if(marker_count == 3){
                    //$('#location').empty();
                    maker_count = 0;
                }
                marker_count++;
            }
            else if(help){
                marker.setMap(null);
            }
            addMarker(event.latLng);
        //alert(event.latLng);
        });
    }
    else{
        addMarker(usercoord);
    }
}
         
           
function getShortest(jdata){
//    var jdata  = $.parseJSON(data);
    for (var i = 0; i < jdata.length; i++) {
        var R = 6371; // km
        var d = Math.acos(Math.sin(parseFloat(user.lat))*Math.sin(parseFloat(jdata[i].lat)) + 
            Math.cos(parseFloat(user.lat))*Math.cos(parseFloat(jdata[i].lat)) *
            Math.cos(parseFloat(user.lon)-parseFloat(jdata[i].lon))) * R;
        if(d < max){
                    
            max = d;
            shortest.name = jdata[i].name;
            shortest.lat = jdata[i].lat;
            shortest.lon = jdata[i].lon;
            shortest.area = jdata[i].area;
        }
    }
                    
}
            
            

            
