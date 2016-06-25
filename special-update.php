<?php
include("config.php");

if($is_admin)  echo special_update($_POST['date'], $_POST['hour'], $_POST['value']);
else  echo FALSE;
?>
