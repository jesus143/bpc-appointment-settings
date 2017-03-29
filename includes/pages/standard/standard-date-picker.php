
	<link href="<?php print bpc_as_plugin_url; ?>/test/bootstrap-datetimepicker-master/sample in bootstrap v3/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" /> 
    <link href="<?php print bpc_as_plugin_url; ?>/test/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" /> 
		<!-- date picker  -->
		<div class="container">   
			<div class="form-group" >


<!--				<label>Select Date:</label>-->
<!--                <div class="input-group date form_date col-md-6" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="padding-left: 0px;">-->
<!--                    <input class="form-control" size="16" type="text" value="" onchange="-->
<!--                    bpc_as_schedule_change_date(this)" id="bpc-as-datepicker" >-->
<!---->
<!--                    <span class="input-group-addon bpc-as-date-picker"><span class="glyphicon glyphicon-remove"></span></span>-->
<!--					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>-->
<!--                </div> -->
<!--				<input type="hidden" id="dtp_input2" value="" /><br/>-->


				<div id="bpc-as-schedule-loader" >
					<i class=" fa fa-spinner fa-spin"    ></i><br>
					Loading...
				</div>

            </div>     
		</div> 
	<script type="text/javascript" src="<?php print bpc_as_plugin_url; ?>/test/bootstrap-datetimepicker-master/sample in bootstrap v3/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="<?php print bpc_as_plugin_url; ?>/test/bootstrap-datetimepicker-master/sample in bootstrap v3/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php print bpc_as_plugin_url; ?>/test/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
 
	<script type="text/javascript">
			$('.form_date').datetimepicker({
		        // language:  'fr',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0,
				// daysOfWeekDisabled: [0,2,3,4,5,6] 
		    }); 
	</script> 



