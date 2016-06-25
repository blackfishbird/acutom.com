<?php
session_start();
include("secret.php");

define("DB_LANG", "utf8");
define("DB_TIMEZONE","America/New_York");

if(function_exists('date_default_timezone_set'))
	date_default_timezone_set(DB_TIMEZONE);
else
	putenv("TZ=".DB_TIMEZONE);

define("HP_TITLE", "ACUTOM.com");
define("HP_URL", "http://acutom.com/");
define("HP_ADMIN_URL", HP_URL."admin-reserve.php");
define("HP_CANCEL_URL", HP_URL."cancel.php");

// Paypal set
define("USE_SANDBOX", 1);
if(USE_SANDBOX == true) {
	define("PAYPAL_ACTION", "https://www.sandbox.paypal.com/cgi-bin/webscr");
	define("PAYPAL_BUSINESS", "paypalsell@sendbox.com");
} else {
	define("PAYPAL_ACTION", "https://www.paypal.com/cgi-bin/webscr");
	define("PAYPAL_BUSINESS", "ificouldrememberit@gmail.com");
}
define("PAYPAL_RETURN", HP_URL."thanks.php");
define("PAYPAL_NOTIFY_URL", HP_URL."reserve.php");

$final_date = sets_get(1);
$payment = sets_get(2);

$session = "user";
$error_msg = array(
	'login' => 'The account or password is incorrect. Try again.'
);

if(!isset($_SESSION[$session]) || $_SESSION[$session] == NULL) {
	$_SESSION[$session] = array('identity' => "guest");
	$is_admin = FALSE;
}
if(isset($_SESSION[$session])) {
	if(strcmp($_SESSION[$session]['identity'], "admin") == 0)
		$is_admin = TRUE;
	else
		$is_admin = FALSE;
}

function db_get() {
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);
	$mysqli->set_charset(DB_LANG);
	if($mysqli->connect_error)
		die("Connection failed: ".$mysqli->connect_error);

	return $mysqli;
}

function admin_get($admin_account, $admin_pw) {
	$resarr = FALSE;
	$mysqli = db_get();

	$sql = "SELECT adminID, adminAccount, adminName FROM acutom_admins WHERE adminAccount=? AND adminPassword=password(?)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ss", $admin_account, $admin_pw);
	$stmt->bind_result($admin_id, $admin_account, $admin_name);
	$stmt->execute();
	if($stmt->fetch()) {
		$resarr = array(
			'adminID'	=> $admin_id,
			'adminAccount'	=> $admin_account,
			'adminName'	=> $admin_name,
			'identity'	=> "admin"
		);
	}
	$stmt->close();

	return $resarr;
}

function nowtime_get() {
	return date('Y-m-d H:i:s', time());
}

function sets_get($sets_ID = -1) {
	$res = FALSE;
	$mysqli = db_get();

	if($sets_ID == -1) {
		$sets = array();
		$sql = "SELECT setsID, setsStatus FROM acutom_sets";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_result($sets_ID, $sets_status);
		$stmt->execute();
		while($stmt->fetch()) {
			if($sets_ID == 1)
				$sets_status = (int)$sets_status;
			else
				$sets_status = round($sets_status, 2);
			$sets[$sets_ID] = $sets_status;
		}
		if(!empty($sets))
			$res = $sets;
	} else {
		$sets_status = FALSE;
		$sql = "SELECT setsStatus FROM acutom_sets WHERE setsID=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i", $sets_ID);
		$stmt->bind_result($sets_status);
		$stmt->execute();
		$stmt->fetch();

		if($sets_ID == 1)
			$sets_status = (int)$sets_status;
		else
			$sets_status = round($sets_status, 2);
		$res = $sets_status;
	}
	$stmt->close();

	return $res;
}

function reserve_all_get() {
	$resarr = array();
	$mysqli = db_get();
	$today = date('Y-m-d', time())." 00:00:00";

	$sql = "SELECT reserveID, reserveStart, reserveEnd FROM acutom_reserve WHERE reserveStart>=? AND (reserveStatus=1 OR reserveStatus=2)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $today);
	$stmt->bind_result($reserve_ID, $reserve_start, $reserve_end);
	$stmt->execute();
	$i = 0;
	while($stmt->fetch()) {
		$resarr [$i] = array(
			"id"	=> $reserve_ID,
			"title"	=> sprintf("%06d", $reserve_ID),
			"start"	=> str_replace(' ', 'T', $reserve_start),
			"end"	=> str_replace(' ', 'T', $reserve_end),
			"backgroundColor"	=> 'rgba(201, 48, 44, 0.7)',
			"borderColor"		=> '#C9302C'
		);
		$i++;
	}
	$stmt->close();

	return $resarr;
}

