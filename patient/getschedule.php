<?php
session_start();
include_once dirname(dirname(__FILE__)).'/dal/schedule.php';
$q=$_GET['q'];
$result=getscheduleByDate($q);
$src='//'.WEB_HOST.'/'.DIR.'/';
?>
<div>
    <link href="<?= $src ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <?php
    if (count($result)==0) {
    echo "<div class='alert alert-danger' role='alert'>Doctor is not available at the moment. Please try again later.</div>";
    
    } else {
    echo "   <table class='table table-hover'>";
        echo " <thead>";
            echo " <tr>";
                echo " <th>App Id</th>";
                echo " <th>Day</th>";
                echo " <th>Date</th>";
                echo "  <th>Start Time</th>";
                echo "  <th>End Time</th>";
                echo " <th>Availability</th>";
                echo "  <th>Book Now!</th>";
            echo " </tr>";
        echo "  </thead>";
        echo "  <tbody>";
        foreach ($result as $row) {
            ?>
            <tr>
                <?php
                // $avail=null;
                // $btnclick="";
                if (!$row['isAvailable']) {
                $avail="danger";
                $btnstate="disabled";
                $btnclick="danger";
                } else {
                $avail="primary";
                $btnstate="";
                $btnclick="primary";
                }

                
                // if ($rowapp['bookAvail']!="available") {
                // $btnstate="disabled";
                // } else {
                // $btnstate="";
                // }
                echo "<td>" . $row['scheduleId'] . "</td>";
                echo "<td>" . getScheduleDay($row['scheduleDate']) . "</td>";
                echo "<td>" . $row['scheduleDate'] . "</td>";
                echo "<td>" . date("h:i", strtotime($row['startTime'])) . "</td>";
                echo "<td>" . date("h:i", strtotime($row['endTime'])) . "</td>";
                echo "<td> <span class='label label-".$avail."'>". ($row['isAvailable'] ? "YES" : "NO") ."</span></td>";
                echo "<td><a href='appointment.php?&schId=" . $row['scheduleId'] . "&scheduleDate=".$q."' class='btn btn-".$btnclick." btn-xs' role='button' ".$btnstate.">Book Now</a></td>";
                // echo "<td><a href='appointment.php?&appid=" . $row['scheduleId'] . "&scheduleDate=".$q."'>Book</a></td>";
                // <td><button type='button' class='btn btn-primary btn-xs' data-toggle='modal' data-target='#exampleModal'>Book Now</button></td>";
                //triggered when modal is about to be shown
                ?>
                
                </script>
                <!-- ?> -->
            </tr>
            
            <?php
            }
            }
            ?>
        </tbody>
        <!-- modal start -->
</div>