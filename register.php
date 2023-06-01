<?php
    include 'connection.php';

    $password = "test123";
    $first_name = "admin1";
    $options = array("cost"=>4);
    $hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);

    $sql = "INSERT INTO fypMysql.administration (`username`, `password`) VALUES ('" .$first_name ."', '" .$hashPassword ."')";

        $query = mysqli_query($conn, $sql);
        if($query)

    {
        echo "Success!";
    }

    else{
        // echo "Error";
        die('There was an error running the query [' . $conn->error . ']');
    }
?>