<?php
include("config.php");

if($is_admin)  echo reserve_update($_POST['id'], $_POST['date'], $_POST['email'], $_POST['phone'], $_POST['service'], $_POST['note']);
else  echo FALSE;
?>
