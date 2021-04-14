<?php
session_start();
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
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <meta name="robots" content="noindex">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Patient Dashboard - Online Appointment Portal</title>
        <link href="<?= $src ?>assets/css/style.css" rel="stylesheet">
        <link href="<?= $src ?>assets/css/date/bootstrap-datepicker.css" rel="stylesheet">
        <link rel="stylesheet" href="//formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
		
	</head>
	<body>
		
		<?php include_once dirname(dirname(__FILE__)).'/shared/navbar.php'; ?>
		<!-- 1st section start -->
		<section id="promo-1" class="content-block promo-1 min-height-600px bg-offwhite">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-8">
						
						<?php if ($userRow['patientMaritialStatus']=="") {
						// <!-- / notification start -->
						echo "<div class='row'>";
							echo "<div class='col-lg-12'>";
								echo "<div class='alert alert-danger alert-dismissable'>";
									echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
									echo " <i class='fa fa-info-circle'></i>  <strong>Please complete your profile.</strong>" ;
								echo "  </div>";
							echo "</div>";
							// <!-- notification end -->
							
							} else {
							}
							?>
							<!-- notification end -->
							<h2>Hello <?php echo $userRow['patientFirstName']; ?> <?php echo $userRow['patientLastName']; ?>. Check the available timeslot below now! </h2>
							<div class="input-group" style="margin-bottom:10px;">
								<div class="input-group-addon">
									<i class="fa fa-calendar">
									</i>
								</div>
								<input class="form-control" id="date" name="date" value="<?php echo date("Y-m-d")?>" onchange="showUser(this.value)"/>
							</div>
						</div>
						<div class="container">
							<div class="row">
								<div class="col-xs-12 col-md-8">
									<div id="txtHint"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php include_once dirname(dirname(__FILE__)).'/shared/commingsoon.php'; ?>
		
		
		<?php include_once dirname(dirname(__FILE__)).'/shared/footer.php'; ?>
		<script src="<?= $src ?>assets/js/jquery.js"></script>
		<script src="<?= $src ?>assets/js/date/bootstrap-datepicker.js"></script>
		<script src="<?= $src ?>assets/js/moment.js"></script>
		<script src="<?= $src ?>assets/js/transition.js"></script>
		<script src="<?= $src ?>assets/js/collapse.js"></script>
		<script src="<?= $src ?>assets/js/bootstrap.min.js"></script>
		
		<!-- date start -->
		<script>
						function showUser(str) {
						
							if (str == "") {
							document.getElementById("txtHint").innerHTML = "No data to be shown";
							return;
							} else {
							if (window.XMLHttpRequest) {
							// code for IE7+, Firefox, Chrome, Opera, Safari
							xmlhttp = new XMLHttpRequest();
							} else {
							// code for IE6, IE5
							xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
							}
							xmlhttp.onreadystatechange = function() {
							if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
							}
							};
							xmlhttp.open("GET","getschedule.php?q="+str,true);
							console.log(str);
							xmlhttp.send();
							}
						}
		$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
		format: 'yyyy-mm-dd',
		container: container,
		todayHighlight: true,
		autoclose: true,
		})
		})
		</script>
		<!-- date end -->
		
		
	</body>
</html>