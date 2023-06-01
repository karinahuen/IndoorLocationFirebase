<?php
    include 'connection.php';
    include 'flag_msg.php';

    header('Content-type: application/json');

    $result_array = array();
    $beacon_type =  null;

    $uuid = isset($_GET['uuid']) ? $_GET['uuid'] : '';
    $major = isset($_GET['major']) ? $_GET['major'] : '';
    $minor = isset($_GET['minor']) ? $_GET['minor'] : '';

    if($uuid && $major && $minor){   
        $sql = "SELECT * FROM beacon WHERE uuid = '".$uuid."' 
                and major = '".$major."' and minor = '".$minor."'";
        // $sql = "SELECT * FROM beacon WHERE uuid = 'fda50693-a4e2-4fb1-afcf-c6eb07857901' 
        //         and major = '18999' and minor = '14899'";
        $bResult = mysqli_query($conn, $sql); 

        if (!empty($bResult)) {

            $result_array["beacon"] = array();

            // output data of each row
            while($row = mysqli_fetch_array($bResult)) {
                $res = array();
                $res["name"] = $row["name"];
                $res["icon"] = $row["icon"];
                $result_array["beacon"] = $res;
                $beacon_type =  $row["beacon_type"];
            }

            $inforSql = "SELECT * FROM eventShopDetail WHERE beacon_type = $beacon_type 
                        and isHide = 0 Order By createTime desc";
            $infoResult = mysqli_query($conn, $inforSql); 

            if(!empty($infoResult)){
                $result_array["detail"] = array();

                while($row = mysqli_fetch_array($infoResult)) {
                    $res = array();
                    $res["event_name"] = $row["event_name"];
                    $res["event_description"] = $row["event_desp"];
                    $res["qrcode"] = $row["qrcode"];
                    $formatteddate = date('Y-m-d', strtotime($row["createTime"]));
                    $res["dateTime"] = $formatteddate;
                    array_push($result_array["detail"], $res);
                }
            }

            $result_array['message'] = $success;
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