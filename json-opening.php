<?php
include("config.php");

$res = array();
$openarr = opening_get();

$i = 0;
$today = new DateTime();
$today_ymd = $today->format('Y-m-d');
$today_h = $today->format('G');
foreach($openarr as $opendate => $openhours) {
	if(!strcmp($opendate, $today_ymd)) {
		foreach($openhours as $key => $value) {
			if($key > $today_h && strcmp($key, 'day')) {
				$key = sprintf("%02d", $key);
				$res [$i] = array(
					"id"		=> $i,
					"start"		=> $opendate."T".$key.":00:00",
					"end"		=> $opendate."T".$key.":59:59",
					"rendering"	=> "background"
				);
				$i++;
			}
		}
	} else {
		foreach($openhours as $key => $value) {
			if(strcmp($key, 'day')) {
				$key = sprintf("%02d", $key);
				$res [$i] = array(
					"id"		=> $i,
					"start"		=> $opendate."T".$key.":00:00",
					"end"		=> $opendate."T".$key.":59:59",
					"rendering"	=> "background"
				);
				$i++;
			}
		}
	}
	if($i != 0) {
		$res [$i] = array(
			"id"		=> $i,
			"start"		=> $opendate,
			"rendering"	=> "background",
			"allDay"	=> TRUE
		);
		$i++;
	}
}

echo json_encode($res);
?>
