 <hr>
<?php  
// // Turn off error reporting
// error_reporting(1);

// // Report runtime errors
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

// // Report all errors
// error_reporting(E_ALL);

// // Same as error_reporting(E_ALL);
// ini_set("error_reporting", E_ALL);

// // Report all errors except E_NOTICE
// error_reporting(E_ALL & ~E_NOTICE);
    /**
     * Require files
     */
    if(bpc_as_is_localhost()) { 
        require_once("E:/xampp/htdocs/practice/wordpress/wp-load.php");
    } else {
        require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php';
    }

    /**
     * Call namespace
     */
    use App\Bpc_Appointment_Settings_Breaks;
    use App\BPC_AS_DB;
      use App\bpc_appointment_setting_standard;  

    /**
     * Instantiate classes 
     */
    $bpc_AS_DB                        = new BPC_AS_DB('wp_bpc_appointment_settings');
    $bpc_Appointment_Settings_Breaks  = new Bpc_Appointment_Settings_Breaks();
    $appointment_setting_standard     = new bpc_appointment_setting_standard();
 


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

                        /**
                         * Initialized data 
                         */
                        $counter = 0;
                        $open_from_arr = [9, 30];
                        $open_to_arr = [17, 30];
                        $scheduleStatus = '';
                        $scheduleStatusStyle = '';
                        $scheduleStatusDropDownStyle = '';
                        $scheduleStatusMessage  = '';
                        $scheduleStatusButton = '';
                        $notAjax = true;
                        $scheduleRange = (!empty($scheduleRange)) ? $scheduleRange : null; 
                        $user_id = bpc_as_get_current_user_logged_in_id();
 
                        /** Get specific user standard schedule */
                        $standardAppointmentSettings = $appointment_setting_standard->getSpecificSchedule($user_id); 

                        // bpc_as_print_r_pre($standardAppointmentSettings); 
                        // print "test";

                        foreach($dates as $petsa => $date):  

                            /** Initialized */
                            $day = strtolower($date['day']);   
  
                            /** set names of the fields */
                            $nameOpenFrom     = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_open_from[]';
                            $nameOpenTo       = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_open_to[]';
                            $nameClose        = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_business_close[]'; 
                            $strDate          = $petsa . '-' . $date['month'] . '-' . $date['year'];  
                            $strDateDb        = $date['year'] . '-' .date_parse($date['month'])['month'] .'-'. $petsa; 
  
                            // print " date " . $newDate;   
                            /**  query current schedule for custom, this is to see if there is schedule for the custom with specific user, day and date*/
                            $customCurrentSchedule = $bpc_AS_DB->getSpecificSchedule($user_id, $day, $strDateDb);    

                            /**  */
                            $scheduleRangeArr = (!empty($scheduleRange[$counter])) ? $scheduleRange[$counter]  : null; 
 
                            /**
                             * set database default values, so set values from standard
                             */
                            if(empty($customCurrentSchedule)) {       
                                $breaks = [];
                                // bpc_as_print_r_pre(unserialize($standardAppointmentSettings[0][$day . '_break']));    
                                $breakTime = unserialize($standardAppointmentSettings[0][$day . '_break']);  
                                // exit; 
                                // print " day" . $day;   
                                
                                if(!empty($breakTime['break_time_hour_min'])) {
                                        $breaks = $appointment_setting_standard->convertToPropperDateTime($breakTime['break_time_hour_min']); 
                                }
                                
                                // bpc_as_print_r_pre($breaks);  
                                $open_from_arr                 = explode(':', $standardAppointmentSettings[0][$day . '_open_from']);
                                $open_to_arr                   = explode(':', $standardAppointmentSettings[0][$day . '_open_to']);
                                $scheduleStatus                = ($standardAppointmentSettings[0][$day . '_close'] == 'yes') ? 'checked' : '';
                                $scheduleStatusMessage         = ($standardAppointmentSettings[0][$day . '_close'] == 'yes') ? 'Closed All Day' : '';
                                $scheduleStatusStyle           = ($standardAppointmentSettings[0][$day . '_close'] == 'yes') ? 'background-color: rgb(251, 162, 162) !important' : '';
                                $scheduleStatusDropDownStyle   = ($standardAppointmentSettings[0][$day . '_close'] == 'yes') ? 'cursor: not-allowed; background-color: rgb(251, 162, 162) !important;' : '';
                                $scheduleStatusButton          = ($standardAppointmentSettings[0][$day . '_close'] == 'yes') ? 'disabled="disabled"' : '';  
 
                                // print " " . $day . '_close' . ' status = ' . $scheduleStatus;
                            } 

                            /**
                             * custom is not empty so set values from custom
                             */
                            else if(is_array($scheduleRangeArr)) { 
                                $open_from_arr                 = explode(':', $scheduleRange[$counter]['open_from']);
                                $open_to_arr                   = explode(':', $scheduleRange[$counter]['open_to']);
                                $scheduleStatus                = ($scheduleRange[$counter]['close'] == 'yes') ? 'checked' : '';
                                $scheduleStatusMessage         = ($scheduleRange[$counter]['close'] == 'yes') ? 'Closed All Day' : '';
                                $scheduleStatusStyle           = ($scheduleRange[$counter]['close'] == 'yes') ? 'background-color: rgb(251, 162, 162) !important' : '';
                                $scheduleStatusDropDownStyle   = ($scheduleRange[$counter]['close'] == 'yes') ? 'cursor: not-allowed; background-color: rgb(251, 162, 162) !important;' : '';
                                $scheduleStatusButton          = ($scheduleRange[$counter]['close'] == 'yes') ? 'disabled="disabled"' : '';
                            }

                            /**
                             * set default values for all partners
                             */
                            $open_from_arr[0]  = ($open_from_arr[0] == '00') ? 9 : $open_from_arr[0];
                            $open_from_arr[1]  = ($open_from_arr[1] == '00') ? 0 : $open_from_arr[1];
                            $open_to_arr[0]    = ($open_to_arr[0] == '00')   ? 17 : $open_to_arr[0];
                            $open_to_arr[1]    = ($open_to_arr[1] == '00')   ? 30 : $open_to_arr[1];
 
                            ?>
                            <tr class="bpc-as-row-schedule" id="bpc-as-row-schedule-<?php print $petsa; ?>" style="<?php print $scheduleStatusStyle; ?>" >

                                <td class="agenda-date" class="active" rowspan="1">
                                    <div class="dayofmonth"><?php print $petsa; ?></div>
                                    <div class="dayofweek"><?php print $date['day']; ?></div>
                                    <div class="shortdate text-muted"><?php print $date['month'] . ', ' .  $date['year']; ?></div>
                                </td>

                                <td class="agenda-time" >
                                    <select style="<?php print $scheduleStatusDropDownStyle; ?>"  name="<?php print $nameOpenFrom; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_hours_option($open_from_arr[0]); ?> </select>
                                    <select style="<?php print $scheduleStatusDropDownStyle; ?>" name="<?php print $nameOpenFrom; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_minutes_option($open_from_arr[1]); ?> </select>
                                </td>

                                <td class="agenda-events" >
                                    <div class="agenda-event">
                                        <select style="<?php print $scheduleStatusDropDownStyle; ?>" name="<?php print $nameOpenTo; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_hours_option($open_to_arr[0]); ?> </select>
                                        <select style="<?php print $scheduleStatusDropDownStyle; ?>" name="<?php print $nameOpenTo; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_minutes_option($open_to_arr[1]); ?> </select>
                                    </div>
                                </td>

                                <td  >
                                    <input name="<?php print $nameClose; ?>" type="checkbox" name="close" onclick="bpc_as_schedule_close('<?php print $petsa; ?>')"  <?php print $scheduleStatus; ?> />
                                    <message><em><?php print $scheduleStatusMessage; ?></em></message>
                                </td>

                                <td class="bpc-as-break-time-container-td"  >
                                
                                    <input <?php print $scheduleStatusButton ?> style="<?php print $scheduleStatusDropDownStyle; ?>" type="button" value="Add Break" onclick="bpc_as_add_time_break('<?php print $strDate; ?>')" >
                                    <br>
                                    <form> </form>
                                    <form id="bpc-as-break-time-container-form-<?php print $strDate; ?>" >
                                        <input type="hidden" value="<?php print $strDate; ?>" name="strDate" />

                                        <ul class="bpc-as-break-time-container-ul" id="bpc-as-break-time-container-<?php print $strDate; ?>" >
                                           <?php 


                                                /**
                                                 * If custom schedule is empty meaning we need to load the break for standard
                                                 */
                                                if(empty($customCurrentSchedule)) {           
                                                    
                                                    foreach($breaks as $break) {

                                                        $breakId = $break['id'];
                                                        $break_from_arr = explode(':',$break['break_from']);
                                                        $break_to_arr   = explode(':',$break['break_to']);

                                                        $break_from_hour = $break_from_arr[0];
                                                        $break_from_min  = $break_from_arr[1];
                                                        $break_to_hour   = $break_to_arr[0];
                                                        $break_to_min    = $break_to_arr[1];
   
                                                        bpc_phone_schedule_break_design(
                                                            $breakId,
                                                            $strDate,
                                                            $break_from_hour,
                                                            $break_from_min,
                                                            $break_to_hour,
                                                            $break_to_min,
                                                            $scheduleStatusStyle,
                                                            $scheduleStatusDropDownStyle,
                                                            $scheduleStatusButton
                                                        );
                                                    }
                                                }  
                                                /**
                                                 * Else custom schedule is not empty then load custom breaks
                                                 */
                                                else {  

                                                    /**   
                                                     *  Initialized 
                                                     */
                                                    $breaks = [];
                                                    $phoneCallSettings = $bpc_AS_DB->getPhoneCallSettings(bpc_as_set_date_as_db_format($strDate));

                                                    if(!empty($phoneCallSettings)) {

                                                        $appointment_setting_id = $phoneCallSettings[0]['id'];

                                                        $breaks = $bpc_Appointment_Settings_Breaks->getAllBreaksByAppointmentId($appointment_setting_id);

                                                        foreach($breaks as $break) {

                                                            $breakId = $break['id'];
                                                            $break_from_arr = explode(':',$break['break_from']);
                                                            $break_to_arr   = explode(':',$break['break_to']);

                                                            $break_from_hour = $break_from_arr[0];
                                                            $break_from_min  = $break_from_arr[1];
                                                            $break_to_hour   = $break_to_arr[0];
                                                            $break_to_min    = $break_to_arr[1];
       
                                                            bpc_phone_schedule_break_design(
                                                                $breakId,
                                                                $strDate,
                                                                $break_from_hour,
                                                                $break_from_min,
                                                                $break_to_hour,
                                                                $break_to_min,
                                                                $scheduleStatusStyle,
                                                                $scheduleStatusDropDownStyle,
                                                                $scheduleStatusButton
                                                            );
                                                        }
                                                    }
                                                } 

                                           ?>
                                        </ul>
                                    </form>

                                    <input <?php print $scheduleStatusButton; ?> style="<?php print $scheduleStatusDropDownStyle; ?>;display:none" type="button" value="Update" onClick="bpc_as_update_time_break('<?php print $strDate; ?>')" />

                                    <div id="bpc-message-break-time-<?php print $strDate; ?>" style="display:none">
                                    </div>

                                    <div id="bpc-loader-break-time-<?php print $strDate; ?>" style="display:none">
                                        <div id="break-time-update-loader-<?php print $day; ?>" >
                                            <i class=" fa fa-spinner fa-spin"   ></i> 
                                        </div> 
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
