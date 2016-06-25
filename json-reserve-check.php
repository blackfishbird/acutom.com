<?php
include("config.php");

$res = opening_get();
echo json_encode($res);
?>
