<?php

include 'connection.php';

if(isset($_POST["submit"])){
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        /*
         * Insert image data into database
         */
        
        //Create connection and select DB
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }
        
        $dataTime = date("Y-m-d H:i:s");
        
        //Insert image content into database
        $insert = $conn->query("UPDATE inforDetail SET qrCode = '$imgContent' WHERE id = 2" );
        if($insert){
            echo "File uploaded successfully.";
        }else{
            echo "File upload failed, please try again.";
        } 
    }else{
        echo "Please select an image file to upload.";
    }
}
?>