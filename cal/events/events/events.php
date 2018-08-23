<?php
session_start();
require('../../oauth.php');
require('../../outlook.php');
$fetchEvents = OutlookService::getEvents($_SESSION['access_token'], $_SESSION['user_email']);
//print_r($fetchEvents);
$events = array();
foreach($fetchEvents['value'] as $eachEvent){
	$event = new stdClass();
	$event->name = $eachEvent['Subject'];
	$event->image = '';
	$event->day = date('j', strtotime($eachEvent['Start']['DateTime']));
	$event->month = date('n', strtotime($eachEvent['Start']['DateTime']));
	$event->year = date('Y', strtotime($eachEvent['Start']['DateTime']));
	/*if (!$row{'end_date'} || ($row{'end_date'} == '0000-00-00')) {
		$event->duration = 1; // If end_time is blank -> event's duration = 1 (day).	
	} else {
		if (date('Ymd', strtotime($row{'start_date'})) == date('Ymd', strtotime($row{'end_date'}))) { // If start date and end date are same day -> event's duration = 1 (day).
			$event->duration = 1;
		} else {
			$start_day = date('Y-m-d', strtotime($row{'start_date'}));
			$end_day = date('Y-m-d', strtotime($row{'end_date'}));
			$event->duration = ceil(abs(strtotime($end_day) - strtotime($start_day)) / 86400) + 1; // Get event's duration = days between start date and end date.
		}
	}*/
	//$event->duration = '10:00';
	$event->time = date('H:i', strtotime($eachEvent['Start']['DateTime']. ' UTC'));
	$event->color = '4';
	$event->location = 'skype';
	$string = $eachEvent['Body']['Content'];
	if (preg_match('/<body>-(.*?)-</body>/', $string, $display) === 1) {
		$event->description =  $display[1];
	}
	//$event->description = 'sdad asd ad ';
	array_push($events, $event);
}
echo json_encode($events);


?>