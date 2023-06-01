<?php
    include 'connection.php';
    include 'flag_msg.php';

    header('Content-type: application/json');

    $btype = isset($_GET['btype']) ? $_GET['btype'] : '';

    $result_array = array();

    $eventSql = "SELECT * FROM eventShopDetail WHERE beacon_type = '".$btype."'";
    $eventResult = mysqli_query($conn, $eventSql); 
    

    if($btype){
        if (!empty($eventResult)) {

            $result_array['shop_event'] = array();
            while($row = mysqli_fetch_array($eventResult)) {
                $res = array();

                $res["descp"] = $row["event_description"];
                $res["eName"] = $row["event_name"];
                
                array_push($result_array['shop_event'], $res);
            }
        
            $result_array['message'] = $success;
        }
        else{
            $result_array['message'] = $not_result;
        }
    }
    else{
        $result_array['message'] = $error;
    }

    echo json_encode($result_array);
    mysqli_close($conn);

?>