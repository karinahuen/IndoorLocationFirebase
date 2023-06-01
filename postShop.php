<?php
    include 'connection.php';
    include 'flag_msg.php';

    header('Content-type: application/json');

    $result_array = array();

    $sql = "SELECT DISTINCT(`beacon_type`) , `icon`, `name`  FROM beacon";
    $result = mysqli_query($conn, $sql); 

    if (!empty($result)) {

        $result_array['shop'] = array();
        while($row = mysqli_fetch_array($result)) {
            $res = array();
            $res["name"] = $row["name"];
            $res["icon"] = $row["icon"];
            $res["beacon_type"] = $row["beacon_type"];
            array_push($result_array['shop'], $res);

        }
        $result_array['message'] = $success;
    }
    else{
        $result_array['message'] = $not_result;
    }

    echo json_encode($result_array);
    mysqli_close($conn);

?>