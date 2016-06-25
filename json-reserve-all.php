<?php
include("config.php");

$res = reserve_all_get();
echo json_encode($res);
?>
