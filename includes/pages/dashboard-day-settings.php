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
                        <th>Morning</th>
                        <th>Afternoon</th>
                        <th>Evening</th>
                        <th>Close</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dates as $petsa => $date): ?>

                        <?php
                            $nameMorning    = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_morning[]';
                            $nameAfternoon  = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_afternoon[]';
                            $nameEvening    = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_evening[]';
                            $nameClose      = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_close[]';
                            $nameChecking       = $petsa . '_' . $date['month'] . '_' . $date['year'] . '_' . $date['day'] . '_display_checking[]';
                        ?>


                        <tr class="bpc-as-row-schedule" id="bpc-as-row-schedule-<?php print $petsa; ?>" >
                            <td class="agenda-date" class="active" rowspan="1">
                                <div class="dayofmonth"><?php print $petsa; ?></div>
                                <div class="dayofweek"><?php print $date['day']; ?></div>
                                <div class="shortdate text-muted"><?php print $date['month'] . ', ' .  $date['year']; ?></div>
                                <input type="hidden" name="<?php print $nameChecking; ?>" value="" />
                            </td>
                            <td class="agenda-time">
                                <div class="agenda-event">
                                    <input type="checkbox" name="<?php print $nameMorning; ?>" />
                                </div>
                            </td>
                            <td class="agenda-events">
                                <div class="agenda-event">
                                    <input type="checkbox" name="<?php print $nameAfternoon; ?>" />
                                </div>
                            </td>
                            <td class="agenda-events">
                                <div class="agenda-event">
                                    <input type="checkbox" name="<?php print $nameEvening; ?>" />
                                </div>
                            </td>
                            <td>
                                <input type="checkbox" name="<?php print $nameClose; ?>" onclick="bpc_as_schedule_close('<?php print $petsa; ?>')" />
                                <message></message>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
