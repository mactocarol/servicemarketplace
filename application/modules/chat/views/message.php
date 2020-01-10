<?php $this->load->view('header');?>
<?php $myId = $this->session->userdata('user_id'); $myDetail = get_user($myId); $opDetail = get_user($id); ?>

<input type="hidden" id="myId" value="<?php echo $myDetail->id; ?>" name="">
<input type="hidden" id="myName" value="<?php echo $myDetail->shop_name ? $myDetail->shop_name : $myDetail->f_name.' '.$myDetail->l_name; ?>" name="">
<input type="hidden" id="myImage" value="<?php echo $myDetail->image; ?>" name="">
<input type="hidden" id="myType" value="<?php echo $myDetail->user_type; ?>" name="">

<input type="hidden" id="opId" value="<?php echo $opDetail->id; ?>" name="">
<input type="hidden" id="opName" value="<?php echo ($opDetail->shop_name) ? $opDetail->shop_name : $opDetail->f_name.' '.$opDetail->l_name; ?>" name="">
<input type="hidden" id="opImage" value="<?php echo $opDetail->image; ?>" name="">
<input type="hidden" id="opType" value="<?php echo $opDetail->user_type; ?>" name="">


<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">chat</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('user/orderDetail/'.$this->uri->segment('4')); ?>">Order Detail</a></li>
                    <li class="breadcrumb-item active" aria-current="page">chat</li>
                  </ol>
            </div>
        </div>
    </div>
</section> 
<div class="user_chat_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- chat iframe -->
                <div class="chat_box_frame">
                    <!-- chat head -->
                    <div class="chat_contact_head">
                        <div class="contact_profile">
                            <span class="thumb">
                                <img src="<?php echo base_url('upload/profile_image/').$opDetail->image; ?>" alt="" class="img-fluid">
                            </span>
                            <div class="profile_dtl">
                                <h5><?php echo ($opDetail->shop_name) ? $opDetail->shop_name : $opDetail->f_name.' '.$opDetail->l_name; ?></h5>
                                <span id="onOff" style="color: #FFFFFF;"></span>
                            </div>
                        </div>
                    </div>
                    <!-- chat head -->
                    <!-- chat Window Start -->
                    <div id="chatsWrapper" class="chat_window">
                        <ul id="chatMsg" >
                            <!-- <li>
                                <div class="chat_usr_list chat_usr_left">
                                    <div class="chat_usr_msg_wrap">
                                        <div class="chat_usr_msg">
                                            <div class="chat_date_time">
                                                <span class="chat_usr_name">Anthony Smith</span>
                                                <span class="c_time">1 hour ago</span>
                                            </div>
                                            <div class="chat_usr_box">
                                                <p>hello man whats app</p>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="chat_usr_list chat_usr_right">
                                    <div class="chat_usr_msg_wrap">
                                        <div class="chat_usr_msg">
                                            <div class="chat_date_time">
                                                <span class="c_time">1 hour ago</span>
                                                <span class="chat_usr_name">john smith</span>
                                            </div>
                                            <div class="chat_usr_box">
                                                <p>hello man whats app</p>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> -->
                        </ul>
                    </div>
                    <!-- chat Window End -->
                    <!-- chat footer Start -->
                    <div class="chat_footer">
                        <div class="chat_ftr_form">
                            <input id="textMsg" type="text" name="chatmsg" class="chat_input" placeholder="Enter Your Messages">
							<label class="chat_button chat_attach_btn">
								<input id="chatImage" type="file" name="attach_file">
								<i class="fa fa-paperclip"></i>
							</label>
							<button onclick="sendMsg()" type="button" class="chat_button chat_send">
								<i class="fa fa-paper-plane"></i>
							</button>
                        </div>
                    </div>
                    <!-- chat footer End -->
                </div>
                <!-- chat iframe -->
            </div>
        </div>
    </div>
</div>


