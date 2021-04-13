<?php
include_once dirname(dirname(__FILE__)).'/dal/dbconnect.php';

function register($post_data) {
    global $db_conn;
    
    $username = mysqli_real_escape_string($db_conn,$post_data['username']);
    $row = getPatient($username);
    if(!is_null($row)) {
        return "Username is used by someone";
    }

    $password         = mysqli_real_escape_string($db_conn,$post_data['password']);
    $confirm_password         = mysqli_real_escape_string($db_conn,$post_data['confirm_password']);
    if($password !== $confirm_password) {
        return "Password and confirm password are not matched";
    }

    $patientEmail     = mysqli_real_escape_string($db_conn,$post_data['patientEmail']);
    $row = getPatientByEmail($patientEmail);
    if(!is_null($row)) {
        return "Email is used by someone";
    }

    $patientFirstName = mysqli_real_escape_string($db_conn,$post_data['patientFirstName']);
    $patientLastName  = mysqli_real_escape_string($db_conn,$post_data['patientLastName']);
    $regDOB            = mysqli_real_escape_string($db_conn,$post_data['regDOB']);
    $patientGender = mysqli_real_escape_string($db_conn,$post_data['patientGender']);
    $patientAddress = mysqli_real_escape_string($db_conn,$post_data['patientAddress']);
    $patientPhone = mysqli_real_escape_string($db_conn,$post_data['patientPhone']);
    
    $password = get_hash($password);
    $query = "INSERT INTO `patient` (`username`, `password`, `patientFirstName`, `patientLastName`, `patientMaritialStatus`, `patientDOB`, `patientGender`, `patientAddress`, `patientPhone`, `patientEmail`) VALUES
        ('$username', '$password', '$patientFirstName', '$patientLastName', 'na', '$regDOB', '$patientGender', '$patientAddress', '$patientPhone', '$patientEmail')";
    $result = mysqli_query($db_conn, $query);
    return $result ? "done" : "Fail to register";
}
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

function getPatientByEmail($email) {
    global $db_conn;
    $res=mysqli_query($db_conn,  "SELECT * FROM patient WHERE patientEmail = '$email' LIMIT 1");
    if($res === false) {
        return NULL;
    }
    $result=mysqli_fetch_array($res,MYSQLI_ASSOC);
    return $result;
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

function deletePatient($id) {
    global $db_conn;
    $now = date("Y-m-d H:i:s");
    $query = " UPDATE patient SET
            deletedAt = '$now'
        WHERE icpatient = $id ";
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