function opening_get() {
	$mysqli = db_get();
	$final = $GLOBALS['final_date'];

	$sql = "SELECT * FROM acutom_set_opening";
	$stmt = $mysqli->prepare($sql);
	$opening = array();
	$stmt->bind_result(
		$open_id,
		$open_day,
		$open,
		$opening [8],
		$opening [9],
		$opening [10],
		$opening [11],
		$opening [12],
		$opening [13],
		$opening [14],
		$opening [15],
		$opening [16],
		$opening [17],
		$opening [18],
		$opening [19],
		$opening [20]
	);
	$stmt->execute();
	$openweek = array();
	while($stmt->fetch()) {
		$openweek [$open_id] = array();
		$openweek [$open_id]['open'] = $open;
		foreach($opening as $key => $value)
			$openweek [$open_id][$key] = $value;
	}
	$stmt->close();

	$today = new DateTime();
	$openarr = array();
	for($i = 0; $i <= $final; $i++) {
		$today_w = $today->format('w');
		$today_ymd = $today->format('Y-m-d');
		$open = $openweek [$today_w]['open'];
		if($open) {
			$openarr [$today_ymd] = array(
				"day"	=> $today_w
			);
			foreach($openweek [$today_w] as $key => $value) {
				if(strcmp($key, 'open') && $value)
					$openarr [$today_ymd][$key] = TRUE;
			}
		}
		$today->modify('+1 day');
	}

	$sql = "SELECT * FROM acutom_set_special WHERE specialDate>=?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", date('Y-m-d', time()));
	$special = array();
	$stmt->bind_result(
		$special_date,
		$special_day,
		$special_open,
		$special [0],
		$special [1],
		$special [2],
		$special [3],
		$special [4],
		$special [5],
		$special [6],
		$special [7],
		$special [8],
		$special [9],
		$special [10],
		$special [11],
		$special [12],
		$special [13],
		$special [14],
		$special [15],
		$special [16],
		$special [17],
		$special [18],
		$special [19],
		$special [20],
		$special [21],
		$special [22],
		$special [23]
	);
	$stmt->execute();
	while($stmt->fetch()) {
		if($special_open) {
			$openarr [$special_date] = array(
				"day"	=> $special_day
			);
			foreach($special as $key => $value) {
				if($value) {
					$openarr [$special_date][$key] = TRUE;
				}
			}
		} else {
			unset($openarr [$special_date]);
		}
	}
	$stmt->close();

	$sql = "SELECT reserveStart, reserveEnd FROM acutom_reserve WHERE reserveStart>=? AND (reserveStatus=1 OR reserveStatus=2)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", date('Y-m-d H:i:s', time()));
	$stmt->bind_result($reserve_start, $reserve_end);
	$stmt->execute();
	while($stmt->fetch()) {
		$reserve_date = date('Y-m-d', strtotime($reserve_start));
		$reserve_start = (int)date('H', strtotime($reserve_start));
		$reserve_end = (int)date('H', strtotime($reserve_end));
		for($i = $reserve_start; $i <= $reserve_end; $i++) {
			unset($openarr [$reserve_date][$i]);
		}
	}
	$stmt->close();

	return $openarr;
}

function reserve_date($item_number) {
	$item_number = explode(' ', $item_number);
	return $item_number[0];
}

function reserve_hour($item_number) {
	$item_number = explode(' ', $item_number);
	$item_number = explode(':', $item_number[1]);
	return (int)$item_number[0];
}

