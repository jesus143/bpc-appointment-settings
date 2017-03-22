<?php 



if(empty($scheduleRange)) {

    /** Get specific user standard schedule */
    $standardAppointmentSettings = $appointment_setting_standard->getSpecificSchedule($user_id);    
    $call_back_length = $standardAppointmentSettings[0]['call_back_length']; 
    $call_back_delay  = $standardAppointmentSettings[0]['call_back_delay'];  
    
    $call_back_length_arr = explode(' ', $call_back_length);
    $call_back_delay_arr  = explode(' ', $call_back_delay); 

    if(!empty($call_back_length_arr[0])) {
        $call_back_length_arr0 = $call_back_length_arr[0];
        $call_back_length_arr1 = $call_back_length_arr[1];
    } 

    if(!empty($call_back_delay_arr[0])) {
        $call_back_delay_arr0 = $call_back_delay_arr[0];
        $call_back_delay_arr1 = $call_back_delay_arr[1];
    } 
}
 
?>

 <div class="container bpc-as-dashboard-settings-option">
	<div class="row" style="padding: 0px;margin: 0px;margin-left: -15px;" >
		<div class="col-md-3">
			<?php print get_option('bpc_call_back_delay_standard'); ?> <br>
			<!-- <h5>Call Back Delay:</h5> -->
			<select name="callBackDelay[]" >
				<?php print bpc_as_generate_dropDown_option($call_back_delay_val_num, $call_back_delay_arr0); ?>
			</select>
			<select name="callBackDelay[]" >
				<?php print bpc_as_generate_dropDown_option($call_back_delay_val_text, $call_back_delay_arr1); ?>
			</select>
		</div>
		<div class="col-md-3">
			<?php print get_option('bpc_call_back_length_standard'); ?>  <br>
			<!-- <h5>Call Back Length:</h5> -->
			<select name="callBackLength[]" >
				<?php
			 		  print bpc_as_generate_dropDown_option($call_back_length_val_num, $call_back_length_arr0);
				?>
			</select>

			<select name="callBackLength[]" >
				<?php
				 	 print bpc_as_generate_dropDown_option($call_back_length_val_text, $call_back_length_arr1);
				?>
		</div>
	</div> 
</div>
