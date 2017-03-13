<?php  
	/**
	 * Require files
	 */
	
	$ext = '../';
	require_once('../config.php');    
	/** 
	 * Instantiate classes 
	 */ 
  
  	// $bpc_appointment_setting_standard = new BPC_AS_DB('wp_bpc_appointment_setting_standard'); 

  	/**
  	 *  Initialized data 
  	 */
	$notAjax = (!empty($notAjax)) ? $notAjax : null;
	if(!$notAjax) { 
		$strDate = $_GET['strDate'];
		$day = $_GET['day'];
		$breakId = strtotime(date("Y-m-d h:i:s"));
		$break_from_hour = '';
		$break_from_min  = '';
		$break_to_hour   = '';
		$break_to_min    = '';
	}


/**
 *  Print data for ui 
 */ 
?> 
<li id="bpc-as-break-time-content-container-<?php print $breakId; ?>-<?php print $strDate ?>" >
	<table  class="table" >
		<tr>
			<td>
				Break From:
				<select name="break_time_hour_min[]"  onchange="bpc_change_break('<?php print $day; ?>')" >
					<?php print bpc_as_generate_hours_option($break_from_hour); ?>
				</select>
				<select  name="break_time_hour_min[]"  onchange="bpc_change_break('<?php print $day; ?>')" >
					<?php bpc_as_generate_minutes_option($break_from_min); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Break From:
				<select  name="break_time_hour_min[]" onchange="bpc_change_break('<?php print $day; ?>')" >
					<?php print bpc_as_generate_hours_option($break_to_hour); ?>
				</select>
				<select  name="break_time_hour_min[]" onchange="bpc_change_break('<?php print $day; ?>')" >
					<?php bpc_as_generate_minutes_option($break_to_min); ?>
				</select>
			</td>
		<tr>
		<tr>
			<td>
				<input type="button" value="Delete"  onclick="bpc_as_delete_time_break('<?php print $breakId; ?>', '<?php print $strDate; ?>')" />
			</td>
		</tr>	
	</table>
</li>