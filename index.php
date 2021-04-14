<!-- login -->
<!-- check session -->
<?php
include_once 'dal/patient.php';
session_start();
// session_destroy();
if (isset($_SESSION['patientSession']) != "") {
    header("Location: patient/patient.php");
}
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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Clinic Appointment Application</title>
        <!-- Bootstrap -->
        <!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
        <link href="<?= ROOT ?>/assets/css/style.css" rel="stylesheet">
        <link href="<?= ROOT ?>/assets/css/style1.css" rel="stylesheet">
        <link href="<?= ROOT ?>/assets/css/blocks.css" rel="stylesheet">
        <link href="<?= ROOT ?>/assets/css/date/bootstrap-datepicker.css" rel="stylesheet">
        <link href="<?= ROOT ?>/assets/css/date/bootstrap-datepicker3.css" rel="stylesheet">
        <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
        <!-- <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />  -->

        <!--Font Awesome (added because you use icons in your prepend/append)-->
        <link rel="stylesheet" href="//formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
        <link href="<?= ROOT ?>/assets/css/material.css" rel="stylesheet">
    </head>
    <body>
        
        <?php include_once 'shared/navbar.php'; ?>
        <!-- modal container start -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- modal content -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Sign Up</h3>
                    </div>
                    <!-- modal body start -->
                    <div class="modal-body">
                        
                        <!-- form start -->
                        <div class="container" id="wrap">
                            <div class="row">
                                <div class="col-md-6">
                                    
                                    <form action="<?php $_PHP_SELF ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                                        <h4>It's free and always will be.</h4>
                                        <div class="row">
                                            <div class="col-xs-6 col-md-6">
                                                <input type="text" name="patientFirstName" maxlength="50" value="" class="form-control input-lg" placeholder="First Name" required />
                                            </div>
                                            <div class="col-xs-6 col-md-6">
                                                <input type="text" name="patientLastName" maxlength="50" value="" class="form-control input-lg" placeholder="Last Name" required />
                                            </div>
                                        </div>
                                        
                                        
                                        <input type="email" name="patientEmail" maxlength="255" 
                                        pattent="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}"
                                        value="" class="form-control input-lg" placeholder="Your Email"  required/>
                                        <input type="text" name="username" maxlength="50" value="" class="form-control input-lg" placeholder="Your username"  required/>
                                        
                                        
                                        <input type="password" name="password" value="" maxlength="50" class="form-control input-lg" placeholder="Password"  required/>
                                        
                                        <input type="password" name="confirm_password" maxlength="50" value="" class="form-control input-lg" placeholder="Confirm Password"  required/>
                                        <label>Birth Date</label>
                                        <input type="text" name="regDOB" value="" class="form-control input-lg" placeholder="yyyy-mm-dd"  required/>
                                        <label>Gender : </label>
                                        <div class="radio-group">
                                            <label class="radio-inline">
                                                <input type="radio" name="patientGender" value="na" required checked />N/A
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="patientGender" value="male" required/>Male
                                            </label>
                                            <label class="radio-inline" >
                                                <input type="radio" name="patientGender" value="female" required/>Female
                                            </label>
                                        </div><label>Address : </label>
                                        <textarea name="patientAddress" rows="4" cols="50"></textarea>
                                        <input type="tel" name="patientPhone" maxlength="50" value="" class="form-control input-lg" placeholder="Phone Number"  required/>
                                        <br />
                                        <span class="help-block">By clicking Create my account, you agree to our Terms and that you have read our Data Use Policy, including our Cookie Use.</span>
                                        
                                        <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit" name="signup" id="signup">Create my account</button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->
        <!-- modal container end -->

        <!-- 1st section start -->
        <section id="promo-1" class="content-block promo-1 min-height-600px bg-offwhite">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <h2>Make appointment today!</h2>
                        <p>This is Doctor's Schedule. Please <span class="label label-danger">login</span> to make an appointment. </p>
                            
                        <!-- date textbox -->
                       
                        <div class="input-group" style="margin-bottom:10px;">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar">
                                </i>
                            </div>
                            <input class="form-control" id="date" name="date" value="<?php echo date("Y-m-d")?>" onchange="showUser(this.value)"/>
                        </div>
                       
                        <!-- date textbox end -->

                        <!-- script start -->
                        <script>

                            function showUser(str) {
                                
                                if (str == "") {
                                    document.getElementById("txtHint").innerHTML = "";
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
                                    xmlhttp.open("GET","getuser.php?q="+str,true);
                                    console.log(str);
                                    xmlhttp.send();
                                }
                            }
                        </script>
                        
                        <!-- script start end -->
                     
                        <!-- table appointment start -->
                        <div id="txtHint"><b> </b></div>
                        
                        <!-- table appointment end -->
                    </div>
                    <!-- /.col -->
                   <!--  <div class="col-md-6 col-md-offset-1">
                        <div class="video-wrapper">
                            <iframe width="560" height="315" src="http://www.youtube.com/embed/FEoQFbzLYhc?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div> -->
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </section>
        <!-- first section end -->

        
        <!-- second section start -->
        
        <!-- second section end -->
        <!-- third section start -->
        
        <!-- third section end -->
        <!-- forth sections start -->
        <section id="content-1-9" class="content-1-9 content-block">
            <div class="container">
                <div class="underlined-title">
                    <h1>Get in Touch</h1>
                    <hr>
                    <h2>Feel free to drop us a line to contact us</h2>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                        <div class="col-xs-2">
                            <span class="fa fa-pencil"></span>
                        </div>
                        <div class="col-xs-10">
                            <h4>Branding</h4>
                            <p>Retro chillwave YOLO four loko photo booth. Brooklyn kale chips, seitan hella 3 wolf moon slow-carb paleo.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                        <div class="col-xs-2">
                            <span class="fa fa-code"></span>
                        </div>
                        <div class="col-xs-10">
                            <h4>Web Design</h4>
                            <p>Retro chillwave YOLO four loko photo booth. Brooklyn kale chips, seitan hella 3 wolf moon slow-carb paleo.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                        <div class="col-xs-2">
                            <span class="fa fa-comments-o"></span>
                        </div>
                        <div class="col-xs-10">
                            <h4>Social Marketing</h4>
                            <p>Retro chillwave YOLO four loko photo booth. Brooklyn kale chips, seitan hella 3 wolf moon slow-carb paleo.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                        <div class="col-xs-2">
                            <span class="fa fa-search"></span>
                        </div>
                        <div class="col-xs-10">
                            <h4>SEO</h4>
                            <p>Retro chillwave YOLO four loko photo booth. Brooklyn kale chips, seitan hella 3 wolf moon slow-carb paleo.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                        <div class="col-xs-2">
                            <span class="fa fa-mobile"></span>
                        </div>
                        <div class="col-xs-10">
                            <h4>Mobile Apps</h4>
                            <p>Retro chillwave YOLO four loko photo booth. Brooklyn kale chips, seitan hella 3 wolf moon slow-carb paleo.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                        <div class="col-xs-2">
                            <span class="fa fa-bookmark"></span>
                        </div>
                        <div class="col-xs-10">
                            <h4>Corporate Literture</h4>
                            <p>Retro chillwave YOLO four loko photo booth. Brooklyn kale chips, seitan hella 3 wolf moon slow-carb paleo.</p>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>
        <!-- forth section end -->
        <!-- footer start -->
        <div class="copyright-bar bg-black">
            <div class="container">
                <p class="pull-left small">© Projectworlds <a href ="https://projectworlds.in/">Get More Projects </a></p>
                <p class="pull-right small"><a href="adminlogin.php">admin</a></p>
            </div>
        </div>
        <!-- footer end -->
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/date/bootstrap-datepicker.js"></script>
    <script src="assets/js/moment.js"></script>
    <script src="assets/js/transition.js"></script>
    <script src="assets/js/collapse.js"></script>
     <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
    })
    </script>
    <!-- date start -->
  
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

    <!-- date end -->
   
</body>
</html>