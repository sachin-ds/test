<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#start").click(function(){
		$.ajax({
			url: 'http://product-demo.com:8081/RND/sachin/Chat/start.php',
			method:'POST',
			data:{'port':8080},
			success:function(response){ console.log(response); },
			error:function(error){ console.log('Error: '+error); }
		});
	});
});
</script>

</head>
<body>
	<input type="submit" name="start" id="start" value="Start Chat Room">
</body>
</html>
