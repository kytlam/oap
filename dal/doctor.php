<?php
include_once dirname(dirname(__FILE__)).'/dal/dbconnect.php';

function doctorLogin($post_data) {
    global $db_conn;

    $doctorId = mysqli_real_escape_string($db_conn,$post_data['doctorId']);
    $password  = mysqli_real_escape_string($db_conn,$post_data['password']);

    $row = getDoctor($doctorId);

    return [
        "success" => ($row['password'] === get_hash($password)),
        "doctorId" => $row['doctorId']
    ];
}

function getDoctor($doctorId) {
    global $db_conn;
    $res=mysqli_query($db_conn,  "SELECT * FROM doctor WHERE doctorId = '$doctorId' LIMIT 1");
    if($res === false) {
        return NULL;
    }
    $userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);
    return $userRow;
}

function updateDoctors($post_data) {
    global $db_conn;
    
    $doctorId = mysqli_real_escape_string($db_conn, $post_data['doctorId']);
    $doctorFirstName = mysqli_real_escape_string($db_conn, $post_data['doctorFirstName']);
    $doctorFirstName = mysqli_real_escape_string($db_conn, $post_data['doctorFirstName']);
    $doctorLastName = mysqli_real_escape_string($db_conn, $post_data['doctorLastName']);
    $doctorPhone = mysqli_real_escape_string($db_conn, $post_data['doctorPhone']);
    $doctorEmail = mysqli_real_escape_string($db_conn, $post_data['doctorEmail']);
    $doctorAddress = mysqli_real_escape_string($db_conn, $post_data['doctorAddress']);
    $doctorDOB = mysqli_real_escape_string($db_conn, $post_data['doctorDOB']);
    $isAdmin = mysqli_real_escape_string($db_conn, $post_data['isAdmin']);

    if(strtolower($isAdmin)=="on" || strtolower($isAdmin)=="checked" || strtolower($isAdmin)=="true") {
        $isAdmin="1";
    } else {
        $isAdmin="0";
    }

    $query = "UPDATE doctor SET 
            doctorFirstName='$doctorFirstName', 
            doctorLastName='$doctorLastName', 
            doctorPhone='$doctorPhone', 
            doctorEmail='$doctorEmail', 
            doctorAddress='$doctorAddress',
            doctorDOB='$doctorDOB',
            isAdmin=$isAdmin
        WHERE doctorId='$doctorId' ";
        var_dump($query);
    $result = mysqli_query($db_conn, $query);
    if(!$result) {
        var_dump(mysqli_error($db_conn));die();
    }
    return $result;


}


?>