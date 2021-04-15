<?php
session_start();
include_once dirname(dirname(__FILE__)).'/dal/doctor.php';
include_once dirname(dirname(__FILE__)).'/dal/schedule.php';
if(!isset($_SESSION['doctorSession']))
{
    header("Location: ../index.php");
}
$page="schedule";
$usersession = $_SESSION['doctorSession'];
$userRow=getDoctor($usersession);
if(($userRow==NULL)){
    header("Location: ../index.php");
}
$src='//'.WEB_HOST.'/'.DIR.'/';
$ACTION = 'Add';
if(isset($_GET['schedule_update'])) {
    $update_id = $_GET['schedule_update'];
    $ACTION = 'Update';
    $schedule=getSchedule($update_id);
    if($schedule==NULL) {
        header("Location: addschedule.php");
    }
}
// insert
if (isset($_POST['submit'])) {
    $post_data = $_POST;
    unset($_POST);
    $result = updateOrCreate($post_data);
    if( $result )
    {
?>
    <script type="text/javascript">
    alert('Schedule added successfully.');
    window.location.replace("addschedule.php");
    </script>   
<?php
    } else {
?>
    <script type="text/javascript">
    alert('Added fail. Please try again.');
    window.location.replace("addschedule.php");
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
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Welcome Dr <?php echo $userRow['doctorFirstName'];?> <?php echo $userRow['doctorLastName'];?></title>
        <link href="assets/css/material.css" rel="stylesheet">
        <link href="assets/css/sb-admin.css" rel="stylesheet">
        <link href="assets/css/time/bootstrap-clockpicker.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 
        <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

        <!-- Inline CSS based on choices in "Settings" tab -->
        <style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>

        <!-- Custom Fonts -->
    </head>
    <body>
        <div id="wrapper">
            <?php include_once 'navbar.php'; ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">
                            Doctor Schedule
                            </h2>
                        </div>
                    </div>
                    <!-- Page Heading end-->

                    <!-- panel start -->
                    <div class="panel panel-primary">

                        <!-- panel heading starat -->
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= $ACTION ?> Schedule</h3>
                        </div>
                        <!-- panel heading end -->

                        <div class="panel-body">
                        <!-- panel content start -->
                            <div class="bootstrap-iso">
                             <div class="container-fluid">
                              <div class="row">
                               <div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form-horizontal" method="post" >
                                    <?php if($ACTION === "Update" ) {?>
                                    <input type="hidden" id="update_id" name="update_id" value="<?= $update_id ?>" />
                                    <?php } ?>
                                    <input type="hidden" id="action" name="action" value="<?= $ACTION ?>" />
                                    <input type="hidden" id="dId" name="dID" value="<?= $userRow['icDoctor'] ?>" />
                                 <div class="form-group form-group-lg">
                                  <label class="control-label col-sm-2 requiredField" for="date">
                                   Date
                                   <span class="asteriskField">
                                    *
                                   </span>
                                  </label>
                                  <div class="col-sm-10">
                                   <div class="input-group">
                                    <div class="input-group-addon">
                                     <i class="fa fa-calendar">
                                     </i>
                                    </div>
                                    <?php if(isset($schedule) && isset($schedule['scheduleDate'])) {?>
                                    <input class="form-control" id="date" name="date" type="text" value="<?= $schedule['scheduleDate'] ?>" required />
                                    <?php } else {?>
                                    <input class="form-control" id="date" name="date" type="text" required />
                                    <?php } ?>
                                   </div>
                                  </div>
                                 </div>
                                 <div class="form-group form-group-lg">
                                  <label class="control-label col-sm-2 requiredField" for="starttime">
                                   Start Time
                                   <span class="asteriskField">
                                    *
                                   </span>
                                  </label>

                                  <div class="col-sm-10">
                                   <div class="input-group clockpicker"  data-align="top" data-autoclose="true">
                                    <div class="input-group-addon">
                                     <i class="fa fa-clock-o">
                                     </i>
                                    </div>
                                    <?php if(isset($schedule) && isset($schedule['startTime'])) {?>
                                    <input class="form-control" id="starttime" name="starttime" type="text" value="<?= date("h:i", strtotime($schedule['startTime'])) ?>" required />
                                    <?php } else {?>
                                    <input class="form-control" id="starttime" name="starttime" type="text" required/>
                                    <?php } ?>
                                   </div>
                                  </div>
                                 </div>
                                 <div class="form-group form-group-lg">
                                  <label class="control-label col-sm-2 requiredField" for="endtime">
                                   End Time
                                   <span class="asteriskField">
                                    *
                                   </span>
                                  </label>
                                  <div class="col-sm-10">
                                   <div class="input-group clockpicker"  data-align="top" data-autoclose="true">
                                    <div class="input-group-addon">
                                     <i class="fa fa-clock-o">
                                     </i>
                                    </div>
                                    <?php if(isset($schedule) && isset($schedule['startTime'])) {?>
                                    <input class="form-control" id="endtime" name="endtime" type="text" value="<?= date("h:i", strtotime($schedule['endTime'])) ?>" required />
                                    <?php } else {?>
                                    <input class="form-control" id="endtime" name="endtime" type="text" required />
                                    <?php } ?>
                                   </div>
                                  </div>
                                 </div>
                                 <div class="form-group form-group-lg">
                                  <label class="control-label col-sm-2 requiredField" for="bookavail">
                                   Availabilty
                                   <span class="asteriskField">
                                    *
                                   </span>
                                  </label>
                                  <div class="col-sm-10">
                                   <select class="select form-control" id="bookavail" name="bookavail" required>
                                    <option value="1" <?= (isset($schedule) && isset($schedule['isAvailable']) ? ($schedule['isAvailable']==1 ? "selected=selected" : "") : ""  )?> >
                                        Available
                                    </option>
                                    <option value="0" <?= (isset($schedule) && isset($schedule['isAvailable']) ? ($schedule['isAvailable']==0 ? "selected=selected" : "") : ""  )?> >
                                        Not Available
                                    </option>
                                   </select>
                                  </div>
                                 </div>
                                 <div class="form-group">
                                  <div class="col-sm-10 col-sm-offset-2">
                                   <button class="btn btn-primary " name="submit" type="submit">
                                    Submit
                                   </button>
                                  </div>
                                 </div>
                                </form>
                               </div>
                              </div>
                             </div>
                            </div>                        
                        <!-- panel content end -->
                        <!-- panel end -->
                        </div>
                    </div>
                    <!-- panel start -->

                     <!-- panel start -->
                    <div class="panel panel-primary filterable">

                        <!-- panel heading starat -->
                        <div class="panel-heading">
                            <h3 class="panel-title">List of Patients</h3>
                            <div class="pull-right">
                            <button class="btn btn-default btn-xs btn-filter"><span class="fa fa-filter"></span> Filter</button>
                        </div>
                        </div>
                        <!-- panel heading end -->

                        <div class="panel-body">
                        <!-- panel content start -->
                           <!-- Table -->
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="scheduleId" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="scheduleDate" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="scheduleDay" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="startTime." disabled></th>
                                    <th><input type="text" class="form-control" placeholder="endTime" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="bookAvail" disabled></th>
                                    <th>Edit / Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $results = getScheduleList($userRow['icDoctor']);
                            foreach ($results as $doctorschedule) {
                                echo "<tr>";
                                    echo "<td>" . $doctorschedule['scheduleId'] . "</td>";
                                    echo "<td>" . $doctorschedule['scheduleDate'] . "</td>";
                                    echo "<td>" . getScheduleDay($doctorschedule['scheduleDate']) . "</td>";
                                    echo "<td>" . date("h:i", strtotime($doctorschedule['startTime'])) . "</td>";
                                    echo "<td>" . date("h:i", strtotime($doctorschedule['endTime'])) . "</td>";
                                    echo "<td>" . ($doctorschedule['isAvailable'] ? "YES" : "NO") . "</td>";
                                    echo "<td class='text-center'>
                                        <a href='addschedule.php?schedule_update=$doctorschedule[scheduleId]' class='update_schedule'>
                                        <span class='fa fa-pencil' aria-hidden='true'></span></a>
                                        <span>|</span>
                                        <a href='#' id='".$doctorschedule['scheduleId']."' class='delete remove_schedule'>
                                        <span class='fa fa-trash-o' aria-hidden='true'></span></a>
                                    </td>";
                                echo "</tr>";
                            } 
                            ?>
                        </tbody>
                       </table>
                        </div>
                    </div>
                </div>
            </div>
        <script src="<?= $src ?>assets/js/jquery.js"></script>
        
        <script src="<?= $src ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= $src ?>assets/js/bootstrap-clockpicker.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker.min.css"/>

<script>
    $(document).ready(function(){
    $('.clockpicker').clockpicker();
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy-mm-dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
        });
        $(".remove_schedule").click(function(){
            var element = $(this);
            var id = element.attr("id");
            var info = 'id=' + id;
            if(confirm("Are you sure you want to delete this?"))
            {
                $.ajax({
                type: "POST",
                url: "deleteschedule.php",
                data: info,
                success: function($result){
                    if($result == "1") {
                            alert('Schedule deleted successfully.');
                        } else {
                            alert('Unable to delete Schedule.');
                        }
                }
                });
            $(this).parent().parent().fadeOut(300, function(){ $(this).remove();});
            }
            return false;
        });
        /* dummy filter */
        $('.filterable .btn-filter').click(function(){
                    var $panel = $(this).parents('.filterable'),
                    $filters = $panel.find('.filters input'),
                    $tbody = $panel.find('.table tbody');
                    if ($filters.prop('disabled') == true) {
                        $filters.prop('disabled', false);
                        $filters.first().focus();
                    } else {
                        $filters.val('').prop('disabled', true);
                        $tbody.find('.no-result').remove();
                        $tbody.find('tr').show();
                    }
                });

                $('.filterable .filters input').keyup(function(e){
                    /* Ignore tab key */
                    var code = e.keyCode || e.which;
                    if (code == '9') return;
                    /* Useful DOM data and selectors */
                    var $input = $(this),
                    inputContent = $input.val().toLowerCase(),
                    $panel = $input.parents('.filterable'),
                    column = $panel.find('.filters th').index($input.parents('th')),
                    $table = $panel.find('.table'),
                    $rows = $table.find('tbody tr');
                    /* Dirtiest filter function ever ;) */
                    var $filteredRows = $rows.filter(function(){
                        var value = $(this).find('td').eq(column).text().toLowerCase();
                        return value.indexOf(inputContent) === -1;
                    });
                    /* Clean previous no-result if exist */
                    $table.find('tbody .no-result').remove();
                    /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
                    $rows.show();
                    $filteredRows.hide();
                    /* Prepend no-result row if all rows are filtered */
                    if ($filteredRows.length === $rows.length) {
                        $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
                    }
                });
    })
</script>

    </body>
</html>