<!-- Dashboard section End -->
<script type="text/javascript">
	var myId = $('#myId').val();
	var myName = $('#myName').val();
	var myType = $('#myType').val();
	var myImage = $('#myImage').val();

	var opId = $('#opId').val();
	var opName = $('#opName').val();
	var opType = $('#opType').val();
	var opImage = $('#opImage').val();

	var chatRoom = myId+'_'+opId;
	if(opId < myId){
		chatRoom = opId+'_'+myId;
	}

	var chatRef = firebase.database().ref('online/' + opId);
	chatRef.on('value', function(chat){
		$('#onOff').html(chat.val());
	});


	function sendMsg() {
		var textMsg = removeHtmlCssJs($('#textMsg').val());
		$('#textMsg').val('');

		var timestamp  = $.now();
		if(textMsg != ''){
			var chatmsg = {
				'senderId' : myId,
				'senderName' : myName,
				'senderType' : myType,
				'senderImage' : myImage,

				'receiverId' : opId,
				'receiverName' : opName,
				'receiverType' : opType,
				'receiverImage' : opImage,

				'msgType' : 'text',
				'text' : textMsg,
				'image' : '',

				'unread' : 0,
				'timestamp' : timestamp,
			};

			firebase.database().ref().child('chat').child(chatRoom).push(chatmsg);
			
			firebase.database().ref().child('history/'+myId).child(opId).set(chatmsg);
			
			firebase.database().ref().child('history/'+opId).child(myId).set(chatmsg);
			firebase.database().ref().child('history/'+opId).child(myId).once('value', function(unread){
				var unreadVal = unread.val();
				chatmsg.unread = unreadVal.unread + 1;
				firebase.database().ref().child('history/'+opId).child(myId).set(chatmsg);
			});
			firebase.database().ref().child('notification/'+opId).push(chatmsg);

		}
	}


	$( document ).ready(function() {
		$('#chatMsg').append('<center id="noMsg" >No Chat Available Yet</center>');
		var rand  = 1;
		firebase.database().ref("chat").child(chatRoom).on('child_added', function(chat){
			$('#noMsg').remove();
			
			var chatVal = chat.val();
			var chatkey = chat.key;

			var className = '';
			var readIcon = '';

			if(chatVal.senderId == myId){
				className = 'chat_usr_right';
				if(chatVal.unread == 1){
					readIcon = '<i class="fa fa-check" aria-hidden="true"></i><i class="fa fa-check" aria-hidden="true"></i>';
				}
			}else{
				className = 'chat_usr_left';
			}
			
			if(chatVal.msgType == 'text'){
				$('#chatMsg').append(''+
					'<li>'+
						'<div class="chat_usr_list '+className+'">'+
							'<div class="chat_usr_msg_wrap">'+
								'<div class="chat_usr_msg">'+
									'<div class="chat_usr_box">'+
										'<p class="wrapLine" >'+chatVal.text+'</p>'+
									'</div>'+
									'<div class="chat_date_time">'+
										
										'<span class="c_time">'+readIcon+'</span>'+

										'<span class="c_time">'+timeAgo(chatVal.timestamp)+'</span>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</li>'+
				'');
			}else{

				$('#chatMsg').append(''+
					'<li>'+
						'<div class="chat_usr_list '+className+'">'+
							'<div class="chat_usr_msg_wrap">'+
								'<div class="chat_usr_msg">'+
									'<div class="chat_usr_box1">'+
										' <img id="imageId'+rand+'" onclick="showFullImage('+rand+')" src="'+chatVal.image+'" alt="Loading.." height="125" width="125"> '+
									'</div>'+
									'<div class="chat_date_time">'+
									    
									    '<span class="c_time">'+readIcon+'</span>'+

										'<span class="c_time">'+timeAgo(chatVal.timestamp)+'</span>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</li>'+
				'');
				rand++;
			}
			$('#chatsWrapper').animate({ scrollTop: 10000 }, 100);

			if(chatVal.senderId != myId){
				firebase.database().ref().child('chat/'+chatRoom).child(chatkey).child('unread').set(1);
			}

		});
		firebase.database().ref().child('history/'+myId).child(opId).child('unread').set(0);
	});



	const MONTH_NAMES = [
		'January', 'February', 'March', 'April', 'May', 'June',
		'July', 'August', 'September', 'October', 'November', 'December'
	];


	function getFormattedDate(date, prefomattedDate = false, hideYear = false) {
	  const day = date.getDate();
	  const month = MONTH_NAMES[date.getMonth()];
	  const year = date.getFullYear();
	  const hours = date.getHours();
	  let minutes = date.getMinutes();

	  if (minutes < 10) {
	    minutes = `0${ minutes }`;
	  }

	  if (prefomattedDate) {
	    return `${ prefomattedDate } at ${ hours }:${ minutes }`;
	  }

	  if (hideYear) {
	    return `${ day }. ${ month } at ${ hours }:${ minutes }`;
	  }
	  return `${ day }. ${ month } ${ year }. at ${ hours }:${ minutes }`;
	}


	function timeAgo(dateParam) {
		if (!dateParam) {
			return null;
		}

		const date = typeof dateParam === 'object' ? dateParam : new Date(dateParam);
		const DAY_IN_MS = 86400000; // 24 * 60 * 60 * 1000
		const today = new Date();
		const yesterday = new Date(today - DAY_IN_MS);
		const seconds = Math.round((today - date) / 1000);
		const minutes = Math.round(seconds / 60);
		const isToday = today.toDateString() === date.toDateString();
		const isYesterday = yesterday.toDateString() === date.toDateString();
		const isThisYear = today.getFullYear() === date.getFullYear();


		if (seconds < 5) {
			return 'now';
		} else if (seconds < 60) {
			return `${ seconds } seconds ago`;
		} else if (seconds < 90) {
			return 'about a minute ago';
		} else if (minutes < 60) {
			return `${ minutes } minutes ago`;
		} else if (isToday) {
			return getFormattedDate(date, 'Today'); // Today at 10:20
		} else if (isYesterday) {
			return getFormattedDate(date, 'Yesterday'); // Yesterday at 10:20
		} else if (isThisYear) {
			return getFormattedDate(date, false, true); // 10. January at 10:20
		}
		return getFormattedDate(date); // 10. January 2017. at 10:20
	}


	function timeDifference(current, previous) {
		var msPerMinute = 60 * 1000;
		var msPerHour = msPerMinute * 60;
		var msPerDay = msPerHour * 24;
		var msPerMonth = msPerDay * 30;
		var msPerYear = msPerDay * 365;
		var elapsed = current - previous;
		if (elapsed < msPerMinute) {
		     return Math.round(elapsed/1000) + ' seconds ago';   
		}else if (elapsed < msPerHour) {
		     return Math.round(elapsed/msPerMinute) + ' minutes ago';   
		}else if (elapsed < msPerDay ) {
		     return Math.round(elapsed/msPerHour ) + ' hours ago';   
		}else if (elapsed < msPerMonth) {
		     return 'approximately ' + Math.round(elapsed/msPerDay) + ' days ago';   
		}else if (elapsed < msPerYear) {
		     return 'approximately ' + Math.round(elapsed/msPerMonth) + ' months ago';   
		}else {
		     return 'approximately ' + Math.round(elapsed/msPerYear ) + ' years ago';   
		}
	}

	document.getElementById("chatImage").onchange = function(e) {
		$('#chatMsg').append(''+
			'<li id="demoImage" >'+
				'<div class="chat_usr_list chat_usr_right">'+
					'<div class="chat_usr_msg_wrap">'+
						'<div class="chat_usr_msg">'+
							'<div class="chat_usr_box1">'+
								'<img id="demoImageSrc" src="http://placehold.it/150x150&text=Wait" alt="Smiley face" height="125" width="125"> '+
							'</div>'+
							'<div class="chat_date_time">'+
								'<span class="c_time">now</span>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</li>'+
		'');
		$('#chatsWrapper').animate({ scrollTop: 10000 }, 100);
		
		var file = e.target.files[0];
		var storageRef = firebase.storage().ref();
		var fileName = Date.now();
		var uploadTask = storageRef.child('images/' + fileName).put(file);


		uploadTask.on('state_changed', function(snapshot) { 
            var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
            console.log('Upload is ' + progress + '% done');

            var round =Number(Math.round(progress))-1; 
            $('#demoImageSrc').attr('src','https://via.placeholder.com/130/fc4c02/FFFFFF/?text='+round+'%');
   
        }, 
        function(error) {

        }, function() {

        	var storageqq = firebase.storage();
        	storageqq.ref('images/' + fileName).getDownloadURL().then(function (url) {
	            var imageUrl = url;
	             
				$('#demoImage').remove();
				var timestamp  = $.now();
				var chatmsg = {
					'senderId' : myId,
					'senderName' : myName,
					'senderType' : myType,
					'senderImage' : myImage,

					'receiverId' : opId,
					'receiverName' : opName,
					'receiverType' : opType,
					'receiverImage' : opImage,

					'msgType' : 'file',
					'text' : 'IMAGE',
					'image' : imageUrl,

					'unread' : 0,
					'timestamp' : timestamp,
				};

				firebase.database().ref().child('chat').child(chatRoom).push(chatmsg);
				firebase.database().ref().child('history/'+myId).child(opId).set(chatmsg);
				firebase.database().ref().child('history/'+opId).child(myId).set(chatmsg);

				firebase.database().ref().child('history/'+opId).child(myId).once('value', function(unread){
					var unreadVal = unread.val();
					chatmsg.unread = unreadVal.unread + 1;
					firebase.database().ref().child('history/'+opId).child(myId).set(chatmsg);
				});
				firebase.database().ref().child('notification/'+opId).push(chatmsg);
	        });
	    });
	}

	function showFullImage(imageId){
		alert('imageId'+imageId);
	}

	function removeHtmlCssJs(text){
		text = $.trim(text);
		text = text.replace(/\&/g, '&amp;');
		text = text.replace(/\>/g, '&gt;');
		text = text.replace(/\</g, '&lt;');
		text = text.replace(/\"/g, '&quot;');
		text = text.replace(/\'/g, '&apos;');
		return text;
	}

</script>
<?php $this->load->view('footer'); ?>