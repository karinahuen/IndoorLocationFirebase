<!-- <!DOCTYPE html>
<html lang="en">
<body>
    <img width="30" height="30" src="view.php?id=1" />
</body>
</html> -->
<?php

    include 'connection.php';
       
    //Get image data from database
    $result = $conn->query("SELECT qrCode FROM inforDetail WHERE id = 2");
    
    if($result->num_rows > 0){
        $imgData = $result->fetch_assoc();
    
        // echo '<img src="images/gallery/'.$imgData['icon'].'.jpg" height="100" width="100"/>';
        // echo $imgData['icon']; 
        echo '<img src="data:image/png;base64,'.base64_encode($imgData['qrCode']).'"/>';

    }else{
        echo 'Image not found...';
    }
    
?>