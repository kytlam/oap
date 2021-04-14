<?php
include_once dirname(dirname(__FILE__)).'/dal/dbconnect.php';

function getappointmentScheduleList($role = null, $loginId = null, $appdate = null, $schId=0, $appId=0) {
    global $db_conn;
    $condition = [];
    if(!is_null($role) && !is_null($loginId)) {
        if($role == "d") {
            array_push($condition," d.doctorId = '$loginId'");
        } elseif($role == "p") {
            array_push($condition," pat.username = '$loginId'");
        } 
    }
    if(!is_null($appdate)) {
        array_push($condition," dsc.scheduleDate = '$appdate'");
    }
    if($schId > 0) {
        array_push($condition," dsc.scheduleId = '$schId'");
    }
    if($appId > 0) {
        array_push($condition," app.appId = '$appId'");
    }
    $condition_str="";
    if(count($condition) > 0) {
        $condition_str=implode(" AND ", $condition);
        $condition_str=" WHERE $condition_str";
    }
    $query ="SELECT pat.*, app.*, dsc.*
        FROM patient pat
        INNER JOIN appointment app
        ON pat.icPatient = app.icPatient AND app.deletedAt IS NULL
        INNER JOIN doctorschedule dsc
        ON app.scheduleId=dsc.scheduleId AND dsc.deletedAt IS NULL
        INNER JOIN doctor d 
        ON dsc.icDoctor = d.icDoctor
        {$condition_str}
        ORDER BY appId DESC";
        // var_dump($query);die();
    $res=mysqli_query($db_conn,$query);
    if (!$res) {
        var_dump(mysqli_error($db_conn));die();
    }
    
    $result = [];
    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $result[]=$row;
    }
    return $result;
}

function makeAppointment($post_data) {
    global $db_conn;
    $icPatient = mysqli_real_escape_string($db_conn, $post_data['icPatient']);
    $scheduleid = mysqli_real_escape_string($db_conn,$post_data['scheduleid']);
    $symptom = mysqli_real_escape_string($db_conn,$post_data['symptom']);
    $comment = mysqli_real_escape_string($db_conn,$post_data['comment']);
    $status = mysqli_real_escape_string($db_conn,$post_data['status']);

    $query = "INSERT INTO appointment (icPatient, scheduleId, appSymptom, appComment, `status`)
    VALUES ($icPatient,$scheduleid, '$symptom','$comment', '$status')";
    $result = mysqli_query($db_conn, $query);
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