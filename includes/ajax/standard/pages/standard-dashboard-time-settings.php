<br><br>
<?php

    if(bpc_as_is_localhost()) {
        require_once("E:/xampp/htdocs/practice/wordpress/wp-load.php");
    } else {
        require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php';
    }

    use App\Bpc_Appointment_Settings_Breaks;
    use App\BPC_AS_DB; 

    $bpc_AS_DB = new BPC_AS_DB('wp_bpc_appointment_settings');
    $bpc_Appointment_Settings_Breaks  = new Bpc_Appointment_Settings_Breaks();  


?> 

<div class="container">

<!--    <p class="lead">-->
<!--        This agenda viewer will let you see multiple events cleanly!-->
<!--    </p> -->
<!--    <div class="alert alert-warning">-->
<!--        <h4>Mobile Support</h4>-->
<!--        <p>In order to get the lines between cells looking their best without any JavaScript, I had to use tables for this design. While this could be done in ".row", doing so will cause issues when displaying the vertical borders between cells, which is a compromise I wasn't willing to make this time.'</p>-->
<!--    </div> -->
<!--    <hr />-->

    <div class="agenda" >
        <div class="table-responsive bpc-as-table-display">

            <input type="hidden" value="Book Exact Time" name="book_time_type" />

            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Days</th>
                        <th>Open From</th>
                        <th>Open To</th>
                        <th>Closed</th>
                        <th>Break</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $counter = 0;
                        $open_from_arr = [9, 30];
                        $open_to_arr = [17, 30];
                        $scheduleStatus = '';
                        $scheduleStatusStyle = '';
                        $scheduleStatusDropDownStyle = '';
                        $scheduleStatusMessage  = '';
                        $scheduleStatusButton = '';
                        $notAjax = true; 
                        $scheduleStandard = (!empty($scheduleRange)) ? $scheduleRange : null;  

                        // bpc_as_print_r_pre($scheduleStandard); 
 
                        /**
                         *  Start looping date so that we can display the ui 
                         */
                        foreach($dates as $petsa => $date):

                            $day1 = $days[$counter];
                            $day = $date['day'];
                            $breaks = [];

                            // set names of the fields
                            $nameOpenFrom    = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $day1 . '_open_from[]';
                            $nameOpenTo      = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $day1 . '_open_to[]';
                            $nameClose       = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $day1 . '_business_close[]';
                            $strDate         = $petsa . '-' . $date['month'] . '-' . $date['year'];
                            // $scheduleRangeArr = (!empty($scheduleRange[$counter])) ? $scheduleRange[$counter]  : null; 

                            /**  This will get specific break of the day */ 
                            $break = unserialize($scheduleStandard[0][strtolower($day1) . '_break']);
                            // bpc_as_print_r_pre($break);  
                             
                            /** new compose break */   
                            if(!empty($break['break_time_hour_min'])) {
                               $breaks = $bpc_appointment_setting_standard->convertToPropperDateTime($break['break_time_hour_min']);  
                            }
                            /** end compose break */


                                // print "<pre>"; 
                                // print_r($breaks);     
                                // print "<br><br><br>";

                            /**
                             *  get results by day only
                             */
                            $scheduleRange = $bpc_appointment_setting_standard->getResultByDay($day1, $scheduleStandard, $counter);

                            /**
                             *   result assignment, to enable adopt custom version
                             */
                            $scheduleRangeArr =   $scheduleRange;  
                            // bpc_as_print_r_pre($scheduleRangeArr);


                            /**
                             * set database default values, if saved already
                             */
                            if(is_array($scheduleRangeArr)) {  

                                $open_from_arr                 = explode(':', $scheduleRange[$counter]['open_from']);
                                $open_to_arr                   = explode(':', $scheduleRange[$counter]['open_to']);

                                $scheduleStatus                = ($scheduleRange[$counter]['close'] == 'yes') ? 'checked' : '';
                                $scheduleStatusMessage         = ($scheduleRange[$counter]['close'] == 'yes') ? 'Closed All Day' : '';
                                $scheduleStatusStyle           = ($scheduleRange[$counter]['close'] == 'yes') ? 'background-color: rgb(251, 162, 162) !important' : '';
                                $scheduleStatusDropDownStyle   = ($scheduleRange[$counter]['close'] == 'yes') ? 'cursor: not-allowed; background-color: rgb(251, 162, 162) !important;' : '';
                                $scheduleStatusButton          = ($scheduleRange[$counter]['close'] == 'yes') ? 'disabled="disabled"' : '';


                            } else if ($day1 == 'Saturday' ||$day1  == 'Sunday') {
                                $scheduleStatus                = 'checked';
                                $scheduleStatusMessage         = 'Closed All Day';
                                $scheduleStatusStyle           = 'background-color: rgb(251, 162, 162) !important';
                                $scheduleStatusDropDownStyle   = 'cursor: not-allowed; background-color: rgb(251, 162, 162) !important;';
                                $scheduleStatusButton          = 'disabled="disabled"';
                            }

                            // set default values for all partners, for open from and open to schedule
                            $open_from_arr[0]  = ($open_from_arr[0] == '00') ? 9 : $open_from_arr[0];
                            $open_from_arr[1]  = ($open_from_arr[1] == '00') ? 0 : $open_from_arr[1];
                            $open_to_arr[0]    = ($open_to_arr[0] == '00') ? 17 : $open_to_arr[0];
                            $open_to_arr[1]    = ($open_to_arr[1] == '00') ? 30 : $open_to_arr[1];

                            ?>
                            <tr class="bpc-as-row-schedule" id="bpc-as-row-schedule-<?php print $petsa; ?>" style="<?php print $scheduleStatusStyle; ?>" >
                                <td class="agenda-date" id="agenda-time-0-<?php print $petsa; ?>"       rowspan="1">
                                    <div class="dayofweek"><?php print $day1; ?></div>
                                </td>
                                <td class="agenda-time" id="agenda-time-1-<?php print $petsa; ?>"  >
                                    <select style="<?php print $scheduleStatusDropDownStyle; ?>"  name="<?php print $nameOpenFrom; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_hours_option($open_from_arr[0]); ?> </select>
                                    <select style="<?php print $scheduleStatusDropDownStyle; ?>" name="<?php print $nameOpenFrom; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_minutes_option($open_from_arr[1]); ?> </select>
                                </td>
                                <td class="agenda-events" id="agenda-time-2-<?php print $petsa; ?>"   >
                                    <div class="agenda-event">
                                        <select style="<?php print $scheduleStatusDropDownStyle; ?>" name="<?php print $nameOpenTo; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_hours_option($open_to_arr[0]); ?> </select>
                                        <select style="<?php print $scheduleStatusDropDownStyle; ?>" name="<?php print $nameOpenTo; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_minutes_option($open_to_arr[1]); ?> </select>
                                    </div>
                                </td>
                                <td id="agenda-time-3-<?php print $petsa; ?>" >
                                    <input name="<?php print $nameClose; ?>" type="checkbox" name="close" onclick="bpc_as_schedule_close('<?php print $petsa; ?>')"  <?php print $scheduleStatus; ?> />
                                    <message><em><?php print $scheduleStatusMessage; ?></em></message>
                                </td>
                                <td class="bpc-as-break-time-container-td" id="agenda-time-4-<?php print $petsa; ?>"  >


                                    <input <?php print $scheduleStatusButton ?> style="<?php print $scheduleStatusDropDownStyle; ?>;background: #d7090a;color: white;padding: 5px;" type="button"  type="button" value="Add Break"   onclick="bpc_as_add_time_break('<?php print $strDate; ?>', 'standard',  '<?php print $day1; ?>')" >
                                    <br>
                                    <form> </form>

                                    <form id="bpc-as-break-time-container-form-<?php print $strDate; ?>"   class="<?php print $day1; ?>_form_class">


                                        <input type="hidden" value="<?php print $strDate; ?>" name="strDate" />
                                        <input type="hidden" value="<?php print $day1; ?>" name="day" />

                                        <ul class="bpc-as-break-time-container-ul" id="bpc-as-break-time-container-<?php print $strDate; ?>" >
                                           <?php
  
                                                // $phoneCallSettings = $bpc_AS_DB->getPhoneCallSettings(bpc_as_set_date_as_db_format($strDate));

                                                if(!empty($breaks)) {

                                                    // $appointment_setting_id = $phoneCallSettings[0]['id']; 
                                                    // $breaks                 = $bpc_Appointment_Settings_Breaks->getAllBreaksByAppointmentId($appointment_setting_id);
                                                    
                                                    foreach($breaks as $break) { 

                                                        /** 
                                                         *  Break id assignment
                                                         */
                                                        $breakId = 1;

                                                        /**
                                                         *  explode break times 
                                                         */ 
                                                        $break_from_arr = explode(':',$break['break_from']);
                                                        $break_to_arr   = explode(':',$break['break_to']); 

                                                        /**
                                                         *  separate breaks in order to display break in the right side 
                                                         */
                                                        $break_from_hour = $break_from_arr[0];
                                                        $break_from_min  = $break_from_arr[1];
                                                        $break_to_hour   = $break_to_arr[0];
                                                        $break_to_min    = $break_to_arr[1];  
                                                         
                                                        /**
                                                         * Print the break designs
                                                         */
                                                        bpc_phone_schedule_standard_break_design(
                                                            $breakId,
                                                            $strDate,
                                                            $break_from_hour,
                                                            $break_from_min,
                                                            $break_to_hour,
                                                            $break_to_min,
                                                            $scheduleStatusStyle,
                                                            $scheduleStatusDropDownStyle,
                                                            $scheduleStatusButton,
                                                            $day1
                                                        );
                                                    }
                                                }
                                           ?>
                                        </ul>
                                    </form>

                                    <!-- allow update schedule when hit button -->
                                    <div style="display:none">
                                    <input <?php print $scheduleStatusButton; ?> style="<?php print $scheduleStatusDropDownStyle; ?>" type="button" value="Update" onClick="bpc_as_update_time_break('<?php print $strDate; ?>')" />

                                    </div>
                                    <div id="bpc-message-break-time-<?php print $strDate; ?>">
                                    </div>

                                    <!-- loading area, show waiting/done saving status for all schedule -->
                                    <div id="bpc-loader-break-time-<?php print $strDate; ?>" style="display:none">
                                        Loading...
                                    </div> 

                                    <div style="display:none" id="break-time-update-loader-<?php print $day1; ?>" >
                                        <i class=" fa fa-spinner fa-spin"   ></i><br>
                                        Loading...
                                    </div>
                                </td>   
                            </tr><?php
                            $counter++;
                        endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
