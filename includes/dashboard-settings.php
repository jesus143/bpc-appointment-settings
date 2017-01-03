 <hr>
<style type="text/css" media="screen">

	.agenda {  }

	/* Dates */
	.agenda .agenda-date { width: 170px; }
	.agenda .agenda-date .dayofmonth {
	  width: 40px;
	  font-size: 36px;
	  line-height: 36px;
	  float: left;
	  text-align: right;
	  margin-right: 10px; 
	}
	.agenda .agenda-date .shortdate {
	  font-size: 0.75em; 
	}


	/* Times */
	.agenda .agenda-time { width: 140px; } 


	/* Events */
	.agenda .agenda-events {  } 
	.agenda .agenda-events .agenda-event {  } 

	@media (max-width: 767px) {
	    
	}
	
</style>

<div class="container"> 
    <p class="lead">
        This agenda viewer will let you see multiple events cleanly!
    </p> 
    <div class="alert alert-warning">
        <h4>Mobile Support</h4>
        <p>In order to get the lines between cells looking their best without any JavaScript, I had to use tables for this design. While this could be done in ".row", doing so will cause issues when displaying the vertical borders between cells, which is a compromise I wasn't willing to make this time.'</p>
    </div> 
    <hr />

    <div class="agenda">
        <div class="table-responsive">
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Days</th>
                        <th>Open From</th>
                        <th>Open To</th> 
                        <th>Close</th> 
                    </tr>
                </thead>
                <tbody>
                    <!-- Single event in a single day -->
                    <tr>
                        <td class="agenda-date" class="active" rowspan="1">
                            <div class="dayofmonth">26</div>
                            <div class="dayofweek">Saturday</div>
                            <div class="shortdate text-muted">July, 2014</div>
                        </td>
                        <td class="agenda-time">
                            5:30 AM
                        </td>
                        <td class="agenda-events">
                            <div class="agenda-event">
                                <i class="glyphicon glyphicon-repeat text-muted" title="Repeating event"></i> 
                                Fishing
                            </div>
                        </td>
                        <td>
                        	<input type="checkbox" name="close" />
                        </td>
                    </tr>
                    
                    <!-- Multiple events in a single day (note the rowspan) -->
                    <tr>
                        <td class="agenda-date" class="active" rowspan="3">
                            <div class="dayofmonth">24</div>
                            <div class="dayofweek">Thursday</div>
                            <div class="shortdate text-muted">July, 2014</div>
                        </td>
                        <td class="agenda-time">
                            8:00 - 9:00 AM 
                        </td>
                        <td class="agenda-events">
                            <div class="agenda-event">
                                Doctor's Appointment
                            </div>
                        </td>
   						<td>
                        	<input type="checkbox" name="close" />
                        </td>
                    </tr>
                    <tr>
                        <td class="agenda-time">
                            10:15 AM - 12:00 PM 
                        </td>
                        <td class="agenda-events">
                            <div class="agenda-event">
                                Meeting with executives
                            </div>
                        </td>
                     	<td>
                        	<input type="checkbox" name="close" />
                        </td>
                    </tr>
                    <tr>
                        <td class="agenda-time">
                            7:00 - 9:00 PM
                        </td>
                        <td class="agenda-events">
                            <div class="agenda-event">
                                Aria's dance recital
                            </div>
                        </td>
                		<td>
                        	<input type="checkbox" name="close" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
