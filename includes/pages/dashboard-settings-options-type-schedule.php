 

<div class="container dashboard-settings-option">  
	<div class="row">
		<div class="col-md-3">
		<h5>Book Exact Time: &nbsp;&nbsp; <input type='radio'   id="bpc-as-bookTimeSorting" name="bookTimeSorting" checked onclick="bpc_as_schedule_type('book exact time')" value="book exact time" <?php print $book_exact_time; ?>  />  </h5>
		 	  
		</div>
		<div class="col-md-3">
			<h5>Book Time Of Day &nbsp;&nbsp; <input type='radio' id="bpc-as-bookTimeSorting" name="bookTimeSorting" onclick="bpc_as_schedule_type('book time of day')" value="book time of day" <?php print $book_exact_day; ?> /> </h5>
		</div>
	</div> 
</div>
<style type="text/css" media="screen">
	.dashboard-settings-option select {
		padding:20px;
	}
</style>
