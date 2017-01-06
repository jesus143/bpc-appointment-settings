<hr>
<div class="container dashboard-settings-option">
	<div class="row">
		<div class="col-md-3">
			<h3>Call Back Delay</h3>
			<select name="callBackDelay[]" >
				<?php print bpc_as_generate_dropDown_option($call_back_delay_val_num, $call_back_length_arr0); ?>
			</select>
			<select name="callBackDelay[]" >
				<?php print bpc_as_generate_dropDown_option($call_back_delay_val_text, $call_back_length_arr1); ?>
			</select>
		</div>
		<div class="col-md-3">
			<h3>Call Back Lenght</h3>
			<select name="callBackLength[]" >
				<?php
			 		  print bpc_as_generate_dropDown_option($call_back_length_val_num, $call_back_delay_arr0);
				?>
			</select>

			<select name="callBackLength[]" >
				<?php
				 	 print bpc_as_generate_dropDown_option($call_back_length_val_text, $call_back_delay_arr1);
				?>
		</div>
	</div> 
</div>
