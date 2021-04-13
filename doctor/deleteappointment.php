<?php
include_once dirname(dirname(__FILE__)).'/dal/appointment.php';
// Get the variables.
$appid = $_POST['id'];
// echo $appid;

echo deleteAppointment($_POST['id']);

?>

