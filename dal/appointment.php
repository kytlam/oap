<?php
include_once dirname(dirname(__FILE__)).'/dal/dbconnect.php';

function getappointmentScheduleList($role = null, $lgoinId = null) {
    global $db_conn;
    $condition = "";
    if(!is_null($role) && !is_null($lgoinId)) {
        if($role == "d") {
            $condition = " WHERE dsc.icDoctor = '$lgoinId'";
        } elseif($role == "p") {
            $condition = " WHERE pat.username = '$lgoinId'";
        } 
    }
    $query ="SELECT pat.*, app.*, dsc.*
    FROM patient pat
    JOIN appointment app
    On pat.icPatient = app.icPatient
    JOIN doctorschedule dsc
    On app.scheduleId=dsc.scheduleId
    {$condition}
    Order By appId desc";
    $res=mysqli_query($db_conn,$query);
    if (!$res) {
        var_dump(mysqli_error($db_conn));die();
    }
    $result=mysqli_fetch_array($res);
    return $result;
}

function updateAppointmentStatus($appId, $status) {
    global $db_conn;
    $query = "UPDATE appointment SET status='$status' WHERE appId=$appId";
    $result=mysqli_query($db_conn, $query);
    if(!$result) {
        var_dump(mysqli_error($db_conn));die();
    }
    
    return isset($result);
}

function deleteAppointment($appid){
    global $db_conn;
    $now = date("Y-m-d H:i:s");
    $query = " UPDATE appointment SET 
            deletedAt = '$now'  
            WHERE appId=$appid";
    $result = mysqli_query($db_conn, $query);
    if(!$result) {
        var_dump(mysqli_error($db_conn));die();
    }
    if(isset($result)) {
       echo "1";
    } else {
       echo "0";
    }
}

?>