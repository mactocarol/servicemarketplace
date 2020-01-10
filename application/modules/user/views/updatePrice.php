<?php $this->load->view('header');?>


<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Update Price</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Price</li>
                  </ol>
            </div>
        </div>
    </div>
</section>
<section class="login_outer">
    <div class="container">
        <div class=" col-md-8 col-md-offset-2">
            <?php
                // display error & success messages
                if(isset($message)) {                   
                    if($success){
                    ?>
                      <div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> <?php print_r($message); ?>
                      </div>                        
                    <?php
                    }else{
                    ?>
                        <div class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error!</strong> <?php print_r($message); ?>
                        </div>                      
                    <?php
                    }
                }
                ?>
            <div class="login-inner">
                <div class="login-header"><h1><i class="fa fa-lock"></i> Update Price</h1></div>
                <div class="login-form">
                    <form method="post" id="registerform" action="<?php echo site_url('user/updatePrice/').base64_encode(isset($data->userServicesId) ? $data->userServicesId : $newId);?>">
                        
                        <div class="form-group">
                            <label>One Day Price</label>
                            <input value="<?php echo isset($data->price) ? $data->price : ''; ?>" type="text" placeholder="One Day Price" name="price" class="number form-control" >
                        </div>

                        <div class="form-group">
                            <label>One Week Day Price</label>
                            <input value="<?php echo isset($data->weekPrice) ? $data->weekPrice : ''; ?>" type="text" placeholder="One Week Day Price" name="weekPrice" class="number form-control" >
                        </div>

                        <div class="form-group">
                            <label>One Month Day Price</label>
                            <input value="<?php echo isset($data->monthPrice) ? $data->monthPrice : ''; ?>" type="text" placeholder="One Month Day Price" name="monthPrice" class="number form-control" >
                        </div>

                        <div class="form-group">
                            <label>One Year Day Price</label>
                            <input value="<?php echo isset($data->yearPrice) ? $data->yearPrice : ''; ?>" type="text" placeholder="One Year Day Price" name="yearPrice" class="number form-control" >
                        </div>
                        
                        
                        <div class="col-md-12"><button type="submit" class="btn btn-primary pull-right">Add / Update</button></div>
                        
                    </form>
                </div>
                
                
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $('.number').keypress(function(event) {
    var $this = $(this);
    if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
       ((event.which < 48 || event.which > 57) &&
       (event.which != 0 && event.which != 8))) {
           event.preventDefault();
    }

    var text = $(this).val();
    if ((event.which == 46) && (text.indexOf('.') == -1)) {
        setTimeout(function() {
            if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
            }
        }, 1);
    }

    if ((text.indexOf('.') != -1) &&
        (text.substring(text.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8) &&
        ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
    }     
});

$('.number').bind("paste", function(e) {
    var text = e.originalEvent.clipboardData.getData('Text');
    if ($.isNumeric(text)) {
        if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
            e.preventDefault();
            $(this).val(text.substring(0, text.indexOf('.') + 3));
       }
    }else{
        e.preventDefault();
    }
});

</script>


<?php $this->load->view('footer');?> 