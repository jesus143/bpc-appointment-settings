
	<link href="<?php print bpc_as_plugin_url; ?>/test/bootstrap-datetimepicker-master/sample in bootstrap v3/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" /> 
    <link href="<?php print bpc_as_plugin_url; ?>/test/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" />
    <style type="text/css" media="screen">
    	.datetimepicker  {
    		width:30%;
    	} 
    </style> 
		<!-- date picker  -->
		<div class="container">   
			<div class="form-group" > 
                <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="padding-left: 0px;">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<input type="hidden" id="dtp_input2" value="" /><br/>
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
				forceParse: 0
		    });
	</script>
	
	<br><hr><br> 