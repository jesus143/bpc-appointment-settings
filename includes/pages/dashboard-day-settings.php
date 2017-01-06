 <hr>


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
        <div class="table-responsive">
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Days</th>
                        <th>Morning</th>
                        <th>Afternoon</th>
                        <th>Evening</th>
                        <th>Close</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        $counter = 0;
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


                        foreach($dates as $petsa => $date):

                            $nameMorning    = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_morning[]';
                            $nameAfternoon  = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_afternoon[]';
                            $nameEvening    = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_evening[]';
                            $nameClose      = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_close[]';
                            $nameChecking       = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_display_checking[]';



                            if(!empty($scheduleRange)) {


                                $morningSelected                = ($scheduleRange[$counter]['morning'] == 'yes') ? 'checked' : '';
                                $afternoonSelected                = ($scheduleRange[$counter]['afternoon'] == 'yes') ? 'checked' : '';
                                $eveningSelected                = ($scheduleRange[$counter]['evening'] == 'yes') ? 'checked' : '';

                                $scheduleStatus                = ($scheduleRange[$counter]['close'] == 'yes') ? 'checked' : '';
                                $scheduleStatusMessage         = ($scheduleRange[$counter]['close'] == 'yes') ? 'Closed All Day' : '';
                                $scheduleStatusStyle           = ($scheduleRange[$counter]['close'] == 'yes') ? 'background-color: rgb(251, 162, 162)' : '';
                                $scheduleStatusDisable         = ($scheduleRange[$counter]['close'] == 'yes') ? 'disabled' : '';
                            }

                        ?>


                        <tr class="bpc-as-row-schedule" id="bpc-as-row-schedule-<?php print $petsa; ?>" style="<?php print $scheduleStatusStyle; ?>"  >
                            <td class="agenda-date" class="active" rowspan="1">
                                <div class="dayofmonth"><?php print $petsa; ?></div>
                                <div class="dayofweek"><?php print $date['day']; ?></div>
                                <div class="shortdate text-muted"><?php print $date['month'] . ', ' .  $date['year']; ?></div>
                                <input type="hidden" name="<?php print $nameChecking; ?>" value="" />
                            </td>
                            <td class="agenda-time">
                                <div class="agenda-event">
                                    <input type="checkbox" name="<?php print $nameMorning; ?>"    <?php print $scheduleStatusDisable; ?>  <?php print $morningSelected; ?> />
                                </div>
                            </td>
                            <td class="agenda-events">
                                <div class="agenda-event">
                                    <input type="checkbox" name="<?php print $nameAfternoon; ?>" <?php print $scheduleStatusDisable; ?>  <?php print $afternoonSelected; ?>  />
                                </div>
                            </td>
                            <td class="agenda-events">
                                <div class="agenda-event">
                                    <input type="checkbox" name="<?php print $nameEvening; ?>"   <?php print $scheduleStatusDisable; ?>  <?php print $eveningSelected; ?>  />
                                </div>
                            </td>
                            <td>
                                <input type="checkbox" name="<?php print $nameClose; ?>" onclick="bpc_as_schedule_close('<?php print $petsa; ?>')"  <?php print $scheduleStatus; ?> />
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
