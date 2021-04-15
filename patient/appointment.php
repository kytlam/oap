<?php
session_start();
include_once dirname(dirname(__FILE__)).'/dal/patient.php';
include_once dirname(dirname(__FILE__)).'/dal/schedule.php';
include_once dirname(dirname(__FILE__)).'/dal/appointment.php';

$usersession = $_SESSION['patientSession'];
$userRow=getPatient($usersession);
if(($userRow==NULL)){
    header("Location: ../index.php");
}
$src='//'.WEB_HOST.'/'.DIR.'/';
$schedule =null;
if (isset($_GET['scheduleDate']) && isset($_GET['schId'])) {
	$scheduleDate =$_GET['scheduleDate'];
	$schId = $_GET['schId'];
	$schedule =getSchedule($schId,$scheduleDate,  true );
}

//INSERT
if (isset($_POST['appointment'])) {
	$post_data=$_POST;
	unset($_POST);
	$result = makeAppointment($post_data);
	if( $result )
	{
		$ressult = markAsNotAvailable($post_data['scheduleid'], 0);
		if( $result )
		{
?>
			<script type="text/javascript">
			alert('Appointment made successfully.');
			</script>
<?php
			header("Location: appointmentlist.php");
		} else {
			?>
				<script type="text/javascript">
				alert('Appointment booking fail. Please try again.');
				</script>
			<?php
		}
	}
	else
	{
?>
	<script type="text/javascript">
	alert('Appointment booking fail. Please try again.');
	</script>
<?php
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="robots" content="noindex">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Make Appoinment - Online Appointment Portal</title>
		<link href="<?= $src ?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= $src ?>assets/css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

	</head>
	<body>
	
		<?php include_once dirname(dirname(__FILE__)).'/shared/navbar.php'; ?>
		<div class="container">
			<section style="padding-bottom: 50px; padding-top: 50px;margin-top:64px">
				<div class="row">
					<div class="row">
						<div class="col-md-12 col-sm-12  user-wrapper" s>
							<div class="description">
								<div class="panel panel-default">
									<div class="panel-body">
										<form class="form" role="form" method="POST" accept-charset="UTF-8">
											<input type="hidden" name="icPatient" value="<?= $userRow['icPatient'] ?>" />
											<input type="hidden" name="scheduleid" value="<?= $schedule['scheduleId'] ?>" />
											<input type="hidden" name="status" value="scheduled" />
											<div class="panel panel-default">
												<div class="panel-heading">Patient Information</div>
												<div class="panel-body">
													<?php 
													?>
													Patient Name: <?php echo $userRow['patientFirstName'] ?> <?php echo $userRow['patientLastName'] ?><br>
													Patient IC: <?php echo $userRow['icPatient'] ?><br>
													Contact Number: <?php echo $userRow['patientPhone'] ?><br>
													Address: <?php echo $userRow['patientAddress'] ?>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">Appointment Information</div>
												<div class="panel-body">
													Date: <?php echo $schedule['scheduleDate'] ?><br>
													Day: <?php echo getScheduleDay($schedule['scheduleDate'])  ?><br>
													Time: <?php echo $schedule['startTime'] ?> - <?php echo $schedule['endTime'] ?><br>
													
												</div>
											</div>
											
											<div class="form-group">
												<label for="recipient-name" class="control-label">Symptom:</label>
												<input type="text" class="form-control" name="symptom" required>
											</div>
											<div class="form-group">
												<label for="message-text" class="control-label">Comment:</label>
												<textarea class="form-control" name="comment" required></textarea>
											</div>
											<div class="form-group">
												<input type="submit" name="appointment" id="submit" class="btn btn-primary" value="Make Appointment">
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				</section>
				</div>
					<script src="<?= $src ?>assets/js/jquery.js"></script>
			<script src="<?= $src ?>assets/js/bootstrap.min.js"></script>
		<?php include_once dirname(dirname(__FILE__)).'/shared/footer.php'; ?>
				</body>
			</html>