<?php

namespace App;


class Bpc_As_Calendar {

    private $eventTimeStart = '';
    private $eventTimeEnd = '';
    private $eventSummary = '';

    function __construct()
    {

    }

    // helper
    public function arrayPlaten($array) {

        $return = array();
        foreach ($array as $key => $value) {
            if (is_array($value)){ $return = array_merge($return, $this->arrayPlaten($value));}
            else {$return[$key] = $value;}
        }
        return $return;

    }
    public function getTime($eventDateTime)
    {
        $dateTimeArr = explode('T', $eventDateTime);
        $time = $dateTimeArr[1];
        $startTimeArr = explode(':', $time);
        $startTime = $startTimeArr[0] . ':' . $startTimeArr[1];
        return $startTime;
    }
    public function setEventDate($eventDateTime)
    {
        $dateTimeArr = explode('T', $eventDateTime);
        return $dateTimeArr[0];
    }

    // Event
    public function setEventResult($response=[])
    {
        $this->eventTimeStart = $response['event']['start']['dateTime'];
        $this->eventTimeEnd   = $response['event']['end']['dateTime'];
        $this->eventSummary   = $response['summary'];
    }
    public function getDateTimeStart()
    {
        return $this->eventTimeStart;
    }
    public function getDateTimeEnd()
    {
        return $this->eventTimeEnd;
    }
    public function getCurrentDate()
    {
       return date("Y-m-d") . ' ' . '00:00:00';
    }
    public function getDescription()
    {
        return $this->eventSummary;
    }
    public function getEventTimeStart()
    {
        return $this->getTime($this->getDateTimeStart());
    }
    public function getEventTimeEnd()
    {
        return $this->getTime($this->getDateTimeEnd());
    }
    public function getEventDate(){
        return $this->setEventDate($this->getDateTimeStart());
    }
    public function isGoogleEventConflictWithOpenHours($eventStartTime, $eventEndTime, $openTime, $closeTime)
    {
        if (($eventStartTime >= $openTime) && ($eventStartTime < $closeTime)) {
            return true;
        } else if(($eventEndTime > $openTime) && ($eventEndTime <= $closeTime)) {
            return true;
        } else {
            return false;
        }
    }

}