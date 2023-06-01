<?php
    include 'connection.php';
    include 'flag_msg.php';

    header('Content-type: application/json');

    $sql = "SELECT * FROM beacon";
    $result = mysqli_query($conn, $sql); 
    $result_array = array();

    if (!empty($result)) {

        $result_array["beacon"] = array();

        // output data of each row
        while($row = mysqli_fetch_array($result)) {
            $res = array();
            $res["id"] = $row["bid"];
            $res["uuid"] = $row["uuid"];
            $res["major"] = $row["major"];
            $res["minor"] = $row["minor"];
            $res["beacon_type"] = $row["beacon_type"];
            array_push($result_array["beacon"], $res);
        }
        $result_array['message'] = $success;
        echo json_encode($result_array);
    } 
    else {
        echo $null_result;
    }


    mysqli_close($conn);
?>