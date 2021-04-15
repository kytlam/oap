<?php
include_once dirname(dirname(__FILE__)).'/dal/appointment.php';
// Get the variables.
$appid = $_POST['appid'];
$ischecked = $_POST['ischecked'];
$status = ($ischecked ? "done" : "process");
$update = updateAppointmentStatus($appid,$status);
echo($update ? "1" : "0");
?>