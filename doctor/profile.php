<?php
session_start();
include_once dirname(dirname(__FILE__)).'/dal/doctor.php';
if(!isset($_SESSION['doctorSession']))
{
header("Location: ../index.php");
}
$page="profile";
$src='//'.WEB_HOST.'/'.DIR.'/';
$usersession = $_SESSION['doctorSession'];
$userRow=getDoctor($usersession);
if(($userRow==NULL)){
    header("Location: ../index.php");
}

if (isset($_POST['submit'])) {
    $post_data = $_POST;
    unset($_POST);
    $result = updateDoctors($post_data);
    header( 'Location: profile.php' ) ;

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Welcome Dr <?php echo $userRow['doctorFirstName'];?> <?php echo $userRow['doctorLastName'];?></title>
        <link href="assets/css/material.css" rel="stylesheet">
        <link href="assets/css/sb-admin.css" rel="stylesheet">
        <link href="assets/css/time/bootstrap-clockpicker.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="wrapper">

            <?php include_once 'navbar.php'; ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">
                                Doctor Profile
                            </h2>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Doctor Details</h3>
                        </div>
                        <div class="panel-body">
                          <div class="container">
            <section>
                <div class="row">
                    <div class="row">
                        
                        <div class="col-md-9 col-sm-9  user-wrapper">
                            <div class="description">
                                <h3> <?php echo $userRow['doctorFirstName']; ?> <?php echo $userRow['doctorLastName']; ?> </h3>
                                <hr />
                                
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        
                                        
                                        <table class="table table-user-information" align="center">
                                            <tbody>
                                                <tr>
                                                    <td>Doctor ID</td>
                                                    <td><?php echo $userRow['doctorId']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>IC Number</td>
                                                    <td><?php echo $userRow['icDoctor']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td><?php echo $userRow['doctorAddress']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Contact Number</td>
                                                    <td><?php echo $userRow['doctorPhone']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td><?php echo $userRow['doctorEmail']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Birthdate</td>
                                                    <td><?php echo $userRow['doctorDOB']; ?>
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
                                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- form start -->
                                        <form action="<?php $_PHP_SELF ?>" method="post" >
                                            <input type="hidden" name="doctorId" value="<?= $userRow['doctorId'] ?>"/>
                                            <table class="table table-user-information">
                                                <tbody>
                                                    <tr>
                                                        <td>IC Number:</td>
                                                        <td><?php echo $userRow['icDoctor']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>First Name:</td>
                                                        <td><input type="text" class="form-control" name="doctorFirstName" value="<?php echo $userRow['doctorFirstName']; ?>"  /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last Name</td>
                                                        <td><input type="text" class="form-control" name="doctorLastName" value="<?php echo $userRow['doctorLastName']; ?>"  /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phone number</td>
                                                        <td><input type="text" class="form-control" name="doctorPhone" value="<?php echo $userRow['doctorPhone']; ?>"  /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td><input type="text" class="form-control" name="doctorEmail" value="<?php echo $userRow['doctorEmail']; ?>"  /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td>
                                                        <td><textarea class="form-control" name="doctorAddress"  ><?php echo $userRow['doctorAddress']; ?></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td>isAdmin</td>
                                                        <td><input class="form-control" name="doctorDOB" type="text" value="<?= $userRow['doctorDOB'] ?>" required /></td>
                                                    </tr>
                                                    <?php if($userRow['isAdmin'] ) { ?>
                                                    <tr>
                                                        <td>isAdmin</td>
                                                        <td><input type="checkbox" class="form-control" name="isAdmin" <?= ($userRow['isAdmin'] ? "checked=checked" : "") ?> /></td>
                                                    </tr>
                                                    <?php } else { ?>
                                                        <input type="checkbox" class="form-control" name="isAdmin" <?= ($userRow['isAdmin'] ? "checked=checked" : "") ?> style="display:none"/>
                                                    <?php }  ?>

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
                    </div>
                </div>
            </div>
        <script src="<?= $src ?>assets/js/jquery.js"></script>
        <script src="<?= $src ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= $src ?>assets/js/bootstrap-clockpicker.js"></script>
        <link href="<?= $src ?>assets/css/date/bootstrap-datepicker.css" rel="stylesheet">
        <script src="<?= $src ?>assets/js/date/bootstrap-datepicker.js"></script>

        <script>
            $(document).ready(function(){
                var date_input=$('input[name="doctorDOB"]'); //our date input has the name "date"
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