<?php
include_once dirname(dirname(__FILE__)).'/dal/dbconnect.php';

function patientLogin($post_data) {
    global $db_conn;

    $username = mysqli_real_escape_string($db_conn,$post_data['username']);
    $password  = mysqli_real_escape_string($db_conn,$post_data['password']);

    $row = getPatient($username);
    return [
        "success" => ($row['password'] === get_hash($password)),
        "username" => $row['username']
    ];
}

function getPatient($username) {
    global $db_conn;
    $res=mysqli_query($db_conn,  "SELECT * FROM patient WHERE username = '$username' LIMIT 1");
    if($res === false) {
        return NULL;
    }
    $result=mysqli_fetch_array($res,MYSQLI_ASSOC);
    return $result;
}

function getPatientList(){
    global$db_conn;
    $res=mysqli_query($db_conn, "SELECT * FROM patient WHERE deletedAt IS NULL");
    if(!$res) {
        var_dump(mysqli_error($db_conn));die();
    }
    $result = [];
    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $result[]=$row;
    }
    return $result;
}

function updatePatients($post_data) {
    global $db_conn;
    
    //variables
    $patientFirstName =  mysqli_real_escape_string($db_conn, $post_data['patientFirstName']);
    $patientLastName =  mysqli_real_escape_string($db_conn, $post_data['patientLastName']);
    $patientMaritialStatus =  mysqli_real_escape_string($db_conn, $post_data['patientMaritialStatus']);
    $patientDOB =  mysqli_real_escape_string($db_conn, $post_data['patientDOB']);
    $patientGender =  mysqli_real_escape_string($db_conn, $post_data['patientGender']);
    $patientAddress =  mysqli_real_escape_string($db_conn, $post_data['patientAddress']);
    $patientPhone =  mysqli_real_escape_string($db_conn, $post_data['patientPhone']);
    $patientEmail =  mysqli_real_escape_string($db_conn, $post_data['patientEmail']);
    $username =  mysqli_real_escape_string($db_conn, $post_data['username']);

    $query = "UPDATE patient SET 
        patientFirstName='$patientFirstName',
        patientLastName='$patientLastName', 
        patientMaritialStatus='$patientMaritialStatus', 
        patientDOB='$patientDOB', 
        patientGender='$patientGender', 
        patientAddress='$patientAddress', 
        patientPhone=$patientPhone,
        patientEmail='$patientEmail' 
        WHERE username='$username' ";
    // var_dump($query);die();
    $result = mysqli_query($db_conn, $query);
    if(!$result) {
        var_dump(mysqli_error($db_conn));die();
    }
    return $result;
}

?>