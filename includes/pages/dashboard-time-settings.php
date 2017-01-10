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
        <div class="table-responsive bpc-as-table-display">
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
                    <?php

                        $counter = 0;
                        $open_to_arr = [];
                        $open_from_arr = [];
                        $scheduleStatus = '';
                        $scheduleStatusStyle = '';
                        $scheduleStatusDropDownStyle = '';
                        $scheduleStatusMessage  = '';

                        foreach($dates as $petsa => $date):
                            $nameOpenFrom    = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_open_from[]';
                            $nameOpenTo      = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_open_to[]';
                            $nameClose       = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_business_close[]';


                            if(!empty($scheduleRange)) {
                                $open_from_arr                 = explode(':', $scheduleRange[$counter]['open_from']);
                                $open_to_arr                   = explode(':', $scheduleRange[$counter]['open_to']);
                                $scheduleStatus                = ($scheduleRange[$counter]['close'] == 'yes') ? 'checked' : '';
                                $scheduleStatusMessage         = ($scheduleRange[$counter]['close'] == 'yes') ? 'Closed All Day' : '';
                                $scheduleStatusStyle           = ($scheduleRange[$counter]['close'] == 'yes') ? 'background-color: rgb(251, 162, 162)' : '';
                                $scheduleStatusDropDownStyle   = ($scheduleRange[$counter]['close'] == 'yes') ? 'cursor: not-allowed; background-color: rgb(251, 162, 162);' : '';
                            }?>
                            <tr class="bpc-as-row-schedule" id="bpc-as-row-schedule-<?php print $petsa; ?>" style="<?php print $scheduleStatusStyle; ?>" >
                                <td class="agenda-date" class="active" rowspan="1">
                                    <div class="dayofmonth"><?php print $petsa; ?></div>
                                    <div class="dayofweek"><?php print $date['day']; ?></div>
                                    <div class="shortdate text-muted"><?php print $date['month'] . ', ' .  $date['year']; ?></div>
                                </td>
                                <td class="agenda-time">
                                    <select style="<?php print $scheduleStatusDropDownStyle; ?>"  name="<?php print $nameOpenFrom; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_hours_option($open_from_arr[0]); ?> </select>
                                    <select style="<?php print $scheduleStatusDropDownStyle; ?>" name="<?php print $nameOpenFrom; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_minutes_option($open_from_arr[1]); ?> </select>
                                </td>
                                <td class="agenda-events">
                                    <div class="agenda-event">
                                        <select style="<?php print $scheduleStatusDropDownStyle; ?>" name="<?php print $nameOpenTo; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_hours_option($open_to_arr[0]); ?> </select>
                                        <select style="<?php print $scheduleStatusDropDownStyle; ?>" name="<?php print $nameOpenTo; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_minutes_option($open_to_arr[1]); ?> </select>
                                    </div>
                                </td>
                                <td>
                                    <input name="<?php print $nameClose; ?>" type="checkbox" name="close" onclick="bpc_as_schedule_close('<?php print $petsa; ?>')"  <?php print $scheduleStatus; ?> />
                                    <message><em><?php print $scheduleStatusMessage; ?></em></message>
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
