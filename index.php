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
    </script>
    <?php
        header("Location: patient/patient.php");
    } else {
    ?>
    <script>
        alert('wrong input ');
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
    if( $result == "done" )
    {
?>
    <script type="text/javascript">
        alert('Register success. Please Login to make an appointment.');
    </script>
<?php
    } else {
?>
    <script type="text/javascript">
        alert('<?= $result ?>');
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
        <link rel="stylesheet" href="https:://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
    </head>
    <body>
        <?php include_once 'shared/navbar.php'; ?>
        <section id="promo-1" class="content-block promo-1 min-height-600px bg-offwhite">
            <div class="container">
                <div class="row">
					<div class="col-xs-12 col-md-8">
                        <h2>Make appointment today!</h2>
                        <p>This is Doctor's Schedule. Please <span class="label label-danger">login</span> to make an appointment. </p>                       
                        <div class="input-group" style="margin-bottom:10px;">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar">
                                </i>
                            </div>
                            <input class="form-control" id="date" name="date" value="<?php echo date("Y-m-d")?>" onchange="showUser(this.value)"/>
                        </div>
                        <div id="txtHint"><b> </b></div>
                    </div>
                </div>
            </div>
        </section>
        
		<?php include_once 'shared/commingsoon.php'; ?>
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
            $('#regModal').on('shown.bs.modal', function () {
                $('#fname').focus()
            })
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
        function showUser(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else { 
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET","getuser.php?q="+str,true);
                console.log(str);
                xmlhttp.send();
            }
        }
    </script>
    </body>
</html>