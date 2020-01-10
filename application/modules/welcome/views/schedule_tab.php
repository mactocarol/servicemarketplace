    <div class="servicebox">
    <form id="scheduleform" method="post" action="#">
         <div class="schedule_calendar">
            <div class="schedule_date_n"></div>
            <div class="time_slots_wrapper">
                <div class=show_schedule_date>
                    <input type="text" value="" name="dateslots" id="schedule_date_n" value="<?php echo $this->session->userdata('schedule_cart')['dateslots'];?>">
                </div>
                <div class="radio_box">
                    <?php for($i=8;$i<=22;$i++){ ?>
                    <label>
                        <input type="radio" name="timeslots" value="<?=$i?>:30-<?=$i+1?>:30" onclick="save_schedule();" <?php echo ($this->session->userdata('schedule_cart')['timeslots'] == $i.':30-'.($i+1).':30') ? 'checked' : ''?>>
                        <span class="r_text"><?=$i?>:30-<?=$i+1?>:30</span>
                    </label>
                    <?php } ?>
                    
                </div>
            </div>
         </div>
         <input type="hidden" value="provider" id="next_tab">
    </form>
    </div>
    <div id="loader" style="display:none;"><img src="https://media.theaustralian.com.au/fe/sop/wait.gif"></div>
    
    <script type="text/javascript">

	$(function () {        
        $(".schedule_date_n").datepicker({
            maxDate: "+3m",
            minDate:"+1",
            dateFormat: "dd MM yy",
            defaultDate: showDays('<?php echo $this->session->userdata('schedule_cart')['dateslots'];?>'),
            onSelect: function(dateText) {                
               $("#schedule_date_n").val(dateText);
               $(".time_slots_wrapper").show();
            },            
         });        
	 });
    
    <?php if($this->session->userdata('schedule_cart')['dateslots']){ ?>
    $(".time_slots_wrapper").show();
    $("#schedule_date_n").val('<?php echo $this->session->userdata('schedule_cart')['dateslots'];?>');
    <?php } ?>
    
    function showDays(secondDate){
          var startDay = new Date();
          var endDay = new Date(secondDate);
          var millisecondsPerDay = 1000 * 60 * 60 * 24;

          var millisBetween = startDay.getTime() - endDay.getTime();
          var days = millisBetween / millisecondsPerDay;

          // Round down.
          //alert( Math.floor(days));
          return Math.floor(days) * -1 ;

      }
	 </script>