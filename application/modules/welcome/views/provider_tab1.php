<div class="servicebox">
<h1>Select the services provider</h1>
<form id="providerform" method="post" action="#">
        <div class="job-filter-result">
        <?php foreach($vendors as $row){ ?>
        
            <label class="joblist_label">
                <input name="vndor" type="radio" onclick="select_provider();" value="<?=$row['id']?>" <?php echo ($this->session->userdata('provider_cart')['vndor'] == $row['id']) ? 'checked' : ''?>>
                <div class="job-list">
                    <div class="row">
                        <div class="col-lg-2"><img src="<?php echo base_url('upload/profile_image/'.$row['image']);?>"></div>
                        <div class="col-lg-5">
                            <div class="job-title-outer">
                            <h4><a href="#"><?=($row['f_name'])?$row['f_name'].' '.$row['l_name']:''?></a></h4>
                                
                            </div>
                            <p><span class="total-rate">4.5</span>
                                <img src="<?php echo base_url('front');?>/images/rating.png"></p>
                           
                        </div>
                        <div class="col-lg-5 text-right">
                            <div class="job-price">AED <?=($row['charges'])?$row['charges']:''?></div>
                          <p>All Prices include VAT</p>
                          <p>Minimum service order : AED <?=($row['charges'])?$row['charges']:''?></p>
                            
                        </div>
                    </div>
                </div>
            </label>
        <?php } ?>
        <input type="hidden" value="checkout" id="next_tab">
    </div>
</form>
</div>
<div id="loader" style="display:none;"><img src="https://media.theaustralian.com.au/fe/sop/wait.gif"></div>