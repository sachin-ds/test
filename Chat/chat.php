<?php 
	/*session_start();

	if(!isset($_GET['token']) || !isset($_GET['user_id'])){
		die("invalid Request");
	}

	$token = $_GET['token'];
	$user_id = $_GET['user_id'];

	$m = new MongoClient();
   	// select a database
   	$db = $m->log_life_ad;
   	// Select Collection
   	$collection = $db->chat_logs;
   	$log = $collection->findOne(array('token'=>$token));

   	$fingerprint  = md5($_SERVER['HTTP_USER_AGENT']);
    $ip = $_SERVER['REMOTE_ADDR'];


    if(empty($log)){
   		die("invalid Request - Record not found.");
   	}

   	if(!isset($log['fingerprint']) || $log['fingerprint'] != $fingerprint || !isset($log['ip']) || $log['ip'] != $ip){
   		die("Invalid request - Access violation.");
   	}
   	$duration = 60;
*/
   	?>
   	<!DOCTYPE html>
   	<html>
   	<head>
   		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   		<script>
   			var conn = new WebSocket('ws://192.168.1.44:8080');
            var name = '';
   			//var users = [];
   			var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';

   			console.log(conn);
   			conn.onopen = function(e) {
      			if(conn.readyState != 1){
                  alert("Could not connect");
               }
               console.log(e);
   			};

   			conn.onmessage = function(e) {
               console.log(e.data);
   				showMessage(JSON.parse(e.data));
   			};

   			conn.onclose = function(e) {
   				console.log(e);
   				send(name+' left room', 'join', name);
   			};

   			function send(msg, type, name, color='red'){
   				if(conn.readyState != 1){
   					return false;
   				}

   				var message = {'msg':msg, 'type':type, 'name':name, 'color':color};
   				conn.send(JSON.stringify(message));
   				return false;
   			}

   			function sendMessage(){

   				var message = {'msg':$("#msg").val(), 'type':'msg', 'name':name, 'color':hue};
   				conn.send(JSON.stringify(message));
   				$("#msg").val('');
   				return false;
   			}

   			function showMessage(message){
   				switch(message.type){
   					case 'join':
   					console.log(message);
   					msg = '<p class="join">'+message.msg+'</p>'
   					document.getElementById('test').innerHTML += msg;
   					showUsersList(message.users);
   					break
   					case 'msg':
   					msg = '<p class="msg"><span style="color:'+message.color+'">'+message.name+' : </span> '+message.msg+'</p>';
   					document.getElementById('test').innerHTML += msg;
   					break
   					case 'left':
   					msg = '<p class="left">'+users[message.uID]+' left room</p>'
   					document.getElementById('test').innerHTML += msg;
   					break
   				}
   			}

   			function showUsersList(users){
   				var list = '';
   				for(idx in users){
   					list += '<p>'+users[idx]+'</p>';
   				}
   				$("#users").html(list);
   			}

   			function joinChatRoom(){
   				$("#joinForm").fadeOut();
   				$("#chatRoom").fadeIn();
   				name = $("#name").val();
   				send(name+' joined room', 'join', name);
   			}

   			function closeChat(){
   				alert("close");
   				conn.close();
   			}

   		</script>
   		<style type="text/css">
   			body{
   				font-size: 12px;
   			}
   			p{
   				margin: 0;
   			}
   			.join{
   				font-style:italic; color:green;
   				margin: 10px 0px;
   			}
   			.left{
   				font-style:italic; color: gray;
   				margin: 10px 0px;
   			}
   			.msg{
   				color:black;
   			}

   		</style>
   	</head>
   	<body>
   		<div id="joinForm">
   			<input type="text" name="name" id="name">
   			<input type="button" name="join" value="Join" onclick="joinChatRoom()">
   		</div>
   		<div id="chatRoom" style="display:none;">
   			<div id="test" style="width:250px; position: relative; padding:10px 150px 10px 10px; border:1px solid #ccc; border-radius:3px;">
   				<div id="users" style="position:absolute; top:0; right:0px; bottom: 0; width: 150px; border:1px solid;">
   					
   				</div>
   			</div><br>
   			<form action="" onsubmit="return sendMessage()">
   				<input type="text" id="msg" style="width: 350px; padding: 5px 10px;">
   				<input type="submit" name="send" id="send" style="padding: 4px 0px;" value="Send">
   			</form>
   			<input type="button" name="Close" style="padding: 4px 0px;" onclick="closeChat()" value="Close">
   		</div>
   	</body>
   	</html>
