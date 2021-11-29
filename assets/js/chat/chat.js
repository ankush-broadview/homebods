var chat_data = {}, user_uuid, chatHTML = '', chat_uuid = "", userList = [];

	firebase.auth().onAuthStateChanged(function(user) {
	  if (user) {
	    //console.log(user);
	    user_uuid = user.uid;

		getUsers();
	    // console.log(user_uuid);

	  } else {
	    console.log("Not sign in");
	  }
	});


	// function logout(){
	// 	$.ajax({
	// 		url : 'process.php',
	// 		method : 'POST',
	// 		data : {logoutUser:1},
	// 		success : function(response){
	// 			console.log(response);
	// 			firebase.auth().signOut().then(function() {
	// 			  console.log('Logout');

	// 			  window.location.href = "index.php";

	// 			}).catch(function(error) {
	// 			  // An error happened.
	// 			  console.log('Logout Fail');
	// 			});
	// 		}
	// 	});
	// }

	function getUsers(){
		
		$.ajax({
			url :   base_url+"/process.php",
			// url :  ajax_url + "front_ajax.php",
			method : 'POST',
			data : {getUsers:1},
			success : function(response){

				var resp = JSON.parse(response);
				
				if(resp.status == 200){
					var users = resp.message.users;
					var usersHTML = '';
					var messageCount = '';
					var src = '';
					console.log(users);
					$.each(users, function(index, value){
						console.log(user_uuid +"!="+ value.uuid +"data"+value);
						if (user_uuid != value.uuid && value.uuid != '') {
							
							// usersHTML += '<div class="user" uuid="'+value.uuid+'">'+
							// 			'<div class="user-image"></div>'+
							// 			'<div class="user-details">'+
							// 				'<span><strong>'+ value.fullname+'<span class="count"></span></strong></span>'+
							// 				'<span>Last Login</span>'+
							// 			'</div>'+
							// 		'</div>';
							/*if (jQuery('#default_image').attr('src') == 'https://homebods.co/booking/assets/images/services/company_81901.png') {
								jQuery('#default_image').hide();
							}else{
								jQuery('#default_image').show();
							}*/
							if(value.image != '' && value.image != undefined){
								src= base_url+"/assets/images/services/"+value.image;
							}else{
								src= base_url+"/assets/images/default.png";
							}
							

								var count = 0;
							usersHTML = '<div class="list user" uuid1="'+user_uuid+'" uuid="'+value.uuid+'" id="'+value.uuid+'">'+
              								'<img src="'+src+'" alt="" />'+
              								'<div class="info">'+
                 								'<span class="user">'+ value.username+'</span>'+
                 								
              								'</div>'+
              								'<span class="count" style="display:none;"></span>'+
              								
           								'</div>';
           					$(".users").append(usersHTML);
           				
							db.collection('chat').where('chat_uuid', '==', value.chat_uuid)
							.get().then(function(querySnapshot){
								chatHTML = '';
								querySnapshot.forEach(function(doc){
									//console.log(value.uuid);
									if (doc.data().user_2_uuid == user_uuid  
										&& doc.data().user_2_isView == 0) {
										count = count + 1;
										jQuery("#"+value.uuid+ " .count").css("display","block");
										jQuery("#"+value.uuid+ " .count").text(count);
										console.log(doc.id);

										
									}

								});
							});
							//console.log(count);
							// '<span class="text">Hi! :)</span>'+
           					// '<span class="time">now</span>'+
							userList.push({user_uuid: value.uuid, username: value.fullname});


						}
					});
					// $(".users").html(usersHTML);
				}else{
					console.log(response.message);
				}
			}
		});
	}
	

	$(document.body).on('click', '.list', function(){
		// console.log($(this).attr('uuid'));
		// var name = $(this).find("strong").text();
		var name = $(this).find(".user").text();
		var img = $(this).find("img").attr('src');
		
		var user_1 = user_uuid;
		// var user_1 = $(this).attr('uuid1');
		var user_2 = $(this).attr('uuid');
		$('.message-container').html('Connecting...!');

		$(".name").text(name);
		$("header img").attr('src',img);

		$.ajax({
			url : base_url+'/process.php',
			// url :  ajax_url + "front_ajax.php",
			method : 'POST',
			data : {connectUser:1, user_1:user_1, user_2: user_2},
			success : function(resposne){
				// console.log(resposne);
				var resp = JSON.parse(resposne);
				chat_data = {
					chat_uuid : resp.message.chat_uuid,
					user_1_uuid : resp.message.user_1_uuid,
					user_2_uuid : resp.message.user_2_uuid,
					user_1_name : '',
					user_2_name : name
				};
				$('.message-container').html('<p style="color:#fffdfd61;text-align:center">------------- Say Hi to '+name+' -------------</p>');
				// console.log(chat_data.chat_uuid);
				
				var flag = 1;
				if (chat_uuid == "" && flag) {
					chat_uuid = chat_data.chat_uuid;
					flag = 0;
					realTime();
				}else if(chat_uuid != "" && flag){
					console.log("manual");
					if(resp.message.chat_uuid != undefined){
						db.collection('chat').where('chat_uuid', '==', resp.message.chat_uuid).orderBy("id", "asc").get().then(function(querySnapshot){
							chatHTML = '';
							console.log(querySnapshot);
							querySnapshot.forEach(function(doc){
								if (doc.data().user_1_uuid == user_uuid) {

									chatHTML += '<div class=" message-list  me" id="message-'+doc.id+'">'+
													// '<div class=" msg"><p>'+ doc.data().message +'<span class="delete-chat" onclick="deleteMessage(this);"  data-id="'+doc.id+'">Delete </span></p></div>'+
													'<div class=" msg"><p>'+ doc.data().message +'</p></div>'+
													
												'</div>';
									

									
									// '<div class="time">'+ doc.data().time.seconds +'</div>'+			

								}else{
									chatHTML += '<div class="message-list " id="message-'+doc.id+'">'+
													'<div class=" msg"><p>'+ doc.data().message +'</p></div>'+
													
												'</div>';
									db.collection("chat").doc(doc.id).update({
										user_2_isView : 1
									}).then(() => {
										jQuery("#"+doc.data().user_1_uuid+ " .count").css("display","none");
										jQuery("#"+doc.data().user_1_uuid+ " .count").text(0);
									    console.log("Document successfully Updated!");
									}).catch((error) => {
									    console.error("Error removing document: ", error);
									});
									// '<div class="time">'+ doc.data().time.seconds +'</div>'+
								}

							});
							$(".message-container").html(chatHTML);

						});
					}
					flag = 0;
					
				}
			}
		});
	});

	function deleteMessage (self){
		var message = self.getAttribute("data-id");
		
		if(message != ""){
			db.collection("chat").doc(message).delete().then(() => {
			    console.log("Document successfully deleted!");
			}).catch((error) => {
			    console.error("Error removing document: ", error);
			});


			// db.collection("chat").delete({
			//     message : message,
			//     user_1_uuid : user_uuid,
			//     user_2_uuid : chat_data.user_2_uuid,
			//     chat_uuid : chat_data.chat_uuid,
			//    	user_1_isView : 0,
			//    	user_2_isView : 0,
			//     time : new Date(),
			// })
			// .then(function(docRef) {
			// 	$(".message-input").val("");
			//     console.log("Document written with ID: ", docRef.id);
			// })
			// .catch(function(error) {
			//     console.error("Error adding document: ", error);
			// });

		}
	}

	// function uploadImageFile(){
	// 	// Created a Storage Reference with root dir
	//     var storageRef = firebase.storage().ref();
	//     // Get the file from DOM
	//     var file = document.getElementById("files").files[0];
	//     console.log(file);
	      
	//     //dynamically set reference to the file name
	//     var thisRef = storageRef.child(file.name);

	//     //put request upload file to firebase storage
	//     thisRef.put(file).then(function(snapshot) {
	//         alert("File Uploaded")
	//         console.log('Uploaded a blob or file!');
	//     });
	// }

	function uploadFile(){
      // $(".send-btn").attr("onclick","uploadImageFile()");
      // $(".send-btn").removeClass("send-btn");

      $("#files").trigger("click");
      
    }
    var image_src = '';
    function encodeImgtoBase64(element) {
 
      var file = element.files[0];
 
      var reader = new FileReader();
 
      reader.onloadend = function() {
 
        $("#convertImg").attr("href",reader.result);
 
        $("#convertImg").text(reader.result);
 
        $("#base64Img").attr("src", reader.result);
 		image_src = reader.result;
        $("#message").html("<img src='"+image_src+"' style='height:100px;width:100px'/><br/>");
      }
 
      reader.readAsDataURL(file);
 
    }

	
	
	$(".send-btn").on('click', function(){
		
		var message = $(".message-input").html();
		var image =  document.getElementById("files").files[0];
		// alert(image);
		// console.log(image);
		var d1 = new Date();
		var date = d1.toString('y-m-d');
		var time = d1.toString('h:m:s');
		

	    if(image != '' && image != undefined){
	    	
	    	// Created a Storage Reference with root dir
		    var storageRef = firebase.storage().ref();
		    // Get the file from DOM
		    var file = document.getElementById("files").files[0];
		    console.log(file);
		      
		    //dynamically set reference to the file name
		    var thisRef = storageRef.child(file.name);

		    //put request upload file to firebase storage
		    thisRef.put(file).then(function(snapshot) {
		        
		        console.log('Uploaded a blob or file!');
		        console.log(snapshot);
		        db.collection("chat").add({
					id : Date.now(),
				    message : message,
				    user_1_uuid : user_uuid,
				    user_2_uuid : chat_data.user_2_uuid,
				    chat_uuid : chat_data.chat_uuid,
				   	user_1_isView : 1,
				   	user_2_isView : 0,
				    date :date,
				    time : time,
				})
				.then(function(docRef) {
					$("#message").html("");
					$("#files").val("");
				    console.log("Document written with ID: ", docRef.id);
				})
				.catch(function(error) {
				    console.error("Error adding document: ", error);
				});
		    });
	    }else{
	    	if(message != ''){
				db.collection("chat").add({
					id : Date.now(),
				    message : message,
				    user_1_uuid : user_uuid,
				    user_2_uuid : chat_data.user_2_uuid,
				    chat_uuid : chat_data.chat_uuid,
				   	user_1_isView : 1,
				   	user_2_isView : 0,
				    date :date,
				    time : time,
				})
				.then(function(docRef) {
					$(".message-input").html("");
				    console.log("Document written with ID: ", docRef.id);
				})
				.catch(function(error) {
				    console.error("Error adding document: ", error);
				});
			}
		}
	});

	var newMessage = '';
	function realTime(){
		console.log("realTime"); 
		console.log(chat_uuid);
		if(chat_uuid != undefined){
			db.collection('chat').where('chat_uuid', '==', chat_uuid).orderBy("id", "asc").onSnapshot(function(snapshot) {
				newMessage = '';
				 console.log(snapshot);
		        snapshot.docChanges().forEach(function(change) {
		        	// alert(change.type);
		        	if (change.type === "removed") {
		                var time = change.doc.data().time.seconds;
		                
		                if (change.doc.data().user_1_uuid == user_uuid) {
		                	$("#message-"+change.doc.id).find(".msg").html("<p>This message has been deleted</p>");
							
						}else{
							$("#message-"+change.doc.id).find(".msg").html("<p>This message has been deleted</p>");
						}
		
		            }
		            if (change.type === "added") {
		                var time = new Date(Date.now() - change.doc.data().time.seconds);
		                if (change.doc.data().user_1_uuid == user_uuid) {

								newMessage += '<div class="message-list  me" id="message-'+change.doc.id+'">'+
												// '<div class=" msg"><p>'+ change.doc.data().message +'<span class="delete-chat" onclick="deleteMessage(this);"  data-id="'+change.doc.id+'">Delete </span></p></div>'+
												'<div class=" msg"><p>'+ change.doc.data().message +'</p></div>'+
												
											'</div>';
								// '<div class="time">'+ time.getHours() +':' + time.getMinutes() + ':' + time.getSeconds()  +'</div>'+			

							}else{
								newMessage += '<div class="message-list  " id="message-'+change.doc.id+'">'+
												'<div class=" msg"><p>'+ change.doc.data().message +'</p></div>'+
												
											'</div>';
								// '<div class="time">'+ time.getHours() +':' + time.getMinutes() + ':' + time.getSeconds() +'</div>'+
							}



		            }
		            if (change.type === "modified") {
		               
		            	// alert(change.type);
		            }
		            
		        });

		        if (chatHTML != newMessage) {
		        	$('.message-container').append(newMessage);
		        }
		        
		        $(".main-message").scrollTop($(".main-message")[0].scrollHeight);

		    });
		}
	}