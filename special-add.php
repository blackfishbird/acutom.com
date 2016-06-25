<?php
include("config.php");

if($is_admin)  echo special_add($_POST['date'], $_POST['add'], $_POST['open']);
else  echo FALSE;
?>
