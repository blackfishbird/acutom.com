<?php
include("config.php");

if($is_admin)  echo admin_update($_SESSION[$session]['adminID'], $_POST['old_pw'], $_POST['new_pw']);
else  echo FALSE;
?>
