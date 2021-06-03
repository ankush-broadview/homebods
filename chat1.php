<?php 
session_start();
$_SESSION['ct_name'] = 'rashmita123456';
// if(isset($_SESSION['ct_login_user_id']) || isset($_SESSION['ct_staffid'])){
?>
<html>
   	<head>
      	<title> </title>
      	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
      	<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
      	
      	<!-- <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.min.css'> -->
      	<link rel="stylesheet" href="assets/css/chat.css">


      	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      	<script src='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.concat.min.js'></script>
      	<!-- The core Firebase JS SDK is always required and must be listed first -->
		<script src="https://www.gstatic.com/firebasejs/6.6.1/firebase-app.js"></script>
		<script src="https://www.gstatic.com/firebasejs/6.6.1/firebase-database.js"></script>
		<script>
		  // Your web app's Firebase configuration
		  var firebaseConfig = {
		      apiKey: "AIzaSyADYoc9k8MQHDMKe2NigeZIUQ47MSIaHpc",
		      authDomain: "chat-system-demo-5a5ff.firebaseapp.com",
		      databaseURL : "https://chat-system-demo-5a5ff-default-rtdb.firebaseio.com/",
		      projectId: "chat-system-demo-5a5ff",
		      storageBucket: "chat-system-demo-5a5ff.appspot.com",
		      messagingSenderId: "517896775717",
		      appId: "1:517896775717:web:98d7b44891d3aea51037cc",
		      measurementId: "G-FC5JFYEJNZ"
		  };
		  // Initialize Firebase
		  firebase.initializeApp(firebaseConfig);

		  firebase.database().ref("messages").on("child_removed", function (snapshot) {
		    document.getElementById("message-" + snapshot.key).innerHTML = "This message has been deleted";
		  });

		  function deleteMessage(self) {
		    var messageId = self.getAttribute("data-id");
		    firebase.database().ref("messages").child(messageId).remove();
		  }

		  function sendMessage() {
		    var message = document.getElementById("message").value;
		    firebase.database().ref("messages").push().set({
		      "message": message,
		      "sender": myName
		    });
		    return false;
		  }
		</script>

      
   	</head>
   	<body>
      	<div class="container">
         	<sidebar>
            	<span class="logo">CHAT</span>
        		<div class="list-wrap">
               		<div class="list">
                  		<img src="https://www.cheatsheet.com/wp-content/uploads/2019/10/taylor-swift-1024x681.jpg" alt="" />
                  		<div class="info">
                     		<span class="user">Taylor Swift</span>
                     		<span class="text">Hi! :)</span>
                  		</div>
                  		<span class="count">20</span>
                  		<span class="time">now</span>
               		</div>
               		<div class="list">
                  		<img src="https://ia.tmgrup.com.tr/2fc58d/0/0/0/0/0/0?u=http://i.tmgrup.com.tr/cosmopolitan/galeri/unluler/isimleri-en-cok-aratilmis-dunyaca-unlu-50-kadin/10.jpg&mw=750" width="50" height="50" alt="" />
                  		<div class="info">
                     		<span class="user">Miley Cyrus</span>
                     		<span class="text">Good night.</span>
                  		</div>
                  		<span class="time">5 min. ago</span>
               		</div>
               		<div class="list">
                  		<img src="https://www.cheatsheet.com/wp-content/uploads/2019/10/taylor-swift-1024x681.jpg" alt="" />
                  		<div class="info">
                     		<span class="user">Furry</span>
                     		<span class="text">Ok, lets go.</span>
                  		</div>
                  		<span class="time">1 day ago</span>
               		</div>
               		<div class="list">
                  		<img src="https://www.cheatsheet.com/wp-content/uploads/2019/10/taylor-swift-1024x681.jpg" alt="" />
                  		<div class="info">
                     		<span class="user">Taylor Swift</span>
                     		<span class="text">Hi! :)</span>
                  		</div>
                  		<span class="count">20</span>
                  		<span class="time">now</span>
               		</div>
               		<div class="list">
                  		<img src="https://www.cheatsheet.com/wp-content/uploads/2019/10/taylor-swift-1024x681.jpg" alt="" />
                  		<div class="info">
                     		<span class="user">Furry</span>
                     		<span class="text">Ok, lets go.</span>
                  		</div>
                  		<span class="time">1 day ago</span>
               		</div>
               		<div class="list">
                  		<img src="https://ia.tmgrup.com.tr/2fc58d/0/0/0/0/0/0?u=http://i.tmgrup.com.tr/cosmopolitan/galeri/unluler/isimleri-en-cok-aratilmis-dunyaca-unlu-50-kadin/10.jpg&mw=750" width="50" height="50" alt="" />
                  		<div class="info">
                     		<span class="user">Miley Cyrus</span>
                     		<span class="text">Good night.</span>
                  		</div>
                  		<span class="time">5 min. ago</span>
               		</div>
               		<div class="list">
                  		<img src="https://www.cheatsheet.com/wp-content/uploads/2019/10/taylor-swift-1024x681.jpg" alt="" />
	                  	<div class="info">
	                     	<span class="user">Taylor Swift</span>
	                     	<span class="text">Hi! :)</span>
	                  	</div>
                  		<span class="count">20</span>
                  		<span class="time">now</span>
               		</div>
               		<div class="list">
                  		<img src="https://www.cheatsheet.com/wp-content/uploads/2019/10/taylor-swift-1024x681.jpg" alt="" />
                  		<div class="info">
                     		<span class="user">Furry</span>
                     		<span class="text">Ok, lets go.</span>
                  		</div>
                  		<span class="time">1 day ago</span>
               		</div>
               		<div class="list">
                  		<img src="https://ia.tmgrup.com.tr/2fc58d/0/0/0/0/0/0?u=http://i.tmgrup.com.tr/cosmopolitan/galeri/unluler/isimleri-en-cok-aratilmis-dunyaca-unlu-50-kadin/10.jpg&mw=750" width="50" height="50" alt="" />
                  		<div class="info">
                     		<span class="user">Miley Cyrus</span>
                     		<span class="text">Good night.</span>
                  		</div>
                  		<span class="time">5 min. ago</span>
               		</div>
               		<div class="list">
                  		<img src="https://www.cheatsheet.com/wp-content/uploads/2019/10/taylor-swift-1024x681.jpg" alt="" />
                  		<div class="info">
                     		<span class="user">Taylor Swift</span>
                     		<span class="text">Hi! :)</span>
                  		</div>
                  		<span class="count">20</span>
                  		<span class="time">now</span>
               		</div>
            	</div>
         	</sidebar>
         	<div class="content"> 
	            <header>
	               	<img src="" alt="">
	               	<div class="info">
	                  	<span class="user"><?php echo $_SESSION['name'];?></span>
	                  	<span class="time">Online</span>
	               	</div>
	               	<div class="open">
	                  	<a href="javascript:;">UP</a>
	               	</div>
	            </header>
	            <div class="message-wrap">
	               <div class="main-message ">
	                  	<div class="message-list">
	                     	<div class="msg">
	                        	<p> hiii </p>
	                     	</div>
	                     	<div class="time">now</div>
	                  	</div>
	                  	<div class="message-list me">
	                     	<div class="msg">
	                        	<p> Hello <span class="delete-chat">Delete </span> </p>
	                     	</div>
	                     	<div class="time">now</div>
	                  	</div>
	                </div>
	            </div>
	            <div class="message-footer">
	               <div class="message-send-input">
	                  <input type="text" id="message" data-placeholder="Send a message to {0}" class="message-input"/>
	                  <div class="main-send-btn">
	                     <Button type="button" class="mesg-send message-submit"> Send </Button>
	                  </div>
	               </div>
	               <svg class="inline w-6 h-6 ml-2 -mt-1 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
	               </svg>
	            </div>
         	</div>
      	</div>
      	<script src="assets/js/chat.js?v=<?= time(); ?>"></script>
      	<script type="text/javascript">
      		/* start of chat system funcationality js */
      		var $messages = $('.main-message'),
			    d, h, m,
			    i = 0;

			var myName = "";

			$(window).load(function() {
			  // myName = prompt("Enter your name");
			  myName = '<?php echo $_SESSION['ct_name']; ?>';
			  $messages.mCustomScrollbar();

			  firebase.database().ref("messages").on("child_added", function (snapshot) {
			    if (snapshot.val().sender == myName) {
			      $('<div class="message-list me">'+
			            '<div class="msg" id="message-' + snapshot.key + '">'+
			                '<p> ' + snapshot.val().message + ' <span class="delete-chat" data-id="' + snapshot.key + '" onclick="deleteMessage(this);">Delete </span> </p>'+
			            '</div>'+
			            '<div class="time">now</div>'+
			          '</div>').appendTo($('.mCSB_container'));
			      // $('<div class="message message-personal"><figure class="avatar"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQpdX6tPX96Zk00S47LcCYAdoFK8INeCElPeJrVDrh8phAGqUZP_g" /></figure><div id="message-' + snapshot.key + '">' + snapshot.val().message + '<button class="btn-delete" data-id="' + snapshot.key + '" onclick="deleteMessage(this);">Delete</button></div></div>').appendTo($('.mCSB_container')).addClass('new');
			      $('.message-input').val(null);
			    } else {
			      $('<div class="message-list ">'+
			            '<div class="msg" id="message-' + snapshot.key + '">'+
			                '<p> ' + snapshot.val().message + '  </p>'+
			            '</div>'+
			            '<div class="time">now</div>'+
			          '</div>').appendTo($('.mCSB_container'));

			      // $('<div class="message new"><figure class="avatar"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQpdX6tPX96Zk00S47LcCYAdoFK8INeCElPeJrVDrh8phAGqUZP_g" /></figure><div id="message-' + snapshot.key + '">' + snapshot.val().sender + ': ' + snapshot.val().message + '</div></div>').appendTo($('.mCSB_container')).addClass('new');
			    }
			    
			    setDate();
			    updateScrollbar();
			  });

			});

			function updateScrollbar() {
			  $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
			    scrollInertia: 10,
			    timeout: 0
			  });
			}

			function setDate(){
			  d = new Date()
			  if (m != d.getMinutes()) {
			    m = d.getMinutes();
			    $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
			  }
			}
			function insertMessage() {
			  msg = $('.message-input').val();
			  if ($.trim(msg) == '') {
			    return false;
			  }

			  sendMessage();
			}

			$('.message-submit').click(function() {
			  insertMessage();
			});

			$(window).on('keydown', function(e) {
			  if (e.which == 13) {
			    insertMessage();
			    return false;
			  }
			});
			/* end of chat system funcationality js */
      	</script>
   	</body>
</html>
<?php
//  } else{
// 	header("Location: https://homebods.co/booking");
// }
?>