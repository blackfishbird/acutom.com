<?php
include("config.php");

if(strcmp($_SESSION[$session] ['identity'], "guest") != 0) {
	unset($_SESSION[$session]);
}
?>
