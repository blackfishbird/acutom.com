<?php
include("config.php");

$res;
if($is_admin)  $res = reserve_service_get($_POST['service']);
echo json_encode($res);
?>
