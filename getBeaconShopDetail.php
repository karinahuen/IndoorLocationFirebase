<?php
    include 'connection.php';
    include 'flag_msg.php';

    header('Content-type: application/json');

    $result_array = array();
    $btype =  null;

    $uuid = isset($_GET['uuid']) ? $_GET['uuid'] : '';
    $major = isset($_GET['major']) ? $_GET['major'] : '';
    $minor = isset($_GET['minor']) ? $_GET['minor'] : '';

    //beacon 
    $sql = "SELECT * FROM beacon WHERE uuid = '".$uuid."' 
    and major = '".$major."' and minor = '".$minor."'";
    $bResult = mysqli_query($conn, $sql); 


    if($uuid && $major && $minor){   
        if (!empty($bResult)) {

            $result_array["beacon_shop"] = array();
            // output data of each row
            while($row = mysqli_fetch_array($bResult)) {
                $res = array();
                $res["name"] = $row["name"];
                $result_array["beacon_shop"] = $res;
                //get beacon type
                $btype =  $row["beacon_type"];
            }

            //shop detail
            $inforSql = "SELECT * FROM shopDetail WHERE beacon_type = $btype";
            $infoResult = mysqli_query($conn, $inforSql); 

            if(!empty($infoResult)){
                $result_array['beacon_shop_detail'] = array();
                while($row = mysqli_fetch_array($infoResult)) {
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
                    array_push($result_array['beacon_shop_detail'], $res);
                }

                $result_array['message'] = $success;
            }
            else{
                $result_array['message'] = $not_result;
            }

            //all shop event
            $eventSql = "SELECT * FROM eventShopDetail WHERE beacon_type = '".$btype."' ORDER BY createTime desc";
            $eventResult = mysqli_query($conn, $eventSql); 
            if (!empty($eventResult)) {
                $result_array['beacon_shop_event'] = array();
                while($row = mysqli_fetch_array($eventResult)) {
                    $res = array();

                    $res["eName"] = $row["event_name"];
                    $res["edescp"] = $row["event_desp"];
                    $res["qrcode"] = $row["qrcode"];
                    $res["beacon_type"] = $row["beacon_type"];
                    $formatteddate = date('Y-m-d', strtotime($row["createTime"]));
                    $res["date"] = $formatteddate;
                    array_push($result_array['beacon_shop_event'], $res);
                }
                $result_array['message'] = $success;
            }
            else{
                $result_array['message'] = $not_result;
            }
        }
        else{
            $result_array['error_msg'] = $bResult_error;
        }
    }
    else {
        $result_array['message'] = $not_result;
    }
            
    echo json_encode($result_array);
    mysqli_close($conn);

?>