<?php $this->load->view('header');?>
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Chat History</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chat</li>
                  </ol>
            </div>
        </div>
    </div>
</section>  
<section class="body_content">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ">
        <div class="custom_table">
               <div class="table_header">
                  <span>Chat History</span>
                </div>
                <div class="table_section">
                    <table class="table table-customize">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Last Msg</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="chatHistory" >
                            <center class="errorMsg" id="noHistory">No History Is Available</center>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
     </div>
    </div>
</section>
<!-- Dashboard section End -->

<input type="hidden" id="userid" value="<?php echo $this->session->userdata('user_id'); ?>" name="">
<script type="text/javascript">
    function getChatHistory(){

        var userid = $('#userid').val();
        
        firebase.database().ref("history").child(userid).once('value', function(history){
            var history = history.val();
            var i = 1;
            
            $.each(history, function( key, value ) {
                if(typeof value != 'undefined'){
                if(typeof value.senderId != 'undefined'){

                    if(i == 1){
                        $('#chatHistory').html('');
                    }

                    var timestamp  = $.now();
                    

                    if(value.senderId == userid){
                        var name = value.receiverName;
                        var image = "<?php echo base_url('upload/profile_image/'); ?>"+value.receiverImage;
                        var chatId = btoa(value.receiverId);
                        updateHistory(value.receiverId);
                    }else{
                        var name = value.senderName;
                        var image = "<?php echo base_url('upload/profile_image/'); ?>"+value.senderImage;
                        var chatId = btoa(value.senderId);
                        updateHistory(value.senderId);
                    }

                    if(value.msgType == 'text'){
                        var message = text_truncate(value.text,'20','...');
                    }else{
                        var message = '<i class="fa fa-image"></i> IMAGE';
                    }

                    $('#noHistory').remove();
                    $('#chatHistory').append(''+
                    '<tr>'+
                        
                        '<td>'+i+'</td>'+
                        
                        '<td>'+
                            '<img height="50" width="50" src="'+image+'" class="img-fluid" alt="User Thumb">'+
                        '</td>'+
                        
                        '<td>'+name+'</td>'+

                        '<td>'+message+'</td>'+

                        '<td>'+moment(value.timestamp).format('MMMM D, YYYY')+'</td>'+

                        '<td>'+moment(value.timestamp).format('h:mm a')+'</td>'+

                        '<td>'+
                            '<a href="<?php echo base_url('chat/message/'); ?>'+chatId+'" type="button" class="btn btn_accepted"> Chat</a>'+
                            '</td>'+
                    
                    '</tr>'+
                    '')
                    i++;
                }
                }
            });

        });
    }
        
    getChatHistory();

    function text_truncate(str, length, ending) {
        if (length == null) {
            length = 100;
        }
        if (ending == null) {
            ending = '...';
        }
        if (str.length > length) {
            return str.substring(0, length - ending.length) + ending;
        } else {
            return str;
        }
    };

    function updateHistory(opId){
        var userid = $('#userid').val();
        firebase.database().ref("history/"+userid).child(opId).off('child_changed');
        firebase.database().ref("history/"+userid).child(opId).on('child_changed', function(updateHis){
            if(updateHis.key == 'timestamp'){
                getChatHistory();
            }
        });
    }


</script>

<?php $this->load->view('footer'); ?>