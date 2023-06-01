<?php
    include 'connection.php';
    include 'flag_msg.php';

    header('Content-type: application/json');

    $btype = isset($_GET['btype']) ? $_GET['btype'] : '';

    $result_array = array();

    //shope title
    $nameSql = "SELECT name FROM beacon WHERE beacon_type = $btype";
    $nameResult = mysqli_query($conn, $nameSql); 

    //shope detail
    $sql = "SELECT * FROM shopDetail WHERE beacon_type = $btype";
    $result = mysqli_query($conn, $sql); 

    //shop event list
    $eventSql = "SELECT * FROM eventShopDetail WHERE beacon_type = '".$btype."' ORDER BY createTime desc";
    $eventResult = mysqli_query($conn, $eventSql); 

    if($btype){
        //shop detail
        if (!empty($result)) {

            $result_array["beacon_shop"] = array();
            // output data of each row
            while($row = mysqli_fetch_array($nameResult)) {
                $res = array();
                $res["name"] = $row["name"];
                $result_array["beacon_shop"] = $res;
            }

            $result_array['shop_detail'] = array();
            while($row = mysqli_fetch_array($result)) {
                $res = array();

                $res["descp"] = $row["description"];
                $res["img1"] = $row["img_1"];
                $res["img2"] = $row["img_2"];
                $res["img3"] = $row["img_3"];
                $res["img4"] = $row["img_4"];
                $res["address"] = $row["address"];
                $res["lat"] = $row["latitude"];
                $res["longit"] = $row["longitude"];
                $res["beacon_type"] = $row["beacon_type"];
                array_push($result_array['shop_detail'], $res);

            }
        
            $result_array['message'] = $success;
        }
        else{
            $result_array['message'] = $not_result;
        }

        //event
        if (!empty($eventResult)) {
            $result_array['shop_event'] = array();
            while($row = mysqli_fetch_array($eventResult)) {
                $res = array();

                $res["eName"] = $row["event_name"];
                $res["edescp"] = $row["event_desp"];
                $res["qrcode"] = $row["qrcode"];
                $formatteddate = date('Y-m-d', strtotime($row["createTime"]));
                $res["date"] = $formatteddate;
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