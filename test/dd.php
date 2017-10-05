<!DOCTYPE html>
<html>
    <head>
        <title>title</title>
        <script type="text/javascript">
            var successCallback = function(data) {
                console.log('latitude: ' + data.coords.latitude + ' longitude: ' + data.coords.longitude);
            };

            var failureCallback = function() {
                console.log('location failure :(');
            };

            var logLocation = function() {

                //determine if the handset has client side geo location capabilities
                if(navigator.geolocation){
                   navigator.geolocation.getCurrentPosition(successCallback, failureCallback);
                   alert()
                }
                else{
                   alert("Functionality not available");
                }
            };

            logLocation();
            setTimeout(logLocation, 5000);
        </script>
    </head>
    <body>
        <p>Testing</p>
    <body>
</html>