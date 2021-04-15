<?php
include_once 'dal/doctor.php';

session_start();
if (isset($_SESSION['doctorSession']) != "") {
    header("Location: doctor/dashboard.php");
}

if (isset($_POST['login']))
{
    $post_data = $_POST;
    unset($_POST);
    $result=doctorLogin($post_data);
    if ($result["success"])
    {
        $_SESSION['doctorSession'] = $result['doctorId'];
?>
        <script type="text/javascript">
            alert('Login Success');
        </script>
<?php
        header("Location: doctor/dashboard.php");
    } else {
?>
        <script type="text/javascript">
            alert("Wrong input");
        </script>
<?php
    }
}
$src='//'.WEB_HOST.'/'.DIR.'/';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Clinic Appointment Application</title>
        <!-- Bootstrap -->
        <link href="<?= $src ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= $src ?>assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <!-- start -->
            <div class="login-container">
                    <div id="output"></div>
                    <div class=""><img alt="Brand" src="<?= $src ?>assets/img/logo.png"></div>
                    <div class="form-box">
                        <form class="form" role="form" method="POST" accept-charset="UTF-8">
                            <input name="doctorId" type="text" placeholder="Doctor ID" required>
                            <input name="password" type="password" placeholder="Password" required>
                            <button class="btn btn-info btn-block login" type="submit" name="login">Login</button>
                        </form>
                    </div>
                </div>
            <!-- end -->
        </div>

        <script src="<?= $src ?>assets/js/jquery.js"></script>

        <!-- js start -->
        
        <!-- js end -->
    </body>
</html>