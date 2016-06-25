<?php
include("config.php");

$res;
if($is_admin)  $res = reserve_one_get($_POST['reserve_id']);
echo json_encode($res);
?>
