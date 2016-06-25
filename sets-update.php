<?php
include("config.php");

if($is_admin)  echo sets_update($_POST['sets_item'], $_POST['sets_status']);
else  echo FALSE;
?>