function reserve_add($reserve_email, $reserve_name, $reserve_phone, $item_number, $reserve_service, $reserve_payment, $reserve_status, $reserve_note, $reserve_txn_id = '') {
	$res = FALSE;
	$openarr = opening_get();
	$reserve_date = reserve_date($item_number);
	$reserve_hour = reserve_hour($item_number);

	if(isset($openarr[$reserve_date][$reserve_hour])) {
		$reserve_time = sprintf("%02d", $reserve_hour);
		$reserve_start = $reserve_date." ".$reserve_time.":00:00";
		$reserve_end = $reserve_date." ".$reserve_time.":59:59";
		$reserve_created = nowtime_get();
		if($reserve_payment != 0)
			$reserve_payment = sets_get($reserve_payment);
		$reserve_token = md5($item_number.$reserve_txn_id.$reserve_created);

		$mysqli = db_get();
		$sql = "INSERT INTO acutom_reserve VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ssssssdsisss", $reserve_email, $reserve_name, $reserve_phone, $reserve_start, $reserve_end, $reserve_service, $reserve_payment, $reserve_token, $reserve_status, $reserve_note, $reserve_created, $reserve_txn_id);
		$stmt->execute();

		if($stmt->affected_rows)
			$res = TRUE;

		$stmt->close();

		$sql = "SELECT reserveID FROM acutom_reserve WHERE reserveToken=? AND reserveCreated=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ss", $reserve_token, $reserve_created);
		$stmt->bind_result($reserve_id);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();

		if($res)
			mail_send($reserve_email, $reserve_name, $reserve_phone, $item_number, $reserve_service, $reserve_token, $reserve_id, $reserve_txn_id, 1);
	}
	return $res;
}

function reserve_cancel($reserve_token) {
	$res = FALSE;
	$mysqli = db_get();

	$sql = "SELECT reserveID, reserveEmail, reserveStart, reserveService, reserveTxnID FROM acutom_reserve WHERE reserveStatus!=-1 AND reserveToken=?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $reserve_token);
	$stmt->bind_result($reserve_id, $reserve_email, $reserve_start, $reserve_service, $reserve_txn_id);
	$stmt->execute();
	if($stmt->fetch())
		$res = TRUE;
	$stmt->close();

	if($res) {
		$sql = "UPDATE acutom_reserve SET reserveStatus=-1 WHERE reserveStatus!=-1 AND reserveToken=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("s", $reserve_token);
		$stmt->execute();
		if($stmt->affected_rows)
			$res = TRUE;
		else
			$res = FALSE;
		$stmt->close();
		
		if($res)
			mail_send($reserve_email, '', '', $reserve_start, $reserve_service, $reserve_token, $reserve_id, $reserve_txn_id, 2);
	}
	return $res;
}

