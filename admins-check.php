<?php
include("config.php");

if($is_admin)  echo admin_check($_SESSION[$session]['adminID'], $_POST['old_pw']);
else  echo FALSE;
?>
