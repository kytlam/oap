<?php
session_start();
include_once dirname(dirname(__FILE__)).'/dal/schedule.php';
include_once dirname(dirname(__FILE__)).'/dal/appointment.php';
include_once dirname(dirname(__FILE__)).'/dal/patient.php';
if(!isset($_SESSION['patientSession']))
{
header("Location: ../index.php");
}

$usersession = $_SESSION['patientSession'];
$userRow=getPatient($usersession);
if(($userRow==NULL)){
    header("Location: ../index.php");
}
$src='//'.WEB_HOST.'/'.DIR.'/';

$session=$_SESSION[ 'patientSession'];
$appsch = getappointmentScheduleList('p', $usersession);

// var_dump($userRow);die();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="robots" content="noindex">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Appoinment List - Online Appointment Portal</title>
		<link href="<?= $src ?>assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="//formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

	</head>
	<body>
		<?php include_once dirname(dirname(__FILE__)).'/shared/navbar.php'; ?>
		<div class='container pal'>
			<div class='row'>
				<div class='page-header'>
					<h1>Your appointment list. </h1>
				</div>
				<div class='panel panel-primary'>
					<div class='panel-heading'>List of Appointment</div>
					<div class='panel-body'>
						<table class='table table-hover'>
							<thead>
								<tr>
								<th>App Id</th>
								<th>icPatient </th>
								<th>patientLastName </th>
								<th>scheduleDay </th>
								<th>scheduleDate </th>
								<th>startTime </th>
								<th>endTime </th>
								<th>Print </th>
								</tr>
							</thead>
							<tbody>
								<?php
							if($appsch!=null && count($appsch)>0) {
								foreach ($appsch as $value) {
									echo "<tr>";
									echo "<td>" . $value['appId'] . "</td>";
									echo "<td>" . $value['icPatient'] . "</td>";
									echo "<td>" . $value['patientLastName'] . "</td>";
									echo "<td>" . getScheduleDay($value['scheduleDate']) . "</td>";
									echo "<td>" . $value['scheduleDate'] . "</td>";
									echo "<td>" . $value['startTime'] . "</td>";
									echo "<td>" . $value['endTime'] . "</td>";
									echo "<td><a href='invoice.php?appid=".$value['appId']."' target='_blank'><span class='glyphicon glyphicon-print' aria-hidden='true'></span></a> </td>";
									echo "</tr>";
								} 
							}else {
								echo "<tr><td>No Appoinment Yet</td></tr>";
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php include_once dirname(dirname(__FILE__)).'/shared/footer.php'; ?>
	<!-- display appoinment end -->
	<script src="<?= $src ?>assets/js/jquery.js"></script>
	<script src="<?= $src ?>assets/js/bootstrap.min.js"></script>
	</body>
</html>