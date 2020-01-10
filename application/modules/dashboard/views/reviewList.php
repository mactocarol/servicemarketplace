<?php $this->load->view('header');?>
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">My Review</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Review</li>
                  </ol>
            </div>
        </div>
    </div>
</section>  

<section class="body_content">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ">
        <div class="custom_tablee">
               <div class="table_header">
                  <span>My Review</span>
                </div>
                <div id="tableData" class="table_section">
                    
                </div>
            </div>
        </div>
     </div>
    </div>
</section>

<script type="text/javascript">
    function ajax_fun(url){
        $.ajax({
            url: url,
            type : 'POST',
            data : {
            },
            success: function(result){
                $('#tableData').html(result);
            }
        });
    }
    ajax_fun('<?php echo site_url('dashboard/reviewListData/0'); ?>');
</script>

<?php $this->load->view('footer');?> 