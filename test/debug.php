<?php




print getSecondMaxValue([
    10,1,2,3,4,5,6,7,8,9

]);

function getMaxValue($array) {

    $max = $array[0];

    for($i=0; $i<count($array); $i++) {
        if($max < $array[$i]) {
            $max = $array[$i];

        }


        if($i==count($array)-1) {
        }
    }
    return $max;
}

function getSecondMaxValue($array) {
    $max  = $array[0];
    $list[0] =  $max;
    for($i=0; $i<count($array); $i++) {
        if($max < $array[$i]) {
            $max    = $array[$i];
            $list[] = $array[$i];
        }
    }

    print_r($list);
}




exit;


$openTime    = strtotime('9:00');
$closeTime   = strtotime('17:30');
$eventStartTime  = strtotime(getTime('2017-01-16T08:30:00+08:00'));
$eventEndTime  = strtotime(getTime('2017-01-16T10:50:00+08:00'));


print "1 $openTime 2 $closeTime 3 $eventStartTime 4 $eventEndTime event date " . getDate1('2017-01-16T08:30:00+08:00')
. "\n";


if(isGoogleEventConflictWithOpenHours($eventStartTime, $eventEndTime, $openTime, $closeTime)){
    print "close";
} else {
    print "open";
}

function isGoogleEventConflictWithOpenHours($eventStartTime, $eventEndTime, $openTime, $closeTime)
{
    if (($eventStartTime >= $openTime) && ($eventStartTime < $closeTime)) {
        print "1";
        return true;
    } else if(($eventEndTime > $openTime) && ($eventEndTime <= $closeTime)) {
        print "2";
        return true;
    } else {
        print "3";
        return false;
    }
}
function getTime($eventDateTime)
{
    $dateTimeArr = explode('T', $eventDateTime);
    $time = $dateTimeArr[1];
    $startTimeArr = explode(':', $time);
    $startTime = $startTimeArr[0] . ':' . $startTimeArr[1];
    return $startTime;
}

function getDate1($eventDateTime)
{
    $dateTimeArr = explode('T', $eventDateTime);
    return $dateTimeArr[0];

}