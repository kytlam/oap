<!-- login -->
<!-- check session -->
<?php
include_once 'dal/patient.php';
session_start();
// session_destroy();
if (isset($_SESSION['patientSession']) != "") {
    header("Location: patient/patient.php");
}
$src='//'.WEB_HOST.'/'.DIR.'/';
$oldData=NULL;
if (isset($_POST['login']))
{
    $post_data = $_POST;
    unset($_POST);
    $result=patientLogin($post_data);

    if ($result["success"])
    {
        $_SESSION['patientSession'] = $result['username'];
?>
    <script type="text/javascript">
        alert('Login Success');
        location.href = "patient/patient.php"
    </script>
    <?php
    } else {
    ?>
    <script>
        alert('wrong input / membership not found ');
    </script>
<?php
    }
}
?>
<!-- register -->
<?php
if (isset($_POST['signup'])) {
    $post_data = $_POST;
    unset($_POST);

    $result = register($post_data) ;
    if( $result['success'] )
    {
        $_SESSION['patientSession'] = $result['post_back_data'];
?>
    <script type="text/javascript">
        alert('<?= $result['message'] ?>');
        location.href = "patient/patient.php"
    </script>
<?php
    } else {
        $oldData= $result['post_back_data'];
?>
    <script type="text/javascript">
        alert('<?= $result['message'] ?>');
    </script>
<?php
    }

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Online Appointment Portal</title>
        <link href="<?= $src ?>assets/css/style.css" rel="stylesheet">
        <link href="<?= $src ?>assets/css/date/bootstrap-datepicker.css" rel="stylesheet">

        <!--Font Awesome (added because you use icons in your prepend/append)-->
        <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
    </head>
    <body>
        <?php include_once 'shared/navbar.php'; ?>
        <div style="margin-top:64px;    min-height: 1200px;">
        <div id="loginForm">
            <h3>Sign In</h3>
            <form class="form" role="form" method="POST" accept-charset="UTF-8" >
                <div class="form-group">
                    <label class="sr-only" for="username">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="User Name" required>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="login" id="login" class="btn btn-primary btn-block">Sign in</button>
                </div>
            </form>
        </div><div style="float:left;margin-top: 5em;background-color: #1abc9c;color: #eee;font-size: 2em;border-radius: 50%;padding: 6px 10px;">OR</div>
        <div id="regForm">
            <h3>Sign Up</h3>
            <form action="<?php $_PHP_SELF ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                <input type="text" name="username" maxlength="50" value="<?= GetOldData($oldData, 'username') ?>" class="form-control input-lg" placeholder="Login Username"  required/>
                <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" value="" maxlength="50" class="form-control input-lg" placeholder="Password"  required/>
                <span class="help-block">Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters</span>
                <input type="password" name="confirm_password" maxlength="50" value="" class="form-control input-lg" placeholder="Confirm Password"  required/>
                <input type="text" name="patientMediRecordNo" maxlength=50 value="<?= GetOldData($oldData, 'patientMediRecordNo') ?>" class="form-control input-lg" placeholder="[If any] Number in your medical record or card" /> 
                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <input type="text" id="fname" name="patientFirstName" maxlength="50" value="<?= GetOldData($oldData, 'patientFirstName') ?>" class="form-control input-lg" placeholder="First Name" required />
                    </div>
                    <div class="col-xs-6 col-md-6">
                        <input type="text" name="patientLastName" maxlength="50" value="<?= GetOldData($oldData, 'patientLastName') ?>" class="form-control input-lg" placeholder="Last Name" required />
                    </div>
                </div>                                        
                <input type="email" name="patientEmail" maxlength="255" 
                        pattent="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}"
                        value="<?= GetOldData($oldData, 'patientEmail') ?>" class="form-control input-lg" placeholder="Your Email"  required/>
                
                <label>Birth Date</label>
                <input type="text" name="regDOB" value="<?= GetOldData($oldData, 'regDOB') ?>" class="form-control input-lg" placeholder="yyyy-mm-dd"  required/>
                <label>Gender : </label>
                <div class="radio-group">
                    <label class="radio-inline">
                        <input type="radio" name="patientGender" value="na" required <?= GetOldData($oldData, 'patientGender')=="na" ? "checked" : "" ?> />N/A
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="patientGender" value="m" required <?= GetOldData($oldData, 'patientGender')=="m" ? "checked" : "" ?>/>Male
                    </label>
                    <label class="radio-inline" >
                        <input type="radio" name="patientGender" value="f" required <?= GetOldData($oldData, 'patientGender')=="f" ? "checked" : "" ?>/>Female
                    </label>
                </div>
                <label>Address : </label>
                <div> <textarea name="patientAddress" rows="4" cols="50" style="border: 1px solid #eee;"><?= GetOldData($oldData, 'patientAddress') ?></textarea></div>
                <input type="tel" name="patientPhone" minlength="8" maxlength="8" value="<?= GetOldData($oldData, 'patientPhone') ?>" class="form-control input-lg" placeholder="Phone Number"  required/>
                <br />
                <span class="help-block">After Created my account, you agree to our T&C as well as our Data Use Policy, including Cookie Use.</span>
                
                <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit" name="signup" id="signup">Create my account</button>
                <span class="help-block">Must 8 number</span>
            </form>
        </div></div>
        <?php include_once 'shared/footer.php'; ?>
    </div>
    <script src="<?= $src ?>assets/js/jquery.js"></script>
    <script src="<?= $src ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= $src ?>assets/js/date/bootstrap-datepicker.js"></script>
    <script src="<?= $src ?>assets/js/moment.js"></script>
    <script src="<?= $src ?>assets/js/transition.js"></script>
    <script src="<?= $src ?>assets/js/collapse.js"></script>
    <script>
        $(document).ready(function(){
            var date_input=$('input[name="date"]'); //our date input has the name "date"
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            date_input.datepicker({
                format: 'yyyy-mm-dd',
                container: container,
                todayHighlight: true,
                autoclose: true,
            });
            $('input[name="regDOB"]').datepicker({
                format: 'yyyy-mm-dd',
                container: container,
                todayHighlight: true,
                autoclose: true,
            });
        })
    </script>
    </body>
</html>