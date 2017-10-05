<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style>
            #divR{
                width: 200px;
                height: auto;
                z-index: 10000;
                position: absolute;
            }

            body { font: normal 14px Verdana; }
            h1 { font-size: 24px; }
            h2 { font-size: 18px; }
            #sidebar { float: right; width: 30%; border: blue solid 1px; }
            #main { padding-right: 15px; }
            .infoWindow { width: 220px; }

        </style>
        <script type="text/javascript" src="../jQuery v1.9.1/jquery.js"></script>
        <script type="text/javascript" src="../php/jscoord-1.1.1.js"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyC6DR_-OOqZMc0TOv8ALfaEfZnqfwAkfMw&sensor=false"></script>
        <script type="text/javascript">
            var map;
            var mapOptions;
            var center = new google.maps.LatLng(27.710500,85.348449);
            var usercoord = center;
            var geocoder = new google.maps.Geocoder();
            var infowindow = new google.maps.InfoWindow();
            
            var directionsDisplay; // = new google.maps.DirectionsRenderer(rendererOptions);
            var directionsService = new google.maps.DirectionsService();
            var markerArray =  new Array();
            var marker;
            var locateMe = false;
            
            var pointArray = new Array();
            var point;
            
            var search = {
                'id': '',
                'name': '',
                'lat': '',
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
            
            $(function(){
                
                mapOptions = {
                    zoom: 15,
                    center: center,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                
                
                                
                
                map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
                
                                
                var rendererOptions = { draggable: true };
                directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
                
                google.maps.event.addListener(map, 'click', function(event) {
                    //point = new google.maps.LatLng(event.latLng.lat, event.latLng.lon);
                    //alert(event.latLng);
                    if(markerArray.length == 0){
                        directionsDisplay.setMap(null);
                        $('#directionsPanel').empty(); 
                    }
                    pointArray.push(event.latLng);
                    addMarker(event.latLng);
                });
                
                
                
            });
            
            function setRequest(from, to){
                var travelmode = "WALKING";
                var start = from;
                var destination = to;
                //var destination = new google.maps.LatLng(parseFloat($))
                var request = {
                    origin: start,
                    destination: destination,
                    unitSystem: google.maps.UnitSystem.METRIC,
                    travelMode: google.maps.DirectionsTravelMode[travelmode]
                };
                //alert("geeting data2");
                getDirectionDiscrip(request);
            }
            
            function getDirectionDiscrip(request){
                
                clearMarker();
                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById("directionsPanel"));
                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        $('#directionsPanel').empty(); // clear the directions panel before adding new directions
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
            
            function addMarker(locationPoint){
                geocoder.geocode( {
                    'latLng': locationPoint
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        
                        setMarkerDiscription(results); // to set the marker click action or contetnts
                        
                        if(locateMe){
                            mapOptions = {
                                zoom: 15,
                                center: results[0].geometry.location,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            }
                            map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
                        }
                        marker = new google.maps.Marker({
                            map: map,
                            position: locationPoint,
                            title: results[0].formatted_address
                        });
                        
                        
                        markerArray.push(marker);
                        
                        if(markerArray.length == 2){
                            clearMarker();
                            setRequest(pointArray[0], pointArray[1]);
                            pointArray.length = 0;
                        }
                    }
                });
       
                
            }
            
            function clearMarker(){
                for(var i = 0; i < markerArray.length; i++){
                    markerArray[i].setMap(null);
                }
                markerArray.length = 0;
            }
            
            function setMarkerDiscription(jsonResult){
            
                var order;
                //alert(jsonResult[0].address_components[1].long_name +", "+ jsonResult[0].address_components[2].long_name+", "+jsonResult[0].address_components[3].long_name);
                location_disp.name = jsonResult[0].address_components[1].long_name;
                location_disp.localArea = jsonResult[0].address_components[2].long_name;
                location_disp.zone = jsonResult[0].address_components[3].long_name;
                location_disp.country = jsonResult[0].address_components[6].long_name;
                
                if(pointArray.length == 1){
                    order = "From";
                }
                else{
                    order = "To";
                }
                
                $('<div style="padding: 6px; ">'+order+' : '+location_disp.name+'<br>'+
                    'Address : '+location_disp.localArea+
                    '</div>').appendTo('#dis');
                
            }
        </script>
    </head>
    <body>

        <section id="sidebar">
            <div id="directionsPanel"></div>
        </section>

        <section id="main">
            <div id="map_canvas" style="width: 70%; height: 500px; border: black solid 1px;"></div>
        </section>
        <section>
            <div id="dis" style="width: 50%; height: auto; border: red solid 1px; position: relative"></div>
        </section>
    </body>
</html>