function mail_send($reserve_email, $reserve_name, $reserve_phone, $reserve_time, $reserve_service, $reserve_token, $reserve_id, $reserve_txn_id, $mail_type = 0) {
	if(!preg_match('/^([0-9a-z]+)(\.[0-9a-z\+\-_]+)*@([0-9a-z\-]+\.)+[a-z]{2,6}$/i', $reserve_email) || $mail_type == 0)
		return FALSE;

	if($mail_type == 1) {  // reserve msg
		$custom_subject = "You've complete a reservation.";

		$admin_subject = "You have an patient.";

		$custom_body = "Hello, ".$reserve_name.": <br />";
		$custom_body .= "<br />";
		$custom_body .= "<strong>Thank you for your reservation.</strong> <br />";
		$custom_body .= "<br />";

		$admin_body = "<strong>PayPal Transaction ID: ".$reserve_txn_id."</strong> <br />";

		$mail_body = "There is the imformation. <br />";
		$mail_body .= "<ul>";
		$mail_body .= "<li>Reservation ID: ".sprintf("%06d", $reserve_id)." </li>";
		$mail_body .= "<li>Name: ".$reserve_name." </li>";
		$mail_body .= "<li>Email: ".$reserve_email." </li>";
		$mail_body .= "<li>Phone: ".$reserve_phone." </li>";
		$mail_body .= "<li>Appointment Time: ".$reserve_time." </li>";
		$mail_body .= "<li>Service: ".$reserve_service." </li>";
		$mail_body .= "<li>Cancel Password: <strong>".$reserve_token."</strong> </li>";
		$mail_body .= "</ul>";

		$custom_body .= $mail_body;
		$admin_body .= $mail_body;

		$custom_body .= "You can cancel your reservation ";
		$custom_body .= "<a href=\"".HP_CANCEL_URL."?token=".$reserve_token."\" target=\"_blank\">HERE</a>. <br />";

	} else if($mail_type == 2) {  // cancel msg
		$custom_subject = "Your reservation has been canceled.";

		$admin_subject = "The reservation ".$reserve_name." has been canceled.";

		$mail_body = "Here's the information: <br />";
		$mail_body .= "<ul>";
		$mail_body .= "<li>Reservation ID: ".sprintf("%06d", $reserve_id)." </li>";
		$mail_body .= "<li>Appointment Time: ".$reserve_time." </li>";
		$mail_body .= "<li>Service: ".$reserve_service." </li>";
		$mail_body .= "<li>Cancel Password: <strong>".$reserve_token."</strong> </li>";
		$mail_body .= "</ul>";

		$custom_body = $mail_body;

		$admin_body = $mail_body;
		$admin_body .= "<ul>";
		$admin_body .= "<li><strong>Paypal Transaction ID: ".$reserve_txn_id."</strong></li>";
		$admin_body .= "</ul>";
	}
	require_once(PHP_MAILER);

	// custom mail
	$custom_mail = new PHPMailer();
	$custom_mail->IsSMTP();
	$custom_mail->SMTPAuth = TRUE;
        
	$custom_mail->SMTPSecure = PHP_SMTP;
	$custom_mail->Host = PHP_HOST;
	$custom_mail->Port = PHP_PORT;
	$custom_mail->CharSet = PHP_LANG;

	$custom_mail->Username = PHP_USER;
	$custom_mail->Password = PHP_PW;

	$custom_mail->From = PHP_USER;
	$custom_mail->FromName = HP_TITLE;

	$custom_mail->SMTPDebug = 1;

	$custom_mail->IsHTML(TRUE);
	$custom_mail->Subject = $custom_subject;
	$custom_mail->Body = $custom_body;
	$custom_mail->AddAddress($reserve_email, $reserve_name);

	// admin mail
	$admin_mail = new PHPMailer();
	$admin_mail->IsSMTP();
	$admin_mail->SMTPAuth = TRUE;
               
	$admin_mail->SMTPSecure = PHP_SMTP;
	$admin_mail->Host = PHP_HOST;
	$admin_mail->Port = PHP_PORT;
	$admin_mail->CharSet = PHP_LANG;

	$admin_mail->Username = PHP_USER;
	$admin_mail->Password = PHP_PW;

	$admin_mail->From = PHP_USER;
	$admin_mail->FromName = HP_TITLE;

	$admin_mail->SMTPDebug = 1;

	$admin_mail->IsHTML(TRUE);
	$admin_mail->Subject = $admin_subject;
	$admin_body->Body = $admin_body;
	$admin_mail->AddAddress(PHP_USER, HP_TITLE);

	$admin_mail->MsgHTML($admin_body);

	if($custom_mail->Send() && $admin_mail->Send())
		return TRUE;

	return FALSE;
}

function week_get() {
	$openarr = array();
	$mysqli = db_get();

	$sql = "SELECT * FROM acutom_set_opening";
	$stmt = $mysqli->prepare($sql);
	$col = 0;
	$stmt->bind_result(
		$open_id, $open_day, $open_all,
		$open[$col++],
		$open[$col++],
		$open[$col++],
		$open[$col++],
		$open[$col++],
		$open[$col++],
		$open[$col++],
		$open[$col++],
		$open[$col++],
		$open[$col++],
		$open[$col++],
		$open[$col++],
		$open[$col++]
	);
	$stmt->execute();

	$col += 1;  // add 1 column: open
	for($i = 0, $hour = 8; $i < $col; $i++) {
		if($i == 0)
			$cell = "open";
		else
			$cell = $hour++;
		$openarr[$i] = array(
			'index' => $i,
			'title' => $cell
		);
	}
	while($stmt->fetch()) {
		$j = 0;
		for($i = 0; $i < $col; $i++) {
			if($i == 0)
				$cell = $open_all;
			else
				$cell = $open[$j++];
			array_push($openarr[$i], $cell);
		}
	}
	$stmt->close();

	return $openarr;
}

function week_update($day, $hour, $value) {
	if(strcmp($hour, 'open') == 0)
		$hour = "openAll";
	else
		$hour = "open".$hour;

	$res = FALSE;
	$mysqli = db_get();

	$sql = "UPDATE acutom_set_opening SET ".$hour."=? WHERE openingID=?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ii", $value, $day);
	$stmt->execute();
	if($stmt->affected_rows)
		$res = TRUE;
	$stmt->close();

	return $res;
}

