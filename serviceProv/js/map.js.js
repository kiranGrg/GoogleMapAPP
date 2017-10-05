            
function init(){
    
//    mapOptions = {
//        zoom: 15,
//        center: center,
//        mapTypeId: google.maps.MapTypeId.ROADMAP
//    }
//     
//    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
                
//                alert("loading");

    existed_data_use = false;
    currentLocation();
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
            //alert(usercoord);
            addMarker(userLocation);
        }, function(err) {
            //alert('ERROR(' + err.code + '): ' + err.message);
            handleNoGeolocation(true);
        },options);
    }
    else{
        handleNoGeolocation(false);
    }
    
    return;
}


function handleNoGeolocation(errorFlag) {
//var content;
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
    
    //var infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
    
    return;
}


function addMarker(locationPoint){
    //alert("dami");
    
    var drag = false;
    geocoder.geocode( {
        'latLng': locationPoint
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            
            getLocationData(results);//function call to load the data for fields
            
                mapOptions = {  // features of a map... to be shown
                    zoom: 15,
                    center: results[0].geometry.location,
                    ////
                    mapTypeControl: false,
                    navigationControlOptions: {
                        style: google.maps.NavigationControlStyle.SMALL
                    },
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);//where to load a map
            

            marker = new google.maps.Marker({ //positioning marker in a map
            map: map,
            position: locationPoint,
            title: results[0].formatted_address,
            draggable: true
            });
            
            
            //marker adding
          
                google.maps.event.addListener(marker, 'click', function() { // seting a content to be displayed on clicking on a marker
                        infowindow.setContent(content);
                        infowindow.open(map,marker);
                    });


                clickListener = google.maps.event.addListener(map, 'click',function(event){
                   marker.setMap(null);
                   addMarker(event.latLng); 
                });

                dragListener = google.maps.event.addListener(marker, 'dragend', function(event) {
                    //console.log('dragged');
                   marker.setMap(null);
                   addMarker(event.latLng);

                });
            
        }
    });
       
    return;            
}

//function updateMarkerPosition(latLng){ // to upadate the user current location after dragging the marker
//    alert(latLng.lat()+" "+
//        latLng.lng());
//    usercoord = new google.maps.LatLng(parseFloat(latLng.lat()), parseFloat(latLng.lng()));
//    
//    return;
//}

function addMapClickListener(){
    clickListener = google.maps.event.addListener(map, 'click',function(event){
               marker.setMap(null);
               addMarker(event.latLng); 
            });
    
    dragListener = google.maps.event.addListener(marker, 'dragend', function(event) {
                //console.log('dragged');
               marker.setMap(null);
               addMarker(event.latLng);
                
            });
    //dragEnabled = true;
    
    return;
}

function removeClickListener(){
    //dragEnabled = false;
    google.maps.event.removeListener(clickListener);
    google.maps.event.removeListener(dragListener);
    
    return;
}

function getLocationData(jsonResult){
   if(serviceSection){
        //alert("hurray");
        $('#lat_id').val('');
        $('#lat_id').val(jsonResult[0].geometry.location.lat(), 6);
        $('#long_id').val(jsonResult[0].geometry.location.lng(), 6);
        $('#area_id').val(jsonResult[0].address_components[2].long_name);
    }
    else if(editSection){
        //alert(editSection);
        $('#edit_lat_id').val(jsonResult[0].geometry.location.lat(), 6);
        $('#edit_long_id').val(jsonResult[0].geometry.location.lng(), 6);
        $('#edit_area_id').val(jsonResult[0].address_components[2].long_name);
    }
    
    return;
}
            
   
        
      
function reFreshField(){
                
    $('#place').val('');
    $('#lat').val('');
    $('#lon').val('');
    $('#p2_type').val('');
    $('#area').val('');
             
    return;
}
            
//function setCenter(){
//    center = usercoord;
//    
//    mapOptions = {
//        zoom: 15,
//        center: center,
//        mapTypeId: google.maps.MapTypeId.ROADMAP
//    }
//    
//    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
//    
//    addMarker(usercoord);
//    
//    return;
//}     
       
            

            
