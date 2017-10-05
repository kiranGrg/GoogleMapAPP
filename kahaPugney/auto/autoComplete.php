<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
<title>Ajax autocomplete using PHP &amp; MySQL</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="autocomplete.css" type="text/css" media="screen">
<script src="jquery.js" type="text/javascript"></script>
<script src="dimensions.js" type="text/javascript"></script>
<script src="autocomplete.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function(){
	    setAutoComplete("searchField", "results", "autocomplete_1.php?part=");
	});
</script>
</head>

<body>
	<h1>Ajax autocomplete using PHP &amp; MySQL</h1>
	<p id="auto">
		<label>Location: </label>
		<input id="searchField" name="searchField" type="text" />
	</p>	
	
</body>

</html>
