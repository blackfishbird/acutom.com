<?php
include("config.php");

if($is_admin)  echo reserve_admin_add($_POST['name'], $_POST['date'], $_POST['email'], $_POST['phone'], $_POST['service']);
else  echo FALSE;
?>
