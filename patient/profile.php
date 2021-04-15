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

?>

<!-- update -->
<?php
if (isset($_POST['submit'])) {
    $post_data = $_POST;
    unset($_POST);
    $result = updatePatients($post_data);
    header( 'Location: profile.php' ) ;
}
$src='//'.WEB_HOST.'/'.DIR.'/';
?>
<?php
	$male="";
	$female="";
	$na_g="";
	if ($userRow['patientGender']=='m') {
		$male = "checked";
	}elseif ($userRow['patientGender']=='f') {
		$female = "checked";
	} else {
		$na_g="checked";
	}
	$single="";
	$married="";
	$separated="";
	$divorced="";
	$widowed="";
	$na_ms="";
	if ($userRow['patientMaritialStatus']=='single') {
		$single = "checked";
	}elseif ($userRow['patientMaritialStatus']=='married') {
		$married = "checked";
	}elseif ($userRow['patientMaritialStatus']=='separated') {
		$separated = "checked";
	}elseif ($userRow['patientMaritialStatus']=='divorced') {
		$divorced = "checked";
	}elseif ($userRow['patientMaritialStatus']=='widowed') {
		$widowed = "checked";
	}else{
		$na_ms= "checked";
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <meta name="robots" content="noindex">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Patient Detail - Online Appointment Portal</title>
		<!-- Bootstrap -->
		<link href="<?= $src ?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= $src ?>assets/css/style.css" rel="stylesheet">
		<link href="<?= $src ?>assets/css/date/bootstrap-datepicker.css" rel="stylesheet">
		<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
		<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
	</head>
	<body>
		<?php include_once dirname(dirname(__FILE__)).'/shared/navbar.php'; ?>
		
		<div class="container">
			<section style="padding-bottom: 50px; padding-top: 50px;">
				<div class="row">
					<div class="row">
						
						<div class="col-md-9 col-sm-9  user-wrapper">
							<div class="description">
								<h3> Profile: 
									<?php echo $userRow['patientFirstName']; ?> <?php echo $userRow['patientLastName']; ?> </h3>
								<hr />
								
								<div class="panel panel-default">
									<div class="panel-body">
										<table class="table table-user-information" align="center">
											<tbody>
												
												<tr>
													<td>Medical Record No</td>
													<td><?php echo$userRow['patientMediRecordNo']; ?></td>
												</tr>
												
												<tr>
													<td>Maritial Status</td>
													<td><?php echo strtoupper($userRow['patientMaritialStatus']); ?></td>
												</tr>
												<tr>
													<td>DOB</td>
													<td><?php echo $userRow['patientDOB']; ?></td>
												</tr>
												<tr>
													<td>Gender</td>
													<td><?php echo strtoupper($userRow['patientGender']); ?></td>
												</tr>
												<tr>
													<td>Address</td>
													<td><?php echo $userRow['patientAddress']; ?>
													</td>
												</tr>
												<tr>
													<td>Phone</td>
													<td><?php echo $userRow['patientPhone']; ?>
													</td>
												</tr>
												<tr>
													<td>Email</td>
													<td><?php echo $userRow['patientEmail']; ?>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Update Profile</button>
							</div>
							
						</div>
					</div>
					<div class="col-md-4">
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Update Profile</h4>
									</div>
									<div class="modal-body">
										<form action="<?php $_PHP_SELF ?>" method="post" >
                                            <input type="hidden" name="username" value="<?= $userRow['username'] ?>"/>
											<table class="table table-user-information">
												<tbody>
													<tr>
														<td>IC Number:</td>
														<td><?php echo $userRow['icPatient']; ?></td>
													</tr>
													<tr>
														<td>Medical Record No:</td>
														<td><input type="text" class="form-control" name="patientMediRecordNo" value="<?php echo $userRow['patientMediRecordNo']; ?>"  /></td>
													</tr>
													<tr>
														<td>First Name:</td>
														<td><input type="text" class="form-control" name="patientFirstName" value="<?php echo $userRow['patientFirstName']; ?>"  /></td>
													</tr>
													<tr>
														<td>Last Name</td>
														<td><input type="text" class="form-control" name="patientLastName" value="<?php echo $userRow['patientLastName']; ?>"  /></td>
													</tr>
													<tr>
														<td>Maritial Status:</td>
														<td>
															<div class="radio">
																<label><input type="radio" name="patientMaritialStatus" value="na" <?php echo $na_ms; ?>>N/A</label>
															</div>
															<div class="radio">
																<label><input type="radio" name="patientMaritialStatus" value="single" <?php echo $single; ?>>Single</label>
															</div>
															<div class="radio">
																<label><input type="radio" name="patientMaritialStatus" value="married" <?php echo $married; ?>>Married</label>
															</div>
															<div class="radio">
																<label><input type="radio" name="patientMaritialStatus" value="separated" <?php echo $separated; ?>>Separated</label>
															</div>
															<div class="radio">
																<label><input type="radio" name="patientMaritialStatus" value="divorced" <?php echo $divorced; ?>>Divorced</label>
															</div>
															<div class="radio">
																<label><input type="radio" name="patientMaritialStatus" value="widowed" <?php echo $widowed; ?>>Widowed</label>
															</div>
														</td>
													</tr>
													<tr>
														<td>DOB</td>
														<td>
															<div class="form-group ">
																<div class="input-group">
																	<div class="input-group-addon">
																		<i class="fa fa-calendar">
																		</i>
																	</div>
																	<input class="form-control" id="patientDOB" name="patientDOB" placeholder="YYYY-MM-DD" type="text" value="<?php echo $userRow['patientDOB']; ?>"/>
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<td>Gender</td>
														<td>
															<div class="radio">
																<label><input type="radio" name="patientGender" value="na" <?php echo $na_g; ?>>N/A</label>
															</div>
															<div class="radio">
																<label><input type="radio" name="patientGender" value="m" <?php echo $male; ?>>Male</label>
															</div>
															<div class="radio">
																<label><input type="radio" name="patientGender" value="f" <?php echo $female; ?>>Female</label>
															</div>
														</td>
													</tr>
													
													<tr>
														<td>Phone number</td>
														<td><input type="text" class="form-control" name="patientPhone" value="<?php echo $userRow['patientPhone']; ?>"  /></td>
													</tr>
													<tr>
														<td>Email</td>
														<td><input type="text" class="form-control" name="patientEmail" value="<?php echo $userRow['patientEmail']; ?>"  /></td>
													</tr>
													<tr>
														<td>Address</td>
														<td><textarea class="form-control" name="patientAddress"  ><?php echo $userRow['patientAddress']; ?></textarea></td>
													</tr>
													<tr>
														<td>
															<input type="submit" name="submit" class="btn btn-info" value="Update Info"></td>
														</tr>
													</tbody>
													
												</table>
												
										</form>
									</div>
										
									</div>
								</div>
							</div>
							<br /><br/>
						</div>
						
					</div>
				</div>
			</section>
		</div>
			<?php include_once dirname(dirname(__FILE__)).'/shared/navbar.php'; ?>
			<script src="<?= $src ?>assets/js/jquery.js"></script>
			<script src="<?= $src ?>assets/js/bootstrap.min.js"></script>
			
			<script src="<?= $src ?>assets/js/date/bootstrap-datepicker.js"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					var date_input=$('input[name="patientDOB"]'); //our date input has the name "date"
					var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
					date_input.datepicker({
						format: 'yyyy-mm-dd',
						container: container,
						todayHighlight: true,
						autoclose: true,
					})

				})
			</script>
		</body>
	</html>