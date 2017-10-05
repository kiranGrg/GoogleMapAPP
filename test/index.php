<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script src="jquery v1.9.1.js" type="text/javascript"></script>
        <script type="text/javascript">
            function bluePrint(){
                alert("loading");
            }
            $(function(){
                $('#sub1').click(function(){
                    alert("loading sub1 clicked data");
                    $.getJSON('api.php', function(data) {
//                        var output="<ul>";
//                        for (var i in data.users) {
//                            output+="<li>" + data.users[i].firstName + " " + data.users[i].lastName + "--" + data.users[i].joined.month+"</li>";
//                        }
//
//                        output+="</ul>";
//                        document.getElementById("output").innerHTML=output;
                        
                        var output="<ul>";
                        for(var i = 0; i < data.length; i++){
                            output+="<li>" + data[i] + " " + data[i] +"</li>";
                        }
                        output+="</ul>";
                        document.getElementById("output").innerHTML=output;
                        
                    });


//                    $.getJSON('getData.php', function(data) {
//                        var output="<ul>";
//                        for(var i = 0; i < data.length; i++){
//                            output+="<li>" + data[i].id + " " + data[i].name +"</li>";
//                        }
//                        output+="</ul>";
//                        document.getElementById("output").innerHTML=output;
//                    });
                
                });
                
                
                $('#sub2').click(function(){
                    $.ajax({                                      
                        url: 'getData.php',//'api.php', 
                        data: "",
                        dataType: 'json',                //data format      
                        success: function(data)          //on recieve of reply
                        {
                            //var id = data[0];              //get id
                            //var vname = data[1];
                            //var //get name
                            for(var i = 0; i < data.length; i++){
                                //$('#output').html("<b>id: </b>"+data['id']+"<b> name: </b>"+data['name']); //Set output element html
                                alert(data[i].id + " "+data[i].name);
                            }
                        } 
                    });
                });
            });
        
            //$(document).ready(function(){});
        </script>
    </head>
    <body onload="bluePrint()">
        <input type="submit" value="json data $.getJson()" id="sub1"/>
        <input type="submit" value="json data $.ajax()" id="sub2"/>
        <div id="output"></div>
    </body>
</html>
