<?php
include_once dirname(dirname(__FILE__)).'/dal/dbconnect.php';

function getSchedule($scheduleId, $date = null, $isAval=null) {
    global $db_conn;

    
    $condition = [];
    if(!is_null($date)) {
        array_push($condition," scheduleDate = '$date'");
    }
    if(!is_null($isAval) && is_bool($isAval)) {
        array_push($condition," isAvailable = $isAval");
    }
    $condition_str="";
    if(count($condition) > 0) {
        $condition_str=implode(" AND ", $condition);
        $condition_str=" AND $condition_str";
    }

    $query = "SELECT * FROM doctorschedule WHERE scheduleId = $scheduleId AND deletedAt IS NULL 
        $condition_str LIMIT 1";
    $res=mysqli_query($db_conn,  $query );
    if($res === false) {
        return NULL;
    }
    $result=mysqli_fetch_array($res,MYSQLI_ASSOC);
    return $result;
}
function getScheduleByDate($date) {
    global $db_conn;
    $res=mysqli_query($db_conn,  "SELECT * FROM doctorschedule WHERE scheduleDate='$date' AND deletedAt IS NULL");
    if(!$res) {
        var_dump(mysqli_error($db_conn));die();
    }
    $result = [];
    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $result[]=$row;
    }
    return $result;

}
function getScheduleList($ic_doc) {
    global $db_conn;
    
    $res=mysqli_query($db_conn,"SELECT * FROM doctorschedule WHERE icDoctor = $ic_doc AND deletedAt IS NULL");
    if (!$res) {
        var_dump(mysqli_error($db_conn));die();
    }
    $result = [];
    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $result[]=$row;
    }
    return $result;
}
    

function updateOrCreate($post_data) {
    global $db_conn;
    if($post_data['action'] === "Update") {
        if(!isset($post_data['update_id'])) { return NULL; }
        $update_id = mysqli_real_escape_string($db_conn, $post_data['update_id']);
    }
    $date = mysqli_real_escape_string($db_conn, $post_data['date']);
    $starttime   = mysqli_real_escape_string($db_conn, $post_data['starttime']);
    $endtime     = mysqli_real_escape_string($db_conn, $post_data['endtime']);
    $bookavail         = mysqli_real_escape_string($db_conn, $post_data['bookavail']);
    $dID         = mysqli_real_escape_string($db_conn, $post_data['dID']);
    $starttime= str_replace(":00", "",$starttime );
    $query="";
    //INSERT
    if($post_data['action'] === "Add") {
        $query = " INSERT INTO doctorschedule (  scheduleDate, startTime, endTime,  isAvailable, icDoctor )
        VALUES ( '$date', '$starttime', '$endtime', '$bookavail', $dID ) ";
    } else if($post_data['action'] === "Update") {
        $query = " UPDATE doctorschedule SET
            scheduleDate = '$date',
            startTime = '$starttime',
            endTime = '$endtime',
            isAvailable = '$bookavail'
        WHERE scheduleId = $update_id AND icDoctor = $dID ";
    }
    $result = mysqli_query($db_conn, $query);
    if(!$result) {
        var_dump(mysqli_error($db_conn));die();
    }
    return $result;
}

function deleteSchedule($id) {
    global $db_conn;
    // $delete = mysqli_query($db_conn,"DELETE FROM doctorschedule WHERE scheduleId=$id");
    $now = date("Y-m-d H:i:s");
    $query = " UPDATE doctorschedule SET
            deletedAt = '$now'
        WHERE scheduleId = $id ";

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

function getScheduleDay($date) {
    $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');
    return $days[date('w', strtotime($date))];
}

?>