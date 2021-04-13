<?php
include_once dirname(dirname(__FILE__)).'/dal/appointment.php';
// Get the variables.
$appid = $_GET['appid'];
$ischecked = $_GET['ischecked'];
$status = ($ischecked ? "done" : "process");
$update = updateAppointmentStatus($appid,$status);

?>