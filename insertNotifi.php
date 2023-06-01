<?php
    include 'connection.php';
    include 'flag_msg.php';

    header('Content-type: application/json');

    $device_id = isset($_GET['deviceId']) ? $_GET['deviceId'] : '';
    $uuid = isset($_GET['uuid']) ? $_GET['uuid'] : '';
    $major = isset($_GET['major']) ? $_GET['major'] : '';
    $minor = isset($_GET['minor']) ? $_GET['minor'] : '';


    //find the beacon shop name
    $findSql = "SELECT * FROM beacon WHERE uuid = '".$uuid."' AND major = '".$major."' AND minor = '".$minor."'";
    $findResult = mysqli_query($conn, $findSql); 

    $beaconName = null;

    $result_array = array();

    if($device_id && $uuid && $major && $minor){

        if (!empty($findResult)) {
            // output data of each row
            while($row = mysqli_fetch_array($findResult)) {
                $res = array();
                $beaconName = $row["name"];
            }
        }

        //create notifitication
        $mysql_date_now = date("Y-m-d H:i:s");
        $notifSql = "INSERT INTO fypMysql.notifiSetting(shop_name, create_time, uuid, major, minor, device_id) 
        VALUES ('".$beaconName."', '".$mysql_date_now."', '".$uuid."', '".$major."', '".$minor."', '".$device_id."')";
        $notifResult = mysqli_query($conn, $notifSql); 
        
        //success msg
        $result_array['message'] = $success;
    }
    else{
        $result_array['message'] = $not_result;
    }

    echo json_encode($result_array);
    mysqli_close($conn);

?>