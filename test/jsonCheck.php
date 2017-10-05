<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type="text/javascript" src="jquery v1.9.1.js"></script>
        <script type="text/javascript" src="jquery.xdomainajax.js.js"></script>
        <style type="text/css">
            #container{
                width: 1200px;
                height: 600px;
                border: 2px solid black;
                margin: 1 px;
            }
        </style>
        <script type="text/javascript">
            var string = "nothing";
            $(function(){
                $('#load').click(function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    data();
                    //$('#container').load('http://google.com');
                    //                    $.ajax({
                    //                        url:"http://www.facebook.com/", 
                    //                        cache:false, 
                    //                        success:function(output){
                    //                            string = $(output.responseText).text()
                    //                            //$("#container").html(output);      
                    //                        },
                    //                        complete: function(){
                    //                            alert("complete");
                    //                            $("#container").html(string);     
                    //                        }
                    //                    });
                });
                
                $('#cross').click(function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    //$('#container').load('http://google.com');
                    crossDomain();
                });
                // SERIOUSLY!
 
               
            });
            
            function data(){
                $.ajax({

                    url:"http://www.odesk.com/api/profiles/v1/search/jobs.json?country=Ukraine&callback=?",

                    dataType: 'JSONP',

                    success:function(json){   

                        alert("Success: "+json.server_time);

                    },

                    error:function(){

                        alert("Error");

                    }

                });   
            }
            
            function crossDomain(){
               var result;
                
//                $('#container').load('http://www.nepalstock.com/datanepse/index.php .datatable', function(responseTxt,statusTxt,xhr){
//                    
//                    if(statusTxt == "success"){
//                        alert("loaded");
//                    }
//                    
//                    if(statusTxt == "error"){
//                        alert("Error: "+xhr.status+": "+xhr.statusText);
//                    }
//                    
//                });
                $.ajax({
                    url: 'http://www.nepalstock.com/datanepse/index.php',
                    type: 'GET',
                    success: function(res) {
                        //var headline = $(res.responseText).find('a.tsh').text();
                        //alert(headline);
                        result = res;
                        string = $(res.responseText).text();
                        
                    },
                    complete: function(){
                        alert(string);
                        $('body').html(string);
                    }
                });
                
                //alert("dami");
            }
        </script>
    </head>
    <body >
        <input type="submit" id="load" value="Load"/>
        <input type="submit" id="cross" value="Cross"/>
        
        <?php
        // put your code here
        ?>

    </body>
</html>