function special_get() {
	$spearr = array();
	$mysqli = db_get();
	$today = date('Y-m-d', time());

	$sql = "SELECT * FROM acutom_set_special WHERE specialDate>? ORDER BY specialDate";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $today);
	$col = 0;
	$stmt->bind_result(
		$spe_date, $spe_day, $spe_all,
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++],
		$special[$col++]
	);
	$stmt->execute();
	for($i = 0; $stmt->fetch(); $i++) {
		$spearr[$i] = array(
			'index'	=> $i,
			'date'	=> $spe_date,
			'day'	=> $spe_day,
			'open'	=> $spe_all
		);
		for($j = 0; $j < $col; $j++)
			$spearr[$i][$j] = $special[$j];
//		$spearr[$i] = array_merge($spearr[$i], $special);
//		the last data will recover old datas.
	}
	$stmt->close();

	return $spearr;
}

function special_date_get() {
	$spearr = array();
	$mysqli = db_get();
	$today = date('Y-m-d', time());

	$sql = "SELECT specialDate FROM acutom_set_special WHERE specialDate>? ORDER BY specialDate";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $today);
	$col = 0;
	$stmt->bind_result($spe_date);
	$stmt->execute();
	for($i = 0; $stmt->fetch(); $i++)
		$spearr[$i] = $spe_date;
	$stmt->close();

	return $spearr;
}

function special_update($date, $hour, $value) {
	if(strcmp($hour, 'open') == 0)
		$hour = "openAll";
	else
		$hour = "open".$hour;

	$res = FALSE;
	$mysqli = db_get();

	$sql = "UPDATE acutom_set_special SET ".$hour."=? WHERE specialDate=?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("is", $value, $date);
	$stmt->execute();
	if($stmt->affected_rows)
		$res = TRUE;
	$stmt->close();

	return $res;
}

function special_delete($date) {
	$res = FALSE;
	$mysqli = db_get();

	$sql = "DELETE FROM acutom_set_special WHERE specialDate=?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $date);
	$stmt->execute();
	if($stmt->effected_rows)
		$res = TRUE;
	$stmt->close();

	return $date;
}

function special_add($date, $add, $open) {
	$res = FALSE;
	$mysqli = db_get();

	$sql = "SELECT specialDate FROM acutom_set_special WHERE specialDate=?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $date);
	$stmt->bind_result($d);
	$stmt->execute();
	if($stmt->fetch()) {
		$stmt->close();
		return $res;
	} else {
		$day = date('w', strtotime($date));
		$hour = array();
		for($i = 0; $i < 24; $i++)
			$hour[$i] = 0;
		if($open == 1) {
			foreach($add as $value)
				$hour[$value] = 1;
		}
 
		$sql = "INSERT INTO acutom_set_special VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $mysqli->prepare($sql);
		$i = 0;
		$stmt->bind_param("siiiiiiiiiiiiiiiiiiiiiiiiii", $date, $day, $open,
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++],
			$hour[$i++]
		);
		$stmt->execute();
		if($stmt->effected_rows)
			$res = TRUE;
		$stmt->close();
	}

	return $res;
}

function reserve_admin_add($name, $date, $email, $phone, $service) {
	$res = FALSE;
	$openarr = opening_get();
	$reserve_date = reserve_date($date);
	$reserve_hour = reserve_hour($date);

	if(isset($openarr[$reserve_date][$reserve_hour])) {
		$reserve_time = sprintf("%02d", $reserve_hour);
		$reserve_start = $reserve_date." ".$reserve_time.":00:00";
		$reserve_end = $reserve_date." ".$reserve_time.":59:59";
		$reserve_payment = 0;
		$reserve_status = 2;
		$reserve_note = '';
		$reserve_created = nowtime_get();
		$reserve_token = md5($date.$reserve_created);
		$reserve_txn_id = '';

		$mysqli = db_get();
		$sql = "INSERT INTO acutom_reserve VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ssssssdsisss", $email, $name, $phone, $reserve_start, $reserve_end, $service, $reserve_payment, $reserve_token, $reserve_status, $reserve_note, $reserve_created, $reserve_txn_id);

		if($stmt->execute())
			$res = TRUE;

		$stmt->close();

		$sql = "SELECT reserveID FROM acutom_reserve WHERE reserveToken=? AND reserveCreated=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ss", $reserve_token, $reserve_created);
		$stmt->bind_result($reserve_id);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();

		if($res)
			mail_send($email, $name, $phone, $reserve_start, $service, $reserve_token, $reserve_id, '', 1);
	}

	return $res;
}

