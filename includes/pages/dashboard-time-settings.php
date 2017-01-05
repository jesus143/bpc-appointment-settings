 <hr>


<div class="container"> 
    <p class="lead">
        This agenda viewer will let you see multiple events cleanly!
    </p> 
    <div class="alert alert-warning">
        <h4>Mobile Support</h4>
        <p>In order to get the lines between cells looking their best without any JavaScript, I had to use tables for this design. While this could be done in ".row", doing so will cause issues when displaying the vertical borders between cells, which is a compromise I wasn't willing to make this time.'</p>
    </div> 
    <hr />

    <div class="agenda" >
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

                    <?php foreach($dates as $petsa => $date): ?>

                        <?php
                            $nameOpenFrom = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_open_from[]';
                            $nameOpenTo  = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_open_to[]';
                            $nameClose = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_business_close[]';
//                            $nameChecking       = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_display_checking[]';
                        ?>

                        <tr class="bpc-as-row-schedule" id="bpc-as-row-schedule-<?php print $petsa; ?>" >
                            <td class="agenda-date" class="active" rowspan="1">
                                <div class="dayofmonth"><?php print $petsa; ?></div>
                                <div class="dayofweek"><?php print $date['day']; ?></div>
                                <div class="shortdate text-muted"><?php print $date['month'] . ', ' .  $date['year']; ?></div>
<!--                                <input type="hidden" name="--><?php //print $nameChecking; ?><!--" value="" />-->
                            </td>
                            <td class="agenda-time">
                                <select  name="<?php print $nameOpenFrom; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_hours_option(); ?> </select>
                                <select  name="<?php print $nameOpenFrom; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_minutes_option(); ?> </select>
                            </td>
                            <td class="agenda-events">
                                <div class="agenda-event">
                                    <select  name="<?php print $nameOpenTo; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_hours_option(); ?> </select>
                                    <select  name="<?php print $nameOpenTo; ?>" class="bpc-as-hour-dropdown"><?php bpc_as_generate_minutes_option(); ?> </select>
                                </div>
                            </td>
                            <td>
                                <input name="<?php print $nameClose; ?>" type="checkbox" name="close" onclick="bpc_as_schedule_close('<?php print $petsa; ?>')" />
                                <message></message>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
