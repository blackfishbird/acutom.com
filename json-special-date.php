<?php
include("config.php");

if($is_admin)  echo json_encode(special_date_get());
else  echo FALSE;
?>
