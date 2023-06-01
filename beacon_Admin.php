<!DOCTYPE html>
<html lang="en">
    <head>
        <title>IndoorLocation Tracking User Access Beacon Backend</title>
        <link rel="stylesheet" type="text/css" href="beacon_Admin.css">
    </head>
    <body>
    <?php
        include 'connection.php';
        include 'flag_msg.php';

        // beacon 
        $sql = "SELECT DISTINCT(`create_time`) , `device_id`, `shop_name`, `uuid`, `major`, `minor`  
        FROM notifiSetting ORDER BY `create_time` DESC";
        $bResult = mysqli_query($conn, $sql);
        
        if (!empty($bResult)) {
    ?>
        <h1>Beacon Access Backend</h1>
        <table cellpadding="0" cellspacing="0" border="0">
            <tr>
            <th>Shop Name</th><th>Device ID</th>
            <th>Beacon UUid</th><th>Beacon Major</th>
            <th>Beacon Minor</th><th>Entry Time</th>
            </tr>
        <?php 
                while($row = mysqli_fetch_array($bResult)) {
        ?>
                    <tr>
                    <td class="large_width"><?php echo $row['shop_name']; ?></td>
                    <td class="large_width"><?php echo $row['device_id']; ?></td>
                    <td class="large_width"><?php echo $row['uuid']; ?></td>
                    <td><?php echo $row['major']; ?></td>
                    <td><?php echo $row['minor']; ?></td>
                    <td class="large_width"><?php echo $row['create_time']; ?></td>
                    </tr>
        <?php 
                }
            } 
            mysqli_close($conn);
        ?>  

    </body>
</html>