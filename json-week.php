<?php
include("config.php");

if($is_admin)  echo json_encode(week_get());
?>
