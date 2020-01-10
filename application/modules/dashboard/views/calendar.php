<?php $this->load->view('header');?>

<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Calendar</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Calendar</li>
                  </ol>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->
<!-- dashboard content part -->
<div class="dashboard_cotent_part">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
            <div class="event_calendar_dv" style="width:100%; display:inline-block;">
                <div class="monthly" id="event_calendar"></div>
            </div>
        </div>
    </div>
  </div>
</div>


<script type="text/javascript">
    function ajax_fun(url){
        $.ajax({
            url: url,
            type : 'POST',
            data : {},
            success: function(jsonData){
                var sampleEvents = {
                "monthly":  JSON.parse(jsonData)
                };
                $('#event_calendar').monthly({
                    mode: 'event',
                    dataType: 'json',
                    events: sampleEvents
                });
            }
        });
    }
    
    $(document).ready(function() {
        ajax_fun('<?php base_url('dashboard/calendarData'); ?>');
    });

</script>


<?php $this->load->view('footer');?> 