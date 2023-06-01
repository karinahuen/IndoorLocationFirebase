<?php
    include 'connection.php';
    include 'flag_msg.php';

    header('Content-type: application/json');

    $result_array = array();
    $beacon_type =  null;

    $deviceId = isset($_GET['dId']) ? $_GET['dId'] : '';
    $regId = isset($_GET['regId']) ? $_GET['regId'] : '';

    if($deviceId){   
        $sql = "SELECT * FROM users WHERE device_id = '".$deviceId."'";
        $result = mysqli_query($conn, $sql); 

        if (!empty($result)) {
            if (mysqli_num_rows($result) > 0) {
                $checkSql = "SELECT * FROM users WHERE reg_id ='$regId'";
                $checkResult = mysqli_query($conn, $checkSql);

                if (!empty($checkResult)) {
                    if (mysqli_num_rows($checkResult) == 0) {                
                        $regSql = "UPDATE fypMysql.users SET reg_id = '$regId' WHERE device_id = '$deviceId'";
                        $regResult = mysqli_query($conn, $regSql); 

                        if($regResult){
                            $result_array["message"] = $success;
                            $result_array["isFirst"] = "update";
                        }
                    }
                    else{
                        $result_array["message"] = "have record";
                        $result_array["isFirst"] = "false";
                    }
                }
            }
            else{
                $insertDevice = "INSERT INTO fypMysql.users(device_id, reg_id) VALUES ('$deviceId', '$regId')";
                $intResult = mysqli_query($conn, $insertDevice); 

                if($intResult){
                    $result_array["message"] = $success;
                    $result_array["isFirst"] = "true";
                }
                else{
                    $result_array["message"] = "error";
                }
            }
            
        }
    }
    else {
        $result_array['message'] = $not_result;
    }
            
    echo json_encode($result_array);
    mysqli_close($conn);

?>