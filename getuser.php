<?php
include_once 'dal/schedule.php';
$q = $_GET['q'];
// echo $q;
$result=getscheduleByDate($q);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
    
</head>
<body>
     <?php 

        if (count($result)==0) {

            echo "<div class='alert alert-danger' role='alert'>Doctor is not available at the moment. Please try again later.</div>";
                
        } else {
            echo "   <table class='table table-hover'>";
            echo " <thead>";
            echo " <tr>";
                echo " <th>Day</th>";
                echo " <th>Date</th>";
               echo "  <th>Start</th>";
               echo "  <th>End</th>";
                echo " <th>Availability</th>";
            echo " </tr>";
       echo "  </thead>";
       echo "  <tbody>";
            foreach ($result as $row) {

            ?>

            <tr>
                <?php

                // $avail=null;
                if (!$row['isAvailable']) {
                $avail="danger";
                } else {
                $avail="primary";
                
            }
                echo "<td>" . getScheduleDay($row['scheduleDate']) . "</td>";
                echo "<td>" . $row['scheduleDate'] . "</td>";
                echo "<td>" . $row['startTime'] . "</td>";
                echo "<td>" . $row['endTime'] . "</td>";
                echo "<td> <span class='label label-".$avail."'>". ($row['isAvailable'] ? "YES" : "NO") ."</span></td>";
                ?>
            </tr>
        <?php
    }
}
    ?>
        </tbody>
    </body>
</html>