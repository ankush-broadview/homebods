<?php 
session_start(); 
if (!isset($_SESSION['ct_useremail']) ) {
	header("location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<!-- new css -->
	<link rel="stylesheet" href="assets/css/chat.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Firebase App is always required and must be first -->
	<!-- <script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-app.js"></script> -->
  	<script src="https://www.gstatic.com/firebasejs/7.0.0/firebase-app.js"></script>
	<!-- Add additional services that you want to use -->
	<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-auth.js"></script>
	<!-- <script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-firestore.js"></script> -->
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/chat/style.css"> -->

	<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
	<script src="https://www.gstatic.com/firebasejs/7.0.0/firebase-storage.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.0.0/firebase-firestore.js"></script>
</head>
<body>

<div class="container">
 	<sidebar class="messenger">
    	<span class="logo">
    	    <?php
    	    if(isset($_SESSION['ct_image']) && ($_SESSION['ct_image'] != '' || $_SESSION['ct_image'] != null)){
    	        $user_image = 'https://homebods.co/booking/assets/images/services/'.$_SESSION['ct_image'];
    	    }else{
    	        $user_image = 'https://homebods.co/booking/assets/images/user.png';
    	    }
    	    ?>
    	    <a href= "#"><img style="max-height: 80px;max-width: 80px;border-radius: 50%;" src="<?php echo $user_image;?>" /></a>
    	</span>
		<div class="list-wrap  users">
			<!-- <div class="list">
          		<img src="https://www.cheatsheet.com/wp-content/uploads/2019/10/taylor-swift-1024x681.jpg" alt="" />
          		<div class="info">
             		<span class="user">Taylor Swift</span>
             		<span class="text">Hi! :)</span>
          		</div>
          		<span class="count">20</span>
          		<span class="time">now</span>
       		</div> -->
		</div>
	</sidebar>
	<div class="content"> 
		<header style="height: 85px">
         	<img id="default_image" src="https://homebods.co/booking/assets/images/services/company_74315.png" alt="" style="width: 80px;height: 80px;">
         	<div class="info">
            	<span class="user"><i class="fas fa-user"></i>&nbsp;<span class="name"></span></span>
            	<!-- <span class="time">Online</span> -->
         	</div>
         	<div class="open">
            	<a href="javascript:;">UP</a>
         	</div>
      	</header>
      	<div class="message-wrap ">
            <div class="main-message ">
           		<div class="message-container">
           		</div>
            </div>
            <div class="message-footer">
                <div class="message-send-input">
                  	<input type="file"  id="files" name="files[]" onchange="encodeImgtoBase64(this)" multiple style="display: none;" />
                    <!-- <input type="text" id="message" data-placeholder="Send a message to {0}" class="message-input"/> -->
                    <div type="text" id="message" data-placeholder="Send a message to {0}" class="message-input" contentEditable="true" style="color: white;background-color: #33383b;height: auto;
    min-height: 100%;padding: 10px 20px;
    border-radius: 25px;"></div>
                    <div class="main-send-btn">
                       <Button type="button"  class="mesg-send message-submit send-btn" > Send </Button>
                    </div>
                </div>
                <svg class="inline w-6 h-6 ml-2 -mt-1 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" onclick="uploadFile()">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
            </div>
        </div>
	</div>
</div>


	<script type="text/javascript" src="assets/js/chat/firestore-config.js"></script>
	<script type="text/javascript" src="assets/js/chat/chat.js"></script>


</body>
</html>