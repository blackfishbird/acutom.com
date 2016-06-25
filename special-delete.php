<?php
include("config.php");

if($is_admin)  echo special_delete($_POST['date']);
else  echo FALSE;
?>
