<br><br>
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

            <input type="text" value="Book Time Of Day" name="book_time_type" />

            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Days</th>
                        <th>Morning</th>
                        <th>Afternoon</th>
                        <th>Evening</th>
                        <th>Closed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        $open_to_arr = [];
                        $open_from_arr = [];
                        $scheduleStatus = '';
                        $scheduleStatusStyle = '';
                        $scheduleStatusDropDownStyle = '';
                        $scheduleStatusDisable = '';
                        $scheduleStatusMessage = '';
                        $morningSelected  = '';
                        $afternoonSelected = '';
                        $eveningSelected  = '';

                        $counter=0;


                        // print" <pre>";
                        // print_r($scheduleRange);
                        // print" </pre>";

                        foreach($dates as $petsa => $date):

                            $nameMorning    = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_morning[]';
                            $nameAfternoon  = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_afternoon[]';
                            $nameEvening    = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_evening[]';
                            $nameClose      = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_close[]';
                            $nameChecking       = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_display_checking[]';

                            $day = strtolower($days[$counter]);
                            $counter1 = 0;
                            if(!empty($scheduleRange)) {

                                $morningSelected               = ($scheduleRange[$counter1][$day . '_morning'] == 'yes') ? 'checked' : '';
                                $afternoonSelected             = ($scheduleRange[$counter1][$day . '_afternoon'] == 'yes') ? 'checked' : '';
                                $eveningSelected               = ($scheduleRange[$counter1][$day . '_evening'] == 'yes') ? 'checked' : '';

                                $scheduleStatus                = ($scheduleRange[$counter1][$day . '_close'] == 'yes') ? 'checked' : '';
                                $scheduleStatusMessage         = ($scheduleRange[$counter1][$day . '_close'] == 'yes') ? 'Closed All Day' : '';
                                $scheduleStatusStyle           = ($scheduleRange[$counter1][$day . '_close'] == 'yes') ? 'background-color: rgb(251, 162, 162) !important' : '';
                                $scheduleStatusDisable         = ($scheduleRange[$counter1][$day . '_close'] == 'yes') ? 'disabled' : '';
                            }
                        ?>



                        <tr class="bpc-as-row-schedule" id="bpc-as-row-schedule-<?php print $petsa; ?>" style="<?php print $scheduleStatusStyle; ?>"  >
                            <td class="agenda-date active" id="agenda-time-0-<?php print $petsa; ?>"   rowspan="1">
                                <div  style="display:none"  class="dayofmonth"><?php print $petsa; ?></div>
                                <div class="dayofweek"><?php print ucfirst($day); //$date['day']; ?></div>
                                <div style="display:none" class="shortdate text-muted"><?php print $date['month'] . ', ' .  $date['year']; ?></div>
                                <input style="display:none" type="hidden" name="<?php print $nameChecking; ?>" value="" />
                            </td>
                            <td class="agenda-time" id="agenda-time-1-<?php print $petsa; ?>"  >
                                <div class="agenda-event">
                                    <input type="checkbox" name="<?php print ucfirst($day); ?>_morning"    <?php print $scheduleStatusDisable; ?>  <?php print $morningSelected; ?> />
                                </div>
                            </td>
                            <td class="agenda-events" id="agenda-time-2-<?php print $petsa; ?>"   >
                                <div class="agenda-event">
                                    <input type="checkbox" name="<?php print ucfirst($day); ?>_afternoon" <?php print $scheduleStatusDisable; ?>  <?php print $afternoonSelected; ?>  />
                                </div>
                            </td>
                            <td class="agenda-events" id="agenda-time-3-<?php print $petsa; ?>"  >
                                <div class="agenda-event">
                                    <input type="checkbox" name="<?php print ucfirst($day); ?>_evening"   <?php print $scheduleStatusDisable; ?>  <?php print $eveningSelected; ?>  />
                                </div>
                            </td>
                            <td  id="agenda-time-4-<?php print $petsa; ?>"   >
                                <input type="checkbox" name="<?php print ucfirst($day); ?>_business_close" onclick="bpc_as_schedule_close('<?php print $petsa; ?>')"  <?php print $scheduleStatus; ?> />
                                <message><em><?php print $scheduleStatusMessage; ?></em></message>
                            </td>
                        </tr>
                    <?php
                            $counter++;
                        endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
