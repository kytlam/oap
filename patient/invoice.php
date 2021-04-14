<?php
session_start();
include_once dirname(dirname(__FILE__)).'/dal/patient.php';
include_once dirname(dirname(__FILE__)).'/dal/schedule.php';
include_once dirname(dirname(__FILE__)).'/dal/appointment.php';
if (isset($_GET['appid'])) {
$appid=$_GET['appid'];
}
if(!isset($_SESSION['patientSession']))
{
	header("Location: ../index.php");
}

$src='//'.WEB_HOST.'/'.DIR.'/';
$usersession = $_SESSION['patientSession'];
$userRow=getPatient($usersession);
if(($userRow==NULL)){
    header("Location: ../index.php");
}
$src='//'.WEB_HOST.'/'.DIR.'/';
$results=getappointmentScheduleList(null,null, null , 0, $appid);
$result=$results[0];
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>HTML invoice- Online Appointment Portal</title>
        <meta name="robots" content="noindex">
        <link rel="stylesheet" type="text/css" href="<?= $src ?>assets/css/invoice.css">
    </head>
    <body>
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="<?= $src ?>assets/img/logo.png" style="width:100%; max-width:300px;">
                                </td>
                                
                                <td>
                                    Invoice #: <?php echo $result['appId'];?><br>
                                    Created: <?php echo date("d-m-Y");?><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    <?php echo $userRow['patientAddress'];?>
                                </td>
                                
                                <td><?php echo $userRow['icPatient'];?><br>
                                    <?php echo $userRow['patientFirstName'];?> <?php echo $userRow['patientLastName'];?><br>
                                    <?php echo $userRow['patientEmail'];?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                
                
                <tr class="heading">
                    <td>
                        Appointment Details
                    </td>
                    
                    <td>
                        #
                    </td>
                </tr>
                
                <tr class="item">
                    <td>
                        Appointment ID
                    </td>
                    
                    <td>
                       <?php echo $result['appId'];?>
                    </td>
                </tr>
                
                <tr class="item">
                    <td>
                        Schedule ID
                    </td>
                    
                    <td>
                        <?php echo $result['scheduleId'];?>
                    </td>
                </tr>

                <tr class="item">
                    <td>
                        Appointment Day
                    </td>
                    
                    <td>
                        <?php echo getScheduleDay($result['scheduleDate'])?>
                    </td>
                </tr>
                

                 <tr class="item">
                    <td>
                        Appointment Date
                    </td>
                    
                    <td>
                        <?php echo $result['scheduleDate'];?>
                    </td>
                </tr>

                 <tr class="item">
                    <td>
                        Appointment Time
                    </td>
                    
                    <td>
                        <?php echo $result['startTime'];?> untill <?php echo $result['endTime'];?>
                    </td>
                </tr>

                 <tr class="item">
                    <td>
                        Patient Symptom
                    </td>
                    
                    <td>
                        <?php echo $result['appSymptom'];?> 
                    </td>
                </tr>
                
                
                
            </table>
        </div>
        <div class="print">
        <button onclick="myFunction()">Print this page</button>
</div>
<script>
function myFunction() {
    window.print();
}
</script>
    </body>
</html>