function reserve_service_get($service) {
	$resarr = array();
	$mysqli = db_get();

	$sql = "SELECT reserveID, reserveStart, reserveEnd FROM acutom_reserve WHERE reserveService=? AND (reserveStatus=1 OR reserveStatus=2)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $service);
	$stmt->bind_result($reserve_ID, $reserve_start, $reserve_end);
	$stmt->execute();
	$i = 0;
	if(strcmp($service, 'Massage') == 0) {
		$bg_color = 'rgba(100, 149, 237, 0.7)';
		$bd_color = '#6495ED';
	} else if(strcmp($service, 'Acupuncture') == 0) {
		$bg_color = 'rgba(107, 142, 35, 0.7)';
		$bd_color = '#6B8E23';
	} else {
		$bg_color = 'rgba(201, 48, 44, 0.7)';
		$bd_color = '#C9302C';
	}
	while($stmt->fetch()) {
		$resarr [$i] = array(
			"id"	=> $reserve_ID,
			"title"	=> sprintf("%06d", $reserve_ID),
			"start"	=> str_replace(' ', 'T', $reserve_start),
			"end"	=> str_replace(' ', 'T', $reserve_end),
			"backgroundColor"	=> $bg_color,
			"borderColor"		=> $bd_color
		);
		$i++;
	}
	$stmt->close();

	return $resarr;
}

function reserve_one_get($reserve_ID) {
	$resarr = array();
	$mysqli = db_get();

	$sql = "SELECT reserveID, reserveEmail, reserveName, reservePhone, reserveStart, reserveService, reservePayment, reserveToken, reserveStatus, reserveNote FROM acutom_reserve WHERE reserveID=?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $reserve_ID);
	$stmt->bind_result($resarr['id'], $resarr['email'], $resarr['name'], $resarr['phone'], $resarr['start'], $resarr['service'], $resarr['payment'], $resarr['token'], $resarr['status'], $resarr['note']);
	$stmt->execute();

	if($stmt->fetch()) ;
	else
		$resarr = FALSE;

	return $resarr;
}

function reserve_update($id, $date, $email, $phone, $service, $note) {
	$res = FALSE;
	$reserve_date = reserve_date($date);
	$reserve_hour = reserve_hour($date);
	$reserve_time = sprintf("%02d", $reserve_hour);
	$reserve_start = $reserve_date." ".$reserve_time.":00:00";
	$reserve_end = $reserve_date." ".$reserve_time.":59:59";

	$mysqli = db_get();

	$sql = "UPDATE acutom_reserve SET reserveEmail=?, reservePhone=?, reserveStart=?, reserveEnd=?, reserveService=?, reserveNote=? WHERE reserveID=?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ssssssi", $email, $phone, $reserve_start, $reserve_end, $service, $note, $id);
	$stmt->execute();

	if($stmt->effected_rows)
		$res = TRUE;
	$stmt->close();

	return $res;
}

function sets_update($id, $status) {
	$res = FALSE;

	if(is_numeric($status)) {
		if($id == 1)
			$status = (int)$status;
		else
			$status = round($status, 2);
		$mysqli = db_get();

		$sql = "UPDATE acutom_sets SET setsStatus=? WHERE setsID=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("di", $status, $id);
		$stmt->execute();
		if($stmt->affected_rows)
			$res = TRUE;
		$stmt->close();
	}

	return $res;
}

function admin_check($id, $pw) {
	$res = FALSE;
	$mysqli = db_get();

	$sql = "SELECT adminID FROM acutom_admins WHERE adminID=? AND adminPassword=password(?)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("is", $id, $pw);
	$stmt->bind_result($id);
	$stmt->execute();
	if($stmt->fetch())
		$res = TRUE;
	$stmt->close();

	return $res;
}

function admin_update($id, $old_pw, $new_pw) {
	$res = FALSE;
	$mysqli = db_get();

	$sql = "UPDATE acutom_admins SET adminPassword=password(?) WHERE adminID=? AND adminPassword=password(?)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("sis", $new_pw, $id, $old_pw);
	$stmt->execute();
	if($stmt->affected_rows)
		$res = TRUE;
	$stmt->close();

	return $res;
}



// Test Function
function print_arr($a, $m = 0) {  // Print all values of the array with format.
	for($i = 0; $i < $m; $i++)
		$line .= "&nbsp;&nbsp;&nbsp;&nbsp;";
	foreach($a as $key => $value) {
		$tmp .= $line."[".$key."] => (";
		if(is_array($value) || ($value instanceof Traversable))
			$tmp .= "<br />".print_arr($value, ($m + 1)).$line.")<br />";
		else
			$tmp .= $value.")<br />";
	}
	return $tmp;
}
