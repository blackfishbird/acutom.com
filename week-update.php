<?php
include("config.php");

if($is_admin)  echo week_update($_POST['day'], $_POST['hour'], $_POST['value']);
else  echo FALSE;
?>
