<?php
include("config.php");

$res = FALSE;
if(!$is_admin) {
	$res = admin_get($_POST['account'], $_POST['pw']);
	if($res) {
		$_SESSION[$session] = $res;
		$res = TRUE;
	}
}
echo $